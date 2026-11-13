#!/bin/bash
# Lanza toda la red de seguridad de mmcontrol: suite existente (SQLite en memoria) + suite «real» (BD local copia de producción) + navegador.
# Uso: tests/correr.sh [real|browser]  (sin argumento: real + browser; «feature» = suite antigua SQLite, rota desde siempre por migraciones solo-MySQL).
cd "$(dirname "$0")/.." || exit 1
tests/preparar_bd.sh >/dev/null 2>&1
rc=0
if [ "$1" = feature ]; then php vendor/bin/phpunit --no-coverage 2>&1 | tail -15; [ ${PIPESTATUS[0]} -eq 0 ] || rc=1; fi
if [ -z "$1" ] || [ "$1" = real ]; then php vendor/bin/phpunit -c phpunit.real.xml --no-coverage 2>&1 | tail -40; [ ${PIPESTATUS[0]} -eq 0 ] || rc=1; fi
if [ -z "$1" ] || [ "$1" = browser ]; then node tests/Browser/run.mjs 2>&1 | tail -40; [ ${PIPESTATUS[0]} -eq 0 ] || rc=1; fi
exit $rc
