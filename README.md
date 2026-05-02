# PT DIDIN TENDA DECORATION

### SPEC :
```
laravel 12
```
### untuk email :
```
https://myaccount.google.com/apppasswords?rapt=AEjHL4Mu-hDddL5SD9WMo8lP00VSRY2vQDSE_opYk3BB_MiGgC-yWfepEdePo8wfuOlfyxipXLgmspPCKdzn-QWptyqI1DKc-h1L1m3QDWEZw0Z14Ymu4Eo
```
setelah itu set password menggunakan email sendiri 
### kalo misalkan raugadh error : 
install npm, nodejs
```
apt update
apt install -y curl ca-certificates gnupg
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt install -y nodejs

node -v
npm -v
```
### di folder laravel nya : 
```
cd /var/www/html

rm -f public/hot

npm install
npm run build

php artisan optimize:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear
```