#!/bin/bash
# Monta (o refresca) la BD de pruebas «real»: un MariaDB PRIVADO en ~/mm-testdb (puerto 3307, solo 127.0.0.1, sin contraseña) con la última copia diaria
# de la BD de producción (OneDrive/.../Milimetrica/ERP/BBDD/diaria). No toca producción ni la BD local de desarrollo.
# Uso: tests/preparar_bd.sh [--refrescar]    (sin argumento: arranca el servidor y carga la copia solo si la BD no existe)
D=$HOME/mm-testdb; SOCK=$D/my.sock
if ! mariadb --socket=$SOCK -e "select 1" >/dev/null 2>&1; then
  [ -d $D/mysql ] || mariadb-install-db --no-defaults --datadir=$D --auth-root-authentication-method=normal >/dev/null 2>&1
  (mariadbd --no-defaults --datadir=$D --socket=$SOCK --port=3307 --bind-address=127.0.0.1 --skip-grant-tables --innodb-buffer-pool-size=256M > $D/mysqld.log 2>&1 &)
  for i in $(seq 1 30); do mariadb --socket=$SOCK -e "select 1" >/dev/null 2>&1 && break; sleep 1; done
fi
if [ "$1" = "--refrescar" ] || ! mariadb --socket=$SOCK -e "select 1 from t.facturas limit 1" >/dev/null 2>&1; then
  B=$(ls -d /mnt/*/OneDrive/_RUR_Marta_Alex/__AlexArregui\ info/Clientes/Milimetrica/ERP/BBDD/diaria 2>/dev/null | head -1)
  F=$(ls -t "$B"/mmcontrol_*.sql.gz | head -1); echo "cargando $F"
  mariadb --socket=$SOCK -e "drop database if exists t; create database t character set utf8mb4"
  zcat "$F" | mariadb --socket=$SOCK t
fi
mariadb --socket=$SOCK -e "select 'facturas', count(*) from t.facturas"
