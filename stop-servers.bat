@echo off
echo Stopping all servers...

taskkill /F /IM php.exe 2>nul
taskkill /F /IM node.exe 2>nul

echo Servers stopped!
pause
