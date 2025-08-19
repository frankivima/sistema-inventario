@echo off
setlocal enabledelayedexpansion

:: Configuración básica
set PROYECTO_DIR=C:\xampp\htdocs\sistema-inventario
set SCRIPTS_DIR=%PROYECTO_DIR%\scripts
set BACKUP_DIR=%PROYECTO_DIR%\backups
set LOG_DIR=%PROYECTO_DIR%\logs
set DB_NAME=bd_inventario
set DB_USER=root
set DB_PASS=

:: Crear carpeta logs si no existe
if not exist "%LOG_DIR%" mkdir "%LOG_DIR%"

:: Obtener fecha y hora para uso en mensajes y nombres de archivos
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
set TIMESTAMP=%year%-%month%-%day%_%hour%-%minute%

set LOG_FILE=%LOG_DIR%\%year%-%month%-%day%_log.txt

:menu
cls
echo ====================================
echo   GESTOR DE PROYECTO - SISTEMA INVENTARIO
echo ====================================
echo.
echo 1. Preparar entorno antes de programar
echo 2. Guardar y subir cambios despues de programar
echo 3. Solo exportar la base de datos
echo 4. Solo importar la base de datos
echo 5. Salir
echo.
set /p option=Elige una opcion:

if "%option%"=="1" goto antes
if "%option%"=="2" goto despues
if "%option%"=="3" goto exportar
if "%option%"=="4" goto importar
if "%option%"=="5" goto salir

echo Opcion invalida.
pause
goto menu

:verificar_mysql
echo Verificando que MySQL (XAMPP) este corriendo...
"C:\xampp\mysql\bin\mysqladmin.exe" -u %DB_USER% ping >nul 2>&1
if errorlevel 1 (
    echo.
    echo ERROR: MySQL no esta corriendo. Abre XAMPP y enciende MySQL.
    echo [%time%] ERROR: MySQL no activo >> "%LOG_FILE%"
    pause
    goto menu
)
echo MySQL esta activo.
echo.
goto :eof

:preguntar_usb
echo.
set /p usbDrive=Si deseas hacer respaldo automatico, escribe la letra de la unidad USB/disco externo (Ejemplo: E) o deja vacio para omitir:

if "%usbDrive%"=="" (
  set USB_PATH=
  goto :eof
)

:: Agregar :\ al final y comprobar si existe la unidad
set USB_PATH=%usbDrive%:\

if not exist "%USB_PATH%" (
  echo Unidad %USB_PATH% no encontrada. Respaldo automatico omitido.
  set USB_PATH=
  pause
  goto :eof
)

echo Unidad %USB_PATH% detectada, se hara respaldo automatico.
goto :eof

:respaldar_usb
if defined USB_PATH (
  echo Copiando backups y logs a %USB_PATH%Respaldo_Inv\...
  xcopy "%BACKUP_DIR%\*.sql" "%USB_PATH%Respaldo_Inv\backups\" /Y /I >nul
  xcopy "%LOG_DIR%\*.txt" "%USB_PATH%Respaldo_Inv\logs\" /Y /I >nul
  echo [%time%] Respaldo automatico a %USB_PATH% completado >> "%LOG_FILE%"
) else (
  echo Respaldo automatico omitido.
)
goto :eof

:antes
cls
echo ============================================
echo === ACTUALIZANDO PROYECTO DESDE GITHUB ===
echo ============================================
cd "%PROYECTO_DIR%"

echo Ejecutando git pull...
git pull > temp_gitpull.txt

findstr /C:"Already up to date." temp_gitpull.txt >nul
if %errorlevel%==0 (
    echo El proyecto ya estaba actualizado.
    echo [%time%] git pull: ya actualizado >> "%LOG_FILE%"
) else (
    echo Proyecto actualizado, se descargaron nuevos cambios.
    echo [%time%] git pull: actualizado con cambios >> "%LOG_FILE%"
)

del temp_gitpull.txt

echo.
echo ============================================
echo === RESTAURANDO BASE DE DATOS ===
echo ============================================
call :verificar_mysql
cd "%SCRIPTS_DIR%"
call import.bat

echo [%time%] Base de datos restaurada >> "%LOG_FILE%"
echo.
call :preguntar_usb
call :respaldar_usb

pause
goto menu

:despues
cls
echo ============================================
echo === CREANDO BACKUP DE BASE DE DATOS ===
echo ============================================
call :verificar_mysql
cd "%SCRIPTS_DIR%"

:: Detectar branch actual
set BRANCH_NAME=
for /f "tokens=2" %%b in ('git rev-parse --abbrev-ref HEAD') do set BRANCH_NAME=%%b
set BACKUP_FILE=%BACKUP_DIR%\backup_%DB_NAME%_%BRANCH_NAME%_%TIMESTAMP%.sql

:: Exportar base de datos
"C:\xampp\mysql\bin\mysqldump.exe" -u %DB_USER% -p%DB_PASS% %DB_NAME% > "%BACKUP_FILE%"
if errorlevel 1 (
    echo ERROR: No se pudo crear backup de BD >> "%LOG_FILE%"
    pause
    goto menu
)
echo Backup creado: %BACKUP_FILE% >> "%LOG_FILE%"

echo.
echo ============================================
echo === GUARDANDO CAMBIOS EN GIT ===
echo ============================================
cd "%PROYECTO_DIR%"

git add .

:: Crear mensaje de commit con fecha/hora y comentario opcional
set /p comentario=Escribe comentario adicional para el commit (opcional):
set commitMsg=Backup y cambios - %TIMESTAMP%
if not "%comentario%"=="" set commitMsg=%commitMsg% - %comentario%

:: Solo commit si hay cambios
git diff --cached --quiet
if %errorlevel%==0 (
    echo No hay cambios para commit.
) else (
    git commit -m "%commitMsg%"
    git push origin HEAD
    echo [%time%] Commit hecho con mensaje: %commitMsg% >> "%LOG_FILE%"
    echo [%time%] Push realizado >> "%LOG_FILE%"
)

:: Respaldo USB opcional
call :preguntar_usb
call :respaldar_usb

echo === CAMBIOS Y BACKUP SUBIDOS ===
pause
goto menu

:exportar
cls
echo ============================================
echo === EXPORTANDO BASE DE DATOS ===
echo ============================================
call :verificar_mysql
cd "%SCRIPTS_DIR%"
call export.bat
echo [%time%] Backup de base de datos creado >> "%LOG_FILE%"
pause
goto menu

:importar
cls
echo ============================================
echo === IMPORTANDO BASE DE DATOS ===
echo ============================================
call :verificar_mysql
cd "%SCRIPTS_DIR%"
call import.bat
echo [%time%] Base de datos restaurada >> "%LOG_FILE%"
pause
goto menu

:salir
echo Script finalizado.
pause
exit
