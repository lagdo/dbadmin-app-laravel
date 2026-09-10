@echo off
set "COMMAND_DIR=%~dp0..\.."
php "%COMMAND_DIR%\artisan user:create" %*
