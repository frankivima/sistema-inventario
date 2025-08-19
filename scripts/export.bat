@echo off
REM Configura aquí tus datos
set dbuser=root
set dbpass=
set dbname=bd_inventario
set backupdir=C:\xampp\htdocs\sistema_inventario\db_backups

REM Crear carpeta backup si no existe
if not exist "%backupdir%" mkdir "%backupdir%"

REM Formatear fecha y hora para el nombre del archivo
for /f "tokens=2-4 delims=/ " %%a in ('date /t') do (
  set day=%%a
  set month=%%b
  set year=%%c
)
for /f "tokens=1-2 delims=: " %%a in ('time /t') do (
  set hour=%%a
  set minute=%%b
)
set hour=%hour: =0%

REM Nombre con fecha y hora
set filename=backup_%year%-%month%-%day%_%hour%-%minute%.sql

REM Ejecutar el mysqldump con opción --add-drop-table
"C:\xampp\mysql\bin\mysqldump.exe" -u %dbuser% --add-drop-table %dbname% > "%backupdir%\%filename%"

REM Copiar la última versión a backup_latest.sql para importación rápida
copy /Y "%backupdir%\%filename%" "%backupdir%\backup_latest.sql"

echo Backup completado: %filename%
pause
