@echo off
cd /d "%~dp0"
echo Starting SPMB Backend...
php artisan serve --host=127.0.0.1 --port=8000
pause
