@echo off
REM Batch script to create self-signed SSL certificate
REM This script will generate server.key and server.crt certificate files in the conf/ssl directory

SET "APACHE_ROOT=c:/Apache24"
SET "SSL_DIR=%APACHE_ROOT%/conf/ssl"
SET "DOMAIN=www.localtest.com"

REM Create ssl directory if it doesn't exist
IF NOT EXIST "%SSL_DIR%" (
    mkdir "%SSL_DIR%"
    echo SSL directory created: %SSL_DIR%
)

REM Navigate to bin directory to use openssl for certificate generation
cd /d "%APACHE_ROOT%/bin"

REM Generate private key
openssl genrsa -out "%SSL_DIR%/server.key" 2048
IF %ERRORLEVEL% NEQ 0 (
    echo Failed to generate private key!
    pause
    exit /b 1
)

REM Generate certificate signing request
openssl req -new -key "%SSL_DIR%/server.key" -out "%SSL_DIR%/server.csr" -subj "/CN=%DOMAIN%/OU=LocalTest/O=LocalTestOrg/L=LocalCity/ST=LocalState/C=CN"
IF %ERRORLEVEL% NEQ 0 (
    echo Failed to generate certificate signing request!
    pause
    exit /b 1
)

REM Generate self-signed certificate (valid for 365 days)
openssl x509 -req -days 365 -in "%SSL_DIR%/server.csr" -signkey "%SSL_DIR%/server.key" -out "%SSL_DIR%/server.crt"
IF %ERRORLEVEL% NEQ 0 (
    echo Failed to generate self-signed certificate!
    pause
    exit /b 1
)

REM Clean up intermediate files
IF EXIST "%SSL_DIR%/server.csr" (
    del "%SSL_DIR%/server.csr"
)

REM Set certificate file permissions
REM On Windows, no special permissions are needed here

echo SSL certificate generated successfully!
echo Certificate location: %SSL_DIR%/server.crt
echo Private key location: %SSL_DIR%/server.key
echo 
echo Remember to reference these certificate files in your httpd-ssl.conf or virtual host configuration.
echo 
pause