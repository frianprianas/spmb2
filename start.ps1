# Quick Start Script
# Jalankan backend dan frontend secara bersamaan

Write-Host "Starting SPMB Application..." -ForegroundColor Cyan

# Start backend in new window
Start-Process powershell -ArgumentList "-NoExit", "-Command", "cd backend; Write-Host 'Starting Laravel Backend...' -ForegroundColor Green; php artisan serve"

# Wait a bit for backend to start
Start-Sleep -Seconds 3

# Start frontend in new window  
Start-Process powershell -ArgumentList "-NoExit", "-Command", "cd frontend; Write-Host 'Starting Angular Frontend...' -ForegroundColor Green; npm start"

Write-Host ""
Write-Host "Backend: http://localhost:8000" -ForegroundColor Yellow
Write-Host "Frontend: http://localhost:4200" -ForegroundColor Yellow
Write-Host ""
Write-Host "Aplikasi akan terbuka di browser dalam beberapa saat..." -ForegroundColor Green
