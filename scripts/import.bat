@echo off
REM Configura aquí tus datos
set dbuser=root
set dbpass=
set dbname=bd_inventario
set backupfile=C:\xampp\htdocs\\sistema_inventario\db_backups\backup_latest.sql

REM Ejecutar la importación
"C:\xampp\mysql\bin\mysql.exe" -u %dbuser% %dbname% < "%backupfile%"

echo Importación completada desde %backupfile%
pause
