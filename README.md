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
```
cd /home/backend/didin_tenda

echo "=================================================="
echo "1. CEK FILE LOG AUTO COMMIT"
echo "=================================================="
ls -lah /home/backend/.auto_git_didin_tenda/ 2>/dev/null || true

echo ""
echo "=================================================="
echo "2. ISI LOG AUTO COMMIT TERAKHIR"
echo "=================================================="
tail -n 200 /home/backend/.auto_git_didin_tenda/auto_git_commit.log 2>/dev/null || true

echo ""
echo "=================================================="
echo "3. CEK LOG CRON RUNNER"
echo "=================================================="
tail -n 120 /home/backend/didin_tenda/cron_git_runner.log 2>/dev/null || true

echo ""
echo "=================================================="
echo "4. CEK CRON USER BACKEND"
echo "=================================================="
crontab -l 2>/dev/null || true

echo ""
echo "=================================================="
echo "5. CEK STATUS GIT SAAT INI"
echo "=================================================="
git status --short

echo ""
echo "=================================================="
echo "6. CEK BRANCH DAN REMOTE"
echo "=================================================="
git branch --show-current
git remote -v

echo ""
echo "=================================================="
echo "7. CEK PESAN ERROR PENTING DI LOG"
echo "=================================================="
grep -iE "error|fatal|gagal|failed|denied|permission|fetch|rebase|push|commit|tidak ada perubahan|no changes|nothing" /home/backend/.auto_git_didin_tenda/auto_git_commit.log 2>/dev/null | tail -n 80 || true
```