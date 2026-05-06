Set-Location "C:\Users\ms-yhan\Documents\realpro\spmb\frontend"
$env:NODE_OPTIONS = "--max-old-space-size=4096"
Write-Host "Starting Angular development server..." -ForegroundColor Green
Write-Host "Location: $(Get-Location)" -ForegroundColor Cyan
npm run start
