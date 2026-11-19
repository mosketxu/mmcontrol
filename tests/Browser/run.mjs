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

  const contador = () => (() => { const m = document.body.innerText.match(/(\d+)\s+(?:a|to)\s+(\d+)\s+(?:de|of)\s+(\d+)/); return m ? [+m[2] - +m[1] + 1, +m[3]] : []; })();
  const filas = () => document.querySelectorAll('.accfila').length;

  // 1) Paginación por páginas en Productos (editorial) y Presupuestos (editorial)
  for (const [nombre, ruta] of [['Productos', '/producto/1'], ['Presupuestos', '/presupuesto/1/ruta/i']]) {
    await nav.ir(BASE + ruta);
    ok((await nav.eval(filas)) === 50, `${nombre}: 50 filas en la primera página`);
    ok(await nav.eval(() => !!document.querySelector('nav[role=navigation] [wire\\:click*="gotoPage"], nav[role=navigation] a[href*="page=2"], nav[role=navigation] button[wire\\:click*="nextPage"]')), `${nombre}: hay enlaces de páginas`);
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
