
@echo off
setlocal enabledelayedexpansion

:: Enter MySQL username and password
::set /p dbuser=Please enter MySQL username:
::set /p dbpass=Please enter MySQL password:

set dbuser="root"
set dbpass="admin"
:: List all databases
echo.
echo Listing all databases:
for /f "skip=1 tokens=*" %%d in ('mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;"') do (
    echo %%d
)

:: Choose operation
echo.
echo What do you want to do?
echo 1. Backup a database
echo 2. Delete a database
echo 3. Operate on a database
echo 4. Import a database

set /p action=Please enter the number of your choice (1/2/3/4):
set action=%action: =%

if "%action%"=="1" goto backupdb
if "%action%"=="2" goto deletedb
if "%action%"=="3" goto operatedb
if "%action%"=="4" goto importdb
echo Invalid choice. Please run the script again.

goto postop

:backupdb
:: Validate database name
:backupdb_select
set /p backupdb=Please enter the database name to backup:
mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;" | findstr /i /x "%backupdb%" >nul
if errorlevel 1 (
    echo Database [%backupdb%] does not exist. Please enter a valid database name.
    goto backupdb_select
)
echo How do you want to backup?
echo 1. Export to external file
echo 2. Copy to another database
set /p backupmode=Please enter the number of your choice (1/2):
set backupmode=%backupmode: =%

if "%backupmode%"=="1" goto backupfile
if "%backupmode%"=="2" goto backupcopy
echo Invalid choice. Please run the script again.

goto postop

:backupfile
set /p backupfile=Please enter the backup file name (e.g. backup.sql):
mysqldump -u %dbuser% -p%dbpass% %backupdb% > %backupfile%
echo Database [%backupdb%] has been backed up to [%backupfile%]

goto postop

:backupcopy
:: Validate new database name (allow creation, but warn if exists)
goto newdb_select

:newdb_select
set /p newdb=Please enter the name for the new database to copy data into:
mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;" | findstr /i /x "%newdb%" >nul
if not errorlevel 1 goto db_exists
goto newdb_overwrite

:db_exists
echo WARNING: Database [%newdb%] already exists.
set /p dbcover=Do you want to overwrite this database? (Y=Yes/N=Rename):
if /I "%dbcover%"=="Y" goto newdb_overwrite
if /I "%dbcover%"=="N" goto newdb_select
echo Invalid input, please try again.
goto newdb_select

:newdb_overwrite
mysql -u %dbuser% -p%dbpass% -e "CREATE DATABASE IF NOT EXISTS %newdb%;"
for /f "skip=1 tokens=*" %%t in ('mysql -u %dbuser% -p%dbpass% -e "SHOW TABLES IN %backupdb%;"') do (
    mysqldump -u %dbuser% -p%dbpass% %backupdb% %%t | mysql -u %dbuser% -p%dbpass% %newdb%
)
echo Database [%backupdb%] has been copied to [%newdb%]
    :: List tables in source database (remove header)
    set src_tables=src_tables.txt
    mysql -u %dbuser% -p%dbpass% -e "SHOW TABLES IN %backupdb%;" | findstr /v /i "Tables_in_" > %src_tables%
    :: List tables in target database (remove header)
    set tgt_tables=tgt_tables.txt
    mysql -u %dbuser% -p%dbpass% -e "SHOW TABLES IN %newdb%;" | findstr /v /i "Tables_in_" > %tgt_tables%

    echo.
    echo Tables in source database [%backupdb%]:
    type %src_tables%
    echo.
    echo Tables in target database [%newdb%]:
    type %tgt_tables%

    :: Compare tables
    set diff=0
    set src_count=0
    set tgt_count=0
    for /f %%s in (%src_tables%) do set /a src_count+=1
    for /f %%t in (%tgt_tables%) do set /a tgt_count+=1

    if %tgt_count%==0 (
        copy %src_tables% src_only.txt >nul
        type nul > tgt_only.txt
    ) else (
        findstr /v /i /g:%tgt_tables% %src_tables% > src_only.txt
        findstr /v /i /g:%src_tables% %tgt_tables% > tgt_only.txt
    )

    set src_diff=0
    set tgt_diff=0
    for /f %%b in (src_only.txt) do set src_diff=1
    for /f %%b in (tgt_only.txt) do set tgt_diff=1

    if %src_count% NEQ %tgt_count% ( set diff=1 )
    if %src_diff%==1 ( set diff=1 )
    if %tgt_diff%==1 ( set diff=1 )

    if %diff%==1 goto diff_warning
    echo Table lists are identical between source and target databases.
    goto diff_end

:diff_warning
    if %src_diff%==1 (
        echo Tables only in source database:
        type src_only.txt
    )
    if %tgt_diff%==1 (
        echo Tables only in target database:
        type tgt_only.txt
    )
    echo WARNING: Table lists are not identical!
    echo.
    set /p delbackup=Do you want to delete the backup database [%newdb%]? (Y/N):
    if /I "%delbackup%"=="Y" goto delete_backup_db
    goto diff_end

:delete_backup_db
    mysql -u %dbuser% -p%dbpass% -e "DROP DATABASE %newdb%;"
    echo Backup database [%newdb%] has been deleted.
    goto diff_end

:diff_end

    del %src_tables% %tgt_tables% src_only.txt tgt_only.txt

goto postop

:deletedb
:: Validate database name
:deletedb_select
set /p deletedb=Please enter the database name to delete:
mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;" | findstr /i /x "%deletedb%" >nul
if errorlevel 1 (
    echo Database [%deletedb%] does not exist. Please enter a valid database name.
    goto deletedb_select
)
mysql -u %dbuser% -p%dbpass% -e "DROP DATABASE %deletedb%;"
echo Database [%deletedb%] has been deleted.

goto postop

:operatedb
:: Validate database name
:operatedb_select
set /p dbname=Please enter the database name to operate:
mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;" | findstr /i /x "%dbname%" >nul
if errorlevel 1 (
    echo Database [%dbname%] does not exist. Please enter a valid database name.
    goto operatedb_select
)
echo.
echo All tables in database [%dbname%]:
for /f "skip=1 tokens=*" %%i in ('mysql -u %dbuser% -p%dbpass% -e "SHOW TABLES IN %dbname%;"') do (
    echo %%i
)
set /p tablename=Please enter the table name to view:
echo.
echo Displaying contents of table [%tablename%]:
mysql -u %dbuser% -p%dbpass% -e "SELECT * FROM %dbname%.%tablename%;"
goto end


:importdb
:: Validate database name (allow creation, but warn if exists)
:importdb_select
set /p importdb=Please enter the target database name to import into:
mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;" | findstr /i /x "%importdb%" >nul
if not errorlevel 1 (
    echo WARNING: Database [%importdb%] already exists. Data will be merged/overwritten.
)
set /p importfile=Please enter the SQL backup file to import (e.g. backup.sql):
mysql -u %dbuser% -p%dbpass% -e "CREATE DATABASE IF NOT EXISTS %importdb%;"
mysql -u %dbuser% -p%dbpass% %importdb% < %importfile%
echo File [%importfile%] has been imported into database [%importdb%]
goto end


:postop
echo.
echo Listing all databases:
for /f "skip=1 tokens=*" %%d in ('mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;"') do (
    echo %%d
)
echo.
set /p continue=Do you want to continue? (Y/N):
if /I "%continue%"=="Y" goto mainmenu
echo Exiting...
pause
exit

:mainmenu
echo.
echo What do you want to do?
echo 1. Backup a database
echo 2. Delete a database
echo 3. Operate on a database
echo 4. Import a database
set /p action=Please enter the number of your choice (1/2/3/4):
set action=%action: =%
if "%action%"=="1" goto backupdb
if "%action%"=="2" goto deletedb
if "%action%"=="3" goto operatedb
if "%action%"=="4" goto importdb
echo Invalid choice. Please run the script again.
goto postop

