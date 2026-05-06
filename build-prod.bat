@echo off
echo Building production assets...
cd backend
call npm run build
echo Build complete!
pause
