# Script Instalasi SPMB SMK Bakti Nusantara 666
# Jalankan dengan PowerShell sebagai Administrator

Write-Host "==================================" -ForegroundColor Cyan
Write-Host "SPMB SMK Bakti Nusantara 666" -ForegroundColor Cyan
Write-Host "Script Instalasi Otomatis" -ForegroundColor Cyan
Write-Host "==================================" -ForegroundColor Cyan
Write-Host ""

# Check if PostgreSQL is installed
Write-Host "Checking PostgreSQL..." -ForegroundColor Yellow
try {
    $pgPath = Get-Command psql -ErrorAction Stop
    Write-Host "✓ PostgreSQL ditemukan" -ForegroundColor Green
} catch {
    Write-Host "✗ PostgreSQL tidak ditemukan. Silakan install PostgreSQL terlebih dahulu." -ForegroundColor Red
    Write-Host "Download di: https://www.postgresql.org/download/" -ForegroundColor Yellow
    exit 1
}

# Check if Composer is installed
Write-Host "Checking Composer..." -ForegroundColor Yellow
try {
    $composerPath = Get-Command composer -ErrorAction Stop
    Write-Host "✓ Composer ditemukan" -ForegroundColor Green
} catch {
    Write-Host "✗ Composer tidak ditemukan. Silakan install Composer terlebih dahulu." -ForegroundColor Red
    Write-Host "Download di: https://getcomposer.org/download/" -ForegroundColor Yellow
    exit 1
}

# Check if Node.js is installed
Write-Host "Checking Node.js..." -ForegroundColor Yellow
try {
    $nodePath = Get-Command node -ErrorAction Stop
    Write-Host "✓ Node.js ditemukan" -ForegroundColor Green
} catch {
    Write-Host "✗ Node.js tidak ditemukan. Silakan install Node.js terlebih dahulu." -ForegroundColor Red
    Write-Host "Download di: https://nodejs.org/" -ForegroundColor Yellow
    exit 1
}

Write-Host ""
Write-Host "==================================" -ForegroundColor Cyan
Write-Host "Instalasi Backend (Laravel)" -ForegroundColor Cyan
Write-Host "==================================" -ForegroundColor Cyan

Set-Location backend

Write-Host "Installing Composer dependencies..." -ForegroundColor Yellow
composer install

Write-Host "Generating application key..." -ForegroundColor Yellow
php artisan key:generate

Write-Host ""
Write-Host "Silakan buat database PostgreSQL dengan nama: spmb_smk" -ForegroundColor Yellow
Write-Host "Anda bisa menggunakan command berikut:" -ForegroundColor Yellow
Write-Host 'psql -U postgres -c "CREATE DATABASE spmb_smk;"' -ForegroundColor Cyan
Write-Host ""
$confirm = Read-Host "Sudah membuat database? (Y/N)"

if ($confirm -eq "Y" -or $confirm -eq "y") {
    Write-Host "Running migrations..." -ForegroundColor Yellow
    php artisan migrate
    
    Write-Host "Seeding database..." -ForegroundColor Yellow
    php artisan db:seed --class=JurusanSeeder
    
    Write-Host "Creating storage link..." -ForegroundColor Yellow
    php artisan storage:link
    
    Write-Host "✓ Backend setup complete!" -ForegroundColor Green
} else {
    Write-Host "Silakan buat database terlebih dahulu, lalu jalankan:" -ForegroundColor Yellow
    Write-Host "  php artisan migrate" -ForegroundColor Cyan
    Write-Host "  php artisan db:seed --class=JurusanSeeder" -ForegroundColor Cyan
    Write-Host "  php artisan storage:link" -ForegroundColor Cyan
}

Set-Location ..

Write-Host ""
Write-Host "==================================" -ForegroundColor Cyan
Write-Host "Instalasi Frontend (Angular)" -ForegroundColor Cyan
Write-Host "==================================" -ForegroundColor Cyan

Set-Location frontend

Write-Host "Installing npm dependencies..." -ForegroundColor Yellow
npm install

Write-Host "✓ Frontend setup complete!" -ForegroundColor Green

Set-Location ..

Write-Host ""
Write-Host "==================================" -ForegroundColor Green
Write-Host "INSTALASI SELESAI!" -ForegroundColor Green
Write-Host "==================================" -ForegroundColor Green
Write-Host ""
Write-Host "Untuk menjalankan aplikasi:" -ForegroundColor Yellow
Write-Host ""
Write-Host "1. Backend (Terminal 1):" -ForegroundColor Cyan
Write-Host "   cd backend" -ForegroundColor White
Write-Host "   php artisan serve" -ForegroundColor White
Write-Host "   Backend akan berjalan di: http://localhost:8000" -ForegroundColor Gray
Write-Host ""
Write-Host "2. Frontend (Terminal 2):" -ForegroundColor Cyan
Write-Host "   cd frontend" -ForegroundColor White
Write-Host "   npm start" -ForegroundColor White
Write-Host "   Frontend akan berjalan di: http://localhost:4200" -ForegroundColor Gray
Write-Host ""
Write-Host "Buka browser di http://localhost:4200 untuk menggunakan aplikasi" -ForegroundColor Yellow
Write-Host ""
