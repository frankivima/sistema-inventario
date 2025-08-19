@echo off
REM =========================
REM Configuración
REM =========================
set REPO_PATH=C:\xampp\htdocs\sistema-inventario
set BACKUP_PATH=%REPO_PATH%\backups
set DB_NAME=bd_inventario
set DB_USER=root
set DB_PASS=

REM =========================
REM Entrar a la carpeta del proyecto
REM =========================
cd /d %REPO_PATH%

REM =========================
REM Crear carpeta de backups si no existe
REM =========================
if not exist "%BACKUP_PATH%" mkdir "%BACKUP_PATH%"

REM =========================
REM Crear nombre de backup con fecha y hora
REM =========================
for /f "tokens=1-3 delims=/" %%a in ("%date%") do set FECHA=%%c%%a%%b
for /f "tokens=1-2 delims=:." %%a in ("%time%") do set HORA=%%a%%b
set BACKUP_FILE=backup_%DB_NAME%_%FECHA%_%HORA%.sql

REM =========================
REM Hacer backup de la base de datos
REM =========================
echo Haciendo backup de la base de datos...
mysqldump -u %DB_USER% -p%DB_PASS% %DB_NAME% > "%BACKUP_PATH%\%BACKUP_FILE%"

REM =========================
REM Preguntar mensaje de commit
REM =========================
set /p COMMIT_MSG=Introduce el mensaje de commit para v2: 

REM =========================
REM Agregar cambios y hacer commit
REM =========================
git add -A
git commit -m "%COMMIT_MSG%"

REM =========================
REM Crear tag v2
REM =========================
set TAG_NAME=v2
git tag -a %TAG_NAME% -m "%COMMIT_MSG%"

REM =========================
REM Subir cambios y tag a GitHub
REM =========================
git push origin main
git push origin %TAG_NAME%

echo Proceso completado. Backup guardado en %BACKUP_PATH%\%BACKUP_FILE%
pause
