@ECHO OFF
"C:\Users\Acer\AppData\Local\Programs\Opera\launcher.exe" --chrome --kiosk --args --incognito http://127.0.0.1:8000 --disable-pinch --overscroll-history-navigation=0
cd C:\xampp\htdocs\pos-2016
php artisan serve --host=127.0.0.1 --port=8000
EXIT