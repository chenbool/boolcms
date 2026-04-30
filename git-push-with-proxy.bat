@echo off
:: 设置 GBK 编码（中文 Windows 默认编码，避免乱码）
chcp 936 >nul
title Git Proxy Push Tool

echo ========================================
echo    Git Proxy Push Tool
echo    Proxy: 127.0.0.1:7890
echo ========================================
echo.

:: Check if in git repository
if not exist .git (
    echo [Error] Not a git repository!
    echo Please run this script in project root directory.
    pause
    exit /b 1
)

:: Set Git proxy
echo [1/4] Setting Git proxy...
git config --global http.proxy http://127.0.0.1:7890
git config --global https.proxy http://127.0.0.1:7890
echo [OK] Proxy set
echo.

:: Check remote URL
echo [2/4] Remote repository:
git remote -v
echo.

:: Confirm push
echo [3/4] Ready to push:
git status
echo.
echo ----------------------------------------
echo Press any key to push, or close window to cancel...
echo ----------------------------------------
pause >nul

:: Execute push
echo.
echo [4/4] Pushing to remote...
git push origin master

:: Check result
if %errorlevel% == 0 (
    echo.
    echo ========================================
    echo [OK] Push successful!
    echo ========================================
) else (
    echo.
    echo ========================================
    echo [Error] Push failed!
    echo ========================================
)

:: Clear proxy
echo.
echo [Clean] Clearing proxy settings...
git config --global --unset http.proxy
git config --global --unset https.proxy
echo [OK] Proxy cleared
echo.

echo Press any key to exit...
pause >nul
