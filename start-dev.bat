@echo off
echo ========================================
echo   SPMB System - Laravel + Inertia.js
echo ========================================
echo.

cd backend

echo [1/3] Starting Laravel server...
start "Laravel Server" cmd /k "php artisan serve --host=127.0.0.1 --port=8000"
timeout /t 3 /nobreak >nul

echo [2/3] Starting Vite dev server...
start "Vite Dev Server" cmd /k "npm run dev"
timeout /t 3 /nobreak >nul

echo [3/3] Opening browser...
timeout /t 5 /nobreak >nul
start http://127.0.0.1:8000

echo.
echo ========================================
echo   Servers Started!
echo ========================================
echo   Laravel  : http://127.0.0.1:8000
echo   Vite HMR : http://localhost:5173
echo ========================================
echo.
echo LOGIN URLS:
echo   Admin    : http://127.0.0.1:8000/admin/login
echo   Keuangan : http://127.0.0.1:8000/keuangan/login
echo   Siswa    : http://127.0.0.1:8000/siswa/register
echo ========================================
echo.
pause
