@echo off
setlocal enabledelayedexpansion
title Configuracao Rapida SUAPNE

echo ======================================
echo      Configuracao Rapida SUAPNE
echo ======================================
echo.

:: Verificar comandos necessarios
echo Verificando requisitos...

where php >nul 2>&1
if errorlevel 1 (
    echo [ERRO] PHP nao encontrado no PATH.
    pause
    exit /b 1
)

where composer >nul 2>&1
if errorlevel 1 (
    echo [ERRO] Composer nao encontrado no PATH.
    pause
    exit /b 1
)

where node >nul 2>&1
if errorlevel 1 (
    echo [ERRO] Node.js nao encontrado no PATH.
    pause
    exit /b 1
)

where npm >nul 2>&1
if errorlevel 1 (
    echo [ERRO] npm nao encontrado no PATH.
    pause
    exit /b 1
)

where mysql >nul 2>&1
if errorlevel 1 (
    echo [AVISO] Executavel do MySQL nao encontrado no PATH.
    echo A criacao do banco de dados sera ignorada.
    set MYSQL_AVAILABLE=0
) else (
    set MYSQL_AVAILABLE=1
)

php -m | findstr /I /X "gd" >nul 2>&1
if errorlevel 1 (
    echo [AVISO] A extensao GD do PHP nao esta habilitada.
    echo Habilite "extension=gd" no php.ini e reinicie o terminal.
    echo A instalacao vai continuar, mas o composer install ou a geracao de PDFs pode falhar.
    echo.
)

echo Todas as ferramentas necessarias foram encontradas.
echo.

:: Instalar dependencias do Composer
echo ======================================
echo Instalando dependencias do Composer...
echo ======================================
call composer install
if errorlevel 1 goto :error

echo.

:: Instalar dependencias do NPM
echo ======================================
echo Instalando dependencias do NPM...
echo ======================================
call npm install
if errorlevel 1 goto :error

echo.

:: Criar .env
if not exist ".env" (
    echo Criando .env...
    copy ".env.example" ".env" >nul
) else (
    echo O arquivo .env ja existe.
)

echo.

:: Gerar APP_KEY
echo Gerando APP_KEY...
call php artisan key:generate
if errorlevel 1 goto :error

echo.

:: Link do storage
echo Criando link do storage...

if exist "public\storage" (
    echo O link do storage ja existe.
) else (
    call php artisan storage:link
    if errorlevel 1 goto :error
)

echo.

if not "%MYSQL_AVAILABLE%"=="1" goto :skip_database

:: Banco de dados
echo ======================================
echo Configuracao do Banco de Dados
echo ======================================
set /p DB_USER=Usuario do MySQL [root]:
if "!DB_USER!"=="" set DB_USER=root

set /p DB_PASS=Senha do MySQL:

echo.
echo Criando o banco de dados "suapne_db" (se nao existir)...

if "!DB_PASS!"=="" (
    mysql -u !DB_USER! -e "CREATE DATABASE IF NOT EXISTS suapne_db;"
) else (
    mysql -u !DB_USER! -p!DB_PASS! -e "CREATE DATABASE IF NOT EXISTS suapne_db;"
)

echo.
echo IMPORTANTE:
echo Verifique se o seu .env contem as credenciais corretas do banco de dados.
echo.

:skip_database
echo.

:: Migracao
echo ======================================
echo Migracao do Banco de Dados
echo ======================================
echo.
echo AVISO: "migrate:fresh" ira APAGAR TODAS AS TABELAS
echo e excluir TODOS os dados existentes no banco de dados.
echo.
set /p MIGRATE=Executar migracoes e seeders? (S/n):

if /I "!MIGRATE!"=="n" (
    echo.
    echo Ignorando migracoes e seeders.
    goto :skip_migrate
)

echo.
echo Executando migracoes e seeders...
call php artisan migrate:fresh --seed
if errorlevel 1 goto :error

:skip_migrate
echo.
echo ======================================
echo Configuracao concluida com sucesso!
echo ======================================
echo.
echo Login padrao:
echo E-mail: admin@exemplo.com
echo Senha: 123
echo.

set /p START=Iniciar o servidor de desenvolvimento agora? (S/n):

if /I "%START%"=="n" (
    echo.
    pause
    exit /b 0
)

echo.
call composer dev
exit /b 0

:error
echo.
echo ======================================
echo A configuracao falhou.
echo Verifique as mensagens de erro acima.
echo ======================================
pause
exit /b 1
