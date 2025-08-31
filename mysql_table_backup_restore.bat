
@echo off
setlocal enabledelayedexpansion

:: Enter MySQL username and password
::set /p dbuser=Please enter MySQL username:
::set /p dbpass=Please enter MySQL password:

set dbuser="root"
set dbpass="admin"
:: List all databases with numbers
echo.
echo Listing all databases:
set dbindex=1
set dbnameindex=
for /f "skip=1 tokens=*" %%d in ('mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;"') do (
    echo !dbindex!. %%d
    set "dbname_!dbindex!=%%d"
    set /a dbindex+=1
)
set /a lastindex=dbindex-1

:: Choose operation
:mainmenu
echo.
echo What do you want to do?
echo 1. Create a new database
echo 2. Backup a database
echo 3. Delete a database
echo 4. Operate on a database
echo 5. Import a database
echo 6. Compare two databases
echo 7. Show all databases
set /p action=Please enter the number of your choice (1/2/3/4/5/6/7):
set action=%action: =%
if "%action%"=="1" goto createdb
if "%action%"=="2" goto backupdb
if "%action%"=="3" goto deletedb
if "%action%"=="4" goto operatedb
if "%action%"=="5" goto importdb
if "%action%"=="6" goto comparedb
if "%action%"=="7" goto showalldbs
echo Invalid choice. Please run the script again.
goto postop

:showalldbs
echo.
echo Listing all databases:
set dbindex=1
set dbnameindex=
for /f "skip=1 tokens=*" %%d in ('mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;"') do (
    echo !dbindex!. %%d
    set "dbname_!dbindex!=%%d"
    set /a dbindex+=1
)
set /a lastindex=dbindex-1
goto postop

:createdb
echo.
echo Creating a new database
set "newdbname="
set /p newdbname=Please enter the name for the new database:

:: 检查数据库名称格式
if "%newdbname%"=="" (
    echo Error: Database name cannot be empty.
    goto createdb
)

:: 检查是否以字母或下划线开头
echo %newdbname:~0,1% | findstr /r "[a-zA-Z_]" >nul
if errorlevel 1 (
    echo Error: Database name must start with a letter or underscore.
    goto createdb
)

:: 检查长度
if "%newdbname:~64%"=="" (
    rem length is valid, continue checks.
) else (
    echo Error: Database name is too long ^(max 64 characters^).
    goto createdb
)

:: 检查是否包含MySQL保留字
set "reserved_words=SELECT INSERT UPDATE DELETE DROP CREATE ALTER TABLE DATABASE INDEX VIEW TRIGGER PROCEDURE FUNCTION TABLESPACE SCHEMA" 
for %%w in (%reserved_words%) do (
    if /i "%newdbname%"=="%%w" (
        echo Error: "%newdbname%" is a MySQL reserved word. Please choose another name.
        goto createdb
    )
)

:: 检查数据库是否已存在
:check_db_exists
mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;" | findstr /i /x "%newdbname%" >nul
if not errorlevel 1 (
    echo.
    echo Error: Database [%newdbname%] already exists.
    set /p newdbname=Please enter a different name for the new database:
    goto check_db_exists
)

:: 选择数据库字符集
echo.
echo Available character sets:
echo 1. utf8mb4 (Recommended for most cases)
echo 2. utf8
echo 3. latin1
echo 4. Other (specify manually)
set /p charsetChoice=Enter your choice (1/2/3/4):

set charset=utf8mb4
if "%charsetChoice%"=="2" (
    set charset=utf8
) else if "%charsetChoice%"=="3" (
    set charset=latin1
) else if "%charsetChoice%"=="4" (
    set /p charset=Enter character set name:
)

:: 选择排序规则
echo.
echo Common collations for %charset%:

:: 初始化变量
set "collation="

:: 使用标签和goto替代if-else，确保只有一个分支被执行
if /i "%charset%"=="utf8mb4" goto standard_collation
if /i "%charset%"=="utf8" goto standard_collation

:: 不支持预定义排序规则的字符集，直接要求用户输入
goto non_standard_collation

:standard_collation
    echo 1. %charset%_general_ci (Fast, case-insensitive)
    echo 2. %charset%_unicode_ci (Better language support)
    echo 3. %charset%_bin (Binary comparison, case-sensitive)
    echo 4. Other (specify manually)
    set "collateChoice="
    set /p collateChoice=Enter your choice (1/2/3/4):
    
    :: 根据用户选择设置排序规则
    if "%collateChoice%"=="1" set collation=%charset%_general_ci
    if "%collateChoice%"=="2" set collation=%charset%_unicode_ci
    if "%collateChoice%"=="3" set collation=%charset%_bin
    if "%collateChoice%"=="4" (
        set /p collation=Enter collation name: 
    )
    goto end_collation_choice

:non_standard_collation
    :: 对于不支持预定义排序规则的字符集，直接要求用户输入
    set /p collation=Enter collation name for %charset%:

:end_collation_choice

:: 创建数据库
echo.
echo Creating database [%newdbname%] with character set [%charset%] and collation [%collation%]...
mysql -u %dbuser% -p%dbpass% -e "CREATE DATABASE %newdbname% CHARACTER SET %charset% COLLATE %collation%;"
if errorlevel 1 (
    echo Failed to create database. Please check your inputs and try again.
) else (
    echo Database [%newdbname%] created successfully!
)
goto postop

:comparedb
echo Please enter the first database to compare:
:compare_db1_select
set /p "dbchoice=Enter database number (1-%lastindex%) or database name: "
set "db1="
:: Check if input is a number
set "isNumber=true"
for /f "delims=0123456789" %%i in ("%dbchoice%") do set "isNumber=false"
if "%isNumber%"=="true" (
    if %dbchoice% geq 1 if %dbchoice% leq %lastindex% (
        call set "db1=%%dbname_%dbchoice%%%"
    )
) else (
    set "db1=%dbchoice%"
)
mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;" | findstr /i /x "%db1%" >nul
if errorlevel 1 (
    echo Database [%db1%] does not exist. Please enter a valid number or name.
    goto compare_db1_select
)

echo Please enter the second database to compare:
:compare_db2_select
set /p "dbchoice=Enter database number (1-%lastindex%) or database name: "
set "db2="
:: Check if input is a number
set "isNumber=true"
for /f "delims=0123456789" %%i in ("%dbchoice%") do set "isNumber=false"
if "%isNumber%"=="true" (
    if %dbchoice% geq 1 if %dbchoice% leq %lastindex% (
        call set "db2=%%dbname_%dbchoice%%%"
    )
) else (
    set "db2=%dbchoice%"
)
mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;" | findstr /i /x "%db2%" >nul
if errorlevel 1 (
    echo Database [%db2%] does not exist. Please enter a valid number or name.
    goto compare_db2_select
)
set db1tables=db1_tables.txt
set db2tables=db2_tables.txt
mysql -u %dbuser% -p%dbpass% -e "SHOW TABLES IN %db1%;" | findstr /v /i "Tables_in_" > %db1tables%
mysql -u %dbuser% -p%dbpass% -e "SHOW TABLES IN %db2%;" | findstr /v /i "Tables_in_" > %db2tables%
echo.
echo Tables in [%db1%]:
type %db1tables%
echo.
echo Tables in [%db2%]:
type %db2tables%
findstr /v /i /g:%db2tables% %db1tables% > db1_only.txt
findstr /v /i /g:%db1tables% %db2tables% > db2_only.txt
set diff=0
for /f %%s in ('type db1_only.txt db2_only.txt 2^>nul') do (
    set diff=1
    goto :check_diff
)
:check_diff
if %diff%==1 (
    if exist db1_only.txt (
        echo [33mTables only in [%db1%]:[0m
        type db1_only.txt
    )
    if exist db2_only.txt (
        echo [33mTables only in [%db2%]:[0m
        type db2_only.txt
    )
    echo [33mDatabases[%db1% to %db2%] are NOT identical![0m
) else (
    echo [32mDatabases[%db1% to %db2%] are identical![0m
)
del %db1tables% %db2tables% db1_only.txt db2_only.txt
goto postop

:backupdb
:: Select database by number or name
:backupdb_select
set /p "dbchoice=Enter database number (1-%lastindex%) or database name: "
set "backupdb="
:: Check if input is a number
set "isNumber=true"
for /f "delims=0123456789" %%i in ("%dbchoice%") do set "isNumber=false"
if "%isNumber%"=="true" (
    if %dbchoice% geq 1 if %dbchoice% leq %lastindex% (
        call set "backupdb=%%dbname_%dbchoice%%%"
    )
) else (
    set "backupdb=%dbchoice%"
)
:: Validate database exists
mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;" | findstr /i /x "%backupdb%" >nul
if errorlevel 1 (
    echo Database [%backupdb%] does not exist. Please enter a valid number or name.
    goto backupdb_select
)

:backupmode_select
echo How do you want to backup?
echo 1. Export to external file
echo 2. Copy to another database
set /p backupmode=Please enter the number of your choice (1/2):
set backupmode=%backupmode: =%
if "%backupmode%"=="1" goto backupfile
if "%backupmode%"=="2" goto backupcopy
echo Invalid choice, please try again.
goto backupmode_select

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
    echo [32mTable lists are identical between source[%backupdb%] and target[%newdb%] databases.[0m
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
    echo.
    echo [33mWARNING: [%backupdb% to %newdb%] Table lists are not identical![0m
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
:: Select database by number or name
:deletedb_select
set "dbchoice="
set /p "dbchoice=Enter database number (1-%lastindex%) or database name to delete:"
:: Check if input is empty
if "%dbchoice%"=="" (
    echo Please enter a valid database number or name.
    goto mainmenu
)
set "deletedb="
:: Check if input is a number
set "isNumber=true"
for /f "delims=0123456789" %%i in ("%dbchoice%") do set "isNumber=false"
if "%isNumber%"=="true" (
    if %dbchoice% geq 1 if %dbchoice% leq %lastindex% (
        call set "deletedb=%%dbname_%dbchoice%%%"
    )
) else (
    set "deletedb=%dbchoice%"
)
:: Validate database exists
mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;" | findstr /i /x "%deletedb%" >nul
if errorlevel 1 (
    echo Database [%deletedb%] does not exist. Please enter a valid number or name.
    goto deletedb_select
)

:: Ask for confirmation before deleting
:confirm_delete
echo.
echo [31mWARNING: This action will permanently delete the database [%deletedb%]![0m
echo [31mAll data in this database will be lost and cannot be recovered.[0m
echo.
set "confirm="
set /p "confirm=Are you sure you want to delete the database [%deletedb%]? (Y/N): "

:: Process confirmation input
if /i "%confirm%"=="Y" (
    mysql -u %dbuser% -p%dbpass% -e "DROP DATABASE %deletedb%;"
    echo Database [%deletedb%] has been deleted.
) else if /i "%confirm%"=="N" (
    echo Deletion of database [%deletedb%] has been cancelled.
) else (
    echo Invalid input. Please enter Y or N.
    goto confirm_delete
)

goto postop

:operatedb
:: Select database by number or name
:operatedb_select
set /p "dbchoice=Enter database number (1-%lastindex%) or database name to operate: "
set "dbname="
:: Check if input is a number
set "isNumber=true"
for /f "delims=0123456789" %%i in ("%dbchoice%") do set "isNumber=false"
if "%isNumber%"=="true" (
    if %dbchoice% geq 1 if %dbchoice% leq %lastindex% (
        call set "dbname=%%dbname_%dbchoice%%%"
    )
) else (
    set "dbname=%dbchoice%"
)
:: Validate database exists
mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;" | findstr /i /x "%dbname%" >nul
if errorlevel 1 (
    echo Database [%dbname%] does not exist. Please enter a valid number or name.
    goto operatedb_select
)
echo.
echo All tables in database [%dbname%]:
set tableindex=1
for /f "skip=1 tokens=*" %%i in ('mysql -u %dbuser% -p%dbpass% -e "SHOW TABLES IN %dbname%;"') do (
    echo !tableindex!. %%i
    set "tablename_!tableindex!=%%i"
    set /a tableindex+=1
)
set /a lasttableindex=tableindex-1

:table_select
set /p "tablechoice=Enter table number (1-%lasttableindex%) or table name to view:"
set "tablename="
:: Check if input is a number
set "isNumber=true"
for /f "delims=0123456789" %%i in ("%tablechoice%") do set "isNumber=false"
if "%isNumber%"=="true" (
    if %tablechoice% geq 1 if %tablechoice% leq %lasttableindex% (
        call set "tablename=%%tablename_%tablechoice%%%"
    )
) else (
    set "tablename=%tablechoice%"
)

:choose_view
echo.
echo How do you want to view table [%tablename%]?
echo 1. View all columns and data
echo 2. View specific column values
echo 3. Return to main menu

set /p viewchoice=choose_view Enter your choice (1/2/3):
if "%viewchoice%"=="3" goto postop
if "%viewchoice%"=="1" goto show_all_data
if "%viewchoice%"=="2" goto show_columns
echo Invalid choice.
goto choose_view

:show_all_data
echo.
echo Displaying all contents of table [%tablename%]:
mysql -u %dbuser% -p%dbpass% -e "SELECT * FROM %dbname%.%tablename%;"

:after_view
echo.
echo What would you like to do next?
echo 1. View another table in database [%dbname%]
echo 2. Choose another view option for table [%tablename%]
echo 3. Return to main menu
set /p nextaction=Enter your choice (1/2/3): 

if "%nextaction%"=="1" (
    echo.
    echo All tables in database [%dbname%]:
    set tableindex=1
    for /f "skip=1 tokens=*" %%i in ('mysql -u %dbuser% -p%dbpass% -e "SHOW TABLES IN %dbname%;"') do (
        echo !tableindex!. %%i
        set "tablename_!tableindex!=%%i"
        set /a tableindex+=1
    )
    set /a lasttableindex=tableindex-1
    goto table_select
)
if "%nextaction%"=="2" goto choose_view
if "%nextaction%"=="3" goto postop
echo Invalid choice.
goto after_view

:show_columns
echo.
echo Available columns in table [%tablename%]:
set colindex=1
>"%temp%\cols.tmp" (
    for /f "skip=1 tokens=1" %%c in ('mysql -u %dbuser% -p%dbpass% -e "DESCRIBE %dbname%.%tablename%;"') do (
        echo !colindex!. %%c
        set "colname_!colindex!=%%c"
        set /a colindex+=1
    )
)
set /a lastcolindex=colindex-1
type "%temp%\cols.tmp"
del "%temp%\cols.tmp"

:choose_column
set /p "colchoice=Enter column number (1-%lastcolindex%) or column name to view: "
set "colname="
echo %colchoice%| findstr /r "^[1-9][0-9]*$" >nul
if %errorlevel%==0 (
    if %colchoice% leq %lastcolindex% (
        call set "colname=%%colname_%colchoice%%%"
    )
)
if "%colname%"=="" set "colname=%colchoice%"

:: 验证列是否存在
mysql -u %dbuser% -p%dbpass% -e "SELECT %colname% FROM %dbname%.%tablename% LIMIT 1" >nul 2>&1
if errorlevel 1 (
    echo Invalid column name [%colname%]
    goto choose_column
)

echo.
echo Displaying values for column [%colname%] in table [%tablename%]:
mysql -u %dbuser% -p%dbpass% -e "SELECT DISTINCT %colname% FROM %dbname%.%tablename%;"
goto after_view

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
goto postop

:postop
echo.
set dbindex=1
set dbnameindex=
for /f "skip=1 tokens=*" %%d in ('mysql -u %dbuser% -p%dbpass% -e "SHOW DATABASES;"') do (
    echo !dbindex!. %%d
    set "dbname_!dbindex!=%%d"
    set /a dbindex+=1
)
set /a lastindex=dbindex-1
echo.
set /p continue=Do you want to continue? (Y/N):
if /I "%continue%"=="Y" goto mainmenu
echo Exiting...
pause
exit

