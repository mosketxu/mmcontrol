// Cliente mínimo del protocolo DevTools (Node 22, sin dependencias): lanza Chromium sin ventana y deja evaluar JS, navegar y esperar condiciones.
import { spawn } from 'node:child_process';
import { mkdtempSync } from 'node:fs';
import { tmpdir } from 'node:os';
import { join } from 'node:path';
import { homedir } from 'node:os';
import { readdirSync } from 'node:fs';

export function chromePath() {
  const base = join(homedir(), '.cache/ms-playwright');
  const d = readdirSync(base).filter((x) => x.startsWith('chromium-')).sort().pop();
  return join(base, d, 'chrome-linux64/chrome');
}

export async function lanzar({ ancho = 1400, alto = 900, puerto = 9333 } = {}) {
  const datos = mkdtempSync(join(tmpdir(), 'mm-chrome-'));
  const proc = spawn(chromePath(), ['--headless=new', '--no-sandbox', '--disable-gpu', `--remote-debugging-port=${puerto}`, `--user-data-dir=${datos}`, `--window-size=${ancho},${alto}`, 'about:blank'], { stdio: 'ignore' });
  let ws;
  for (let i = 0; i < 60 && !ws; i++) {
    try {
      const lista = await (await fetch(`http://127.0.0.1:${puerto}/json`)).json();
      ws = lista.find((t) => t.type === 'page')?.webSocketDebuggerUrl;
    } catch { await new Promise((r) => setTimeout(r, 250)); }
  }
  if (!ws) throw new Error('Chromium no arrancó');
  const sock = new WebSocket(ws);
  await new Promise((r) => (sock.onopen = r));
  let id = 0; const pend = new Map();
  sock.onmessage = (m) => { const d = JSON.parse(m.data); if (d.id && pend.has(d.id)) { pend.get(d.id)(d); pend.delete(d.id); } };
  const send = (method, params = {}) => new Promise((res, rej) => { const i = ++id; pend.set(i, (d) => (d.error ? rej(new Error(d.error.message)) : res(d.result))); sock.send(JSON.stringify({ id: i, method, params })); });
  await send('Page.enable'); await send('Runtime.enable');
  await send('Emulation.setDeviceMetricsOverride', { width: ancho, height: alto, deviceScaleFactor: 1, mobile: false });
  const api = {
    send,
    async ir(url) { await send('Page.navigate', { url }); await api.esperar(() => document.readyState === 'complete', 20000); await new Promise((r) => setTimeout(r, 600)); },
    async eval(fn, ...args) {
      const expr = `(${fn.toString()})(...${JSON.stringify(args)})`;
      const r = await send('Runtime.evaluate', { expression: expr, awaitPromise: true, returnByValue: true });
      if (r.exceptionDetails) throw new Error(r.exceptionDetails.exception?.description || 'error JS');
      return r.result.value;
    },
    async esperar(fn, ms = 10000, ...args) {
      const t0 = Date.now();
      while (Date.now() - t0 < ms) { try { if (await api.eval(fn, ...args)) return true; } catch {} await new Promise((r) => setTimeout(r, 250)); }
      throw new Error('tiempo agotado esperando: ' + fn.toString().slice(0, 120));
    },
    async tamano(ancho, alto) { await send('Emulation.setDeviceMetricsOverride', { width: ancho, height: alto, deviceScaleFactor: 1, mobile: ancho < 600 }); },
    async captura(ruta) { const r = await send('Page.captureScreenshot', { format: 'png' }); (await import('node:fs')).writeFileSync(ruta, Buffer.from(r.data, 'base64')); },
    cerrar() { try { sock.close(); } catch {} proc.kill('SIGKILL'); },
  };
  return api;
}
