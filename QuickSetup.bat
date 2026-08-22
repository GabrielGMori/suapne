@echo off
setlocal enabledelayedexpansion
title SUAPNE Quick Setup

echo ======================================
echo        SUAPNE Quick Setup
echo ======================================
echo.

:: Check required commands
echo Checking requirements...

where php >nul 2>&1
if errorlevel 1 (
    echo [ERROR] PHP not found in PATH.
    pause
    exit /b 1
)

where composer >nul 2>&1
if errorlevel 1 (
    echo [ERROR] Composer not found in PATH.
    pause
    exit /b 1
)

where node >nul 2>&1
if errorlevel 1 (
    echo [ERROR] Node.js not found in PATH.
    pause
    exit /b 1
)

where npm >nul 2>&1
if errorlevel 1 (
    echo [ERROR] npm not found in PATH.
    pause
    exit /b 1
)

where mysql >nul 2>&1
if errorlevel 1 (
    echo [WARNING] MySQL executable not found in PATH.
    echo Database creation will be skipped.
    set MYSQL_AVAILABLE=0
) else (
    set MYSQL_AVAILABLE=1
)

echo All required tools found.
echo.

:: Install Composer dependencies
echo ======================================
echo Installing Composer dependencies...
echo ======================================
call composer install
if errorlevel 1 goto :error

echo.

:: Install NPM dependencies
echo ======================================
echo Installing NPM dependencies...
echo ======================================
call npm install
if errorlevel 1 goto :error

echo.

:: Create .env
if not exist ".env" (
    echo Creating .env...
    copy ".env.example" ".env" >nul
) else (
    echo .env already exists.
)

echo.

:: Generate APP_KEY
echo Generating APP_KEY...
call php artisan key:generate
if errorlevel 1 goto :error

echo.

:: Storage Link
echo Creating storage link...

if exist "public\storage" (
    echo Storage link already exists.
) else (
    call php artisan storage:link
    if errorlevel 1 goto :error
)

echo.

if not "%MYSQL_AVAILABLE%"=="1" goto :skip_database

:: Database
echo ======================================
echo Database Configuration
echo ======================================
set /p DB_USER=MySQL Username [root]:
if "!DB_USER!"=="" set DB_USER=root

set /p DB_PASS=MySQL Password:

echo.
echo Creating database "suapne_db" (if it doesn't exist)...

if "!DB_PASS!"=="" (
    mysql -u !DB_USER! -e "CREATE DATABASE IF NOT EXISTS suapne_db;"
) else (
    mysql -u !DB_USER! -p!DB_PASS! -e "CREATE DATABASE IF NOT EXISTS suapne_db;"
)

echo.
echo IMPORTANT:
echo Make sure your .env contains the correct database credentials.
echo.

:skip_database
echo.

:: Migrate
echo ======================================
echo Running migrations and seeders...
echo ======================================
call php artisan migrate:fresh --seed
if errorlevel 1 goto :error

echo.
echo ======================================
echo Setup completed successfully!
echo ======================================
echo.
echo Default login:
echo Email: admin@exemplo.com
echo Password: 123
echo.

set /p START=Start the development server now? (Y/n): 

if /I "%START%"=="n" (
    echo.
    pause
    exit /b 0

    :error
    echo.
    echo ======================================
    echo Setup failed.
    echo Check the error messages above.
    echo ======================================
    pause
    exit /b 1
)

echo.
call composer dev
