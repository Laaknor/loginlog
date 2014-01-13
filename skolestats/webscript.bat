@echo off
if %time:~0,-9% LEQ 9 goto test


set thistime=%time:~0,-3%

goto web

:test
rem echo below
set thistime=%time:~1,-3%



:web

REM 12.7.2007 - THL, Umoe: Endret fra UNC til mapping for å kunne brukes fra andre lokasjoner:
p:\prog\loginlog\wget.exe http://10.5.48.205/loginlog/login-web.php?username=%username%^&hostname=%userdomain%^&date=%date%^&time=%thistime%^&clientname=%clientname%^&context=%lcontext%^&company=%company%^&shellversion=%shellversion%^&loginserver=%file_server%^&department=%department%^&location=%location%^&title=%title%


:end

