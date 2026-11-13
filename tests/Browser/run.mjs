// Pruebas en navegador real contra el servidor de desarrollo + BD de pruebas (tests/preparar_bd.sh). Salida distinta de 0 = fallo.
import { spawn, execSync } from 'node:child_process';
import { lanzar } from './cdp.mjs';

const PORT = 8123, BASE = `http://127.0.0.1:${PORT}`;
const env = { ...process.env, DB_CONNECTION: 'mysql', DB_HOST: '127.0.0.1', DB_PORT: '3307', DB_DATABASE: 't', DB_USERNAME: 'root', DB_PASSWORD: '', APP_ENV: 'local', APP_URL: BASE, SESSION_DRIVER: 'file', CACHE_DRIVER: 'file' };
const sock = `${process.env.HOME}/mm-testdb/my.sock`;
const hash = execSync("php -r 'echo password_hash(\"password\", PASSWORD_BCRYPT);'").toString().trim();
execSync(`mariadb --socket=${sock} t`, { input: `update users set password='${hash}' where id=1` }); // contraseña de prueba: «password»
const srv = spawn('php', ['-S', `127.0.0.1:${PORT}`, '-t', 'public'], { env, stdio: 'ignore' });
let fallos = 0; const ok = (c, m) => { console.log((c ? '  ok   ' : '  FALLA ') + m); if (!c) fallos++; };
let nav;
try {
  for (let i = 0; i < 40; i++) { try { await fetch(BASE + '/login'); break; } catch { await new Promise((r) => setTimeout(r, 250)); } }
  nav = await lanzar();
  await nav.ir(BASE + '/login');
  await nav.eval(() => { document.querySelector('input[name=email]').value = 'admin@admin.com'; document.querySelector('input[name=password]').value = 'password'; document.querySelector('input[name=email]').form.submit(); });
  try { await nav.esperar(() => !location.pathname.includes('login'), 15000); } catch (e) { console.log('URL: ' + await nav.eval(() => location.href) + ' | ' + (await nav.eval(() => document.body.innerText)).slice(0, 300)); throw e; }
  ok(true, 'login');

  const contador = () => (document.body.innerText.match(/Mostrando (\d+) de (\d+) resultados/) || []).slice(1).map(Number);
  const filas = () => document.querySelectorAll('.accfila').length;

  // 1) Scroll infinito en Productos (editorial) y Presupuestos (editorial)
  for (const [nombre, ruta] of [['Productos', '/producto/1'], ['Presupuestos', '/presupuesto/1/ruta/i']]) {
    await nav.ir(BASE + ruta);
    const [n0, total] = await nav.eval(contador);
    ok(n0 === 50 && total > 50, `${nombre}: primer lote ${n0} de ${total}`);
    await nav.eval(() => window.scrollTo(0, document.body.scrollHeight));
    await nav.esperar(() => (document.body.innerText.match(/Mostrando (\d+)/) || [])[1] >= 100, 15000);
    const [n1] = await nav.eval(contador);
    ok(n1 === 100, `${nombre}: tras bajar, ${n1} cargados`);
    ok((await nav.eval(filas)) === 100, `${nombre}: 100 filas en pantalla`);
    // un filtro vuelve al primer lote
    await nav.eval(() => window.scrollTo(0, 0));
  }

  // 1b) Pedidos y Compras (paginados por el controlador): al bajar se añade la página siguiente sin recargar
  for (const [nombre, ruta] of [['Pedidos', '/pedido/1/ruta/i?filtroestado=3&filtroanyo=2026'], ['Compras', '/compra/1/ruta/i']]) {
    await nav.ir(BASE + ruta);
    const [m0, mt] = await nav.eval(contador);
    if (!(mt > m0)) { ok(true, `${nombre}: solo ${mt} registros (sin segunda página)`); continue; }
    const f0 = await nav.eval(() => document.querySelectorAll('[data-lista-filas] > *').length);
    await nav.eval(() => window.scrollTo(0, document.body.scrollHeight));
    await nav.esperar(() => document.querySelectorAll('[data-lista-filas] > *').length > 30, 15000).catch(() => {});
    const f1 = await nav.eval(() => document.querySelectorAll('[data-lista-filas] > *').length);
    ok(f1 > f0, `${nombre}: ${f0} filas y tras bajar ${f1}`);
    const [m1] = await nav.eval(contador);
    ok(m1 === f1, `${nombre}: el contador (${m1}) coincide con las filas (${f1})`);
    const botones = await nav.eval(() => document.querySelectorAll('[data-lista-filas] .accfila').length);
    ok(botones === f1, `${nombre}: las filas nuevas traen sus botones de acciones (${botones})`);
    // las filas añadidas están «vivas» (Alpine/Livewire): el modal de la última fila se abre
    await nav.eval(() => { const b = [...document.querySelectorAll('[data-lista-filas] .accfila-btn')].pop(); b.click(); });
    const abre = await nav.esperar(() => { const m = [...document.querySelectorAll('[data-lista-filas] .accfila-modal')].pop(); return getComputedStyle(m).display !== 'none'; }, 5000).then(() => true, () => false);
    ok(abre, `${nombre}: el modal de una fila cargada por scroll se abre`);
    await nav.eval(() => { const m = [...document.querySelectorAll('[data-lista-filas] .accfila-modal')].pop(); m.click(); });
  }

  // 2) Volver conserva los filtros
  await nav.ir(BASE + '/producto/1?filtroreferencia=Aula');
  const [nf, tf] = await nav.eval(contador);
  ok(nf > 0 && tf < 2000, `Productos filtrado por «Aula»: ${nf} de ${tf}`);
  const idEdit = await nav.eval(() => { const d = document.querySelector('div[onclick*="/edit"]'); const m = d && d.getAttribute('onclick').match(/'([^']+)'/); return m ? m[1] : null; });
  ok(!!idEdit, 'hay fila que abre la ficha del producto');
  if (idEdit) {
    await nav.ir(idEdit);
    const hay = await nav.eval(() => !![...document.querySelectorAll('button')].find((b) => /volver/i.test(b.innerText)));
    ok(hay, 'ficha de producto con botón Volver');
    await nav.eval(() => [...document.querySelectorAll('button')].find((b) => /volver/i.test(b.innerText)).click());
    await nav.esperar(() => location.pathname.startsWith('/producto/1') && !location.pathname.includes('edit'), 15000);
    const url = await nav.eval(() => location.href);
    ok(url.includes('filtroreferencia=Aula'), `Volver recupera el filtro (${url.replace(BASE, '')})`);
  }

  // 3) Móvil: el modal de acciones en horizontal y sin etiquetas
  await nav.tamano(420, 800);
  await nav.ir(BASE + '/producto/1');
  await nav.eval(() => document.querySelector('.accfila-btn').click());
  await nav.esperar(() => getComputedStyle(document.querySelector('.accfila-modal')).display !== 'none', 5000);
  const dir = await nav.eval(() => getComputedStyle(document.querySelector('.accfila-grid')).flexDirection);
  ok(dir === 'row', `modal en móvil: dirección ${dir}`);
} catch (e) { console.log('  FALLA excepción: ' + e.message); fallos++; }
finally { nav?.cerrar(); srv.kill(); }
console.log(fallos ? `\n${fallos} fallo(s)` : '\nnavegador: todo bien');
process.exit(fallos ? 1 : 0);
