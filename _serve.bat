@ECHO OFF
"C:\Program Files (x86)\Google\Chrome\Application\chrome.exe" --chrome --kiosk http://127.0.0.1:8000 --disable-pinch --overscroll-history-navigation=0
echo Program has been started. You may close this window now.
cd C:\xampp\htdocs\pos-2016
php artisan serve --host=127.0.0.1 --port=8000
EXIT