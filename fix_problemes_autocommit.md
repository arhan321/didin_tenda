# Panduan Auto Backup Commit ke GitHub

Dokumentasi ini digunakan untuk menangani masalah pada sistem auto backup Git yang berjalan otomatis melalui cron.

Project ini menggunakan script:

```bash
/home/backend/didin_tenda/auto_git_commit.sh
```

Cron berjalan menggunakan konfigurasi:

```bash
* * * * * /bin/bash /home/backend/didin_tenda/auto_git_commit.sh >> /home/backend/didin_tenda/cron_git_runner.log 2>&1
```

Log utama script berada di:

```bash
/home/backend/.auto_git_didin_tenda/auto_git_commit.log
```

Log runner cron berada di:

```bash
/home/backend/didin_tenda/cron_git_runner.log
```

---

## 1. Cek Log Auto Backup

Jika auto commit atau push tidak berjalan, cek log utama:

```bash
tail -n 200 /home/backend/.auto_git_didin_tenda/auto_git_commit.log
```

Cek juga log cron:

```bash
tail -n 100 /home/backend/didin_tenda/cron_git_runner.log
```

Untuk mencari error penting:

```bash
grep -Ei "ERROR|fatal|denied|failed|gagal|conflict|rebase|Author identity|refspec|Permission|index.lock" /home/backend/.auto_git_didin_tenda/auto_git_commit.log | tail -n 100
```

---

## 2. Error `.git/index.lock`

Jika muncul error seperti ini:

```bash
fatal: Unable to create '/home/backend/didin_tenda/.git/index.lock': File exists.
```

Artinya Git sedang terkunci.

Biasanya terjadi karena:

1. Proses Git sebelumnya crash atau terputus.
2. Cron berjalan terlalu sering.
3. Ada proses `git add`, `git commit`, atau `git push` yang belum selesai.
4. File database besar sedang berubah saat Git melakukan commit.
5. File engine database ikut masuk Git saat database masih berjalan.

### Cara memperbaiki

Masuk ke folder project:

```bash
cd /home/backend/didin_tenda
```

Cek apakah masih ada proses Git yang berjalan:

```bash
ps aux | grep -E '[g]it|[s]sh .*github|auto_git_commit'
```

Jika tidak ada proses Git yang masih aktif, hapus file lock:

```bash
rm -f /home/backend/didin_tenda/.git/index.lock
```

Reset index Git:

```bash
git reset
```

Cek status file:

```bash
git status --short
```

Jalankan script manual:

```bash
/bin/bash /home/backend/didin_tenda/auto_git_commit.sh
```

Cek log hasilnya:

```bash
tail -n 120 /home/backend/.auto_git_didin_tenda/auto_git_commit.log
```

---

## 3. Stop Cron Sementara Saat Perbaikan

Agar cron tidak terus berjalan saat proses perbaikan, nonaktifkan dulu cron.

Buka crontab:

```bash
crontab -e
```

Comment baris cron:

```bash
# * * * * * /bin/bash /home/backend/didin_tenda/auto_git_commit.sh >> /home/backend/didin_tenda/cron_git_runner.log 2>&1
```

Setelah masalah selesai, aktifkan lagi dengan menghapus tanda `#`.

---

## 4. Tes Koneksi SSH ke GitHub

Gunakan perintah ini:

```bash
ssh -i /etc/ssh/github_keys/id_ed25519_github -o IdentitiesOnly=yes -T git@github.com
```

Jika berhasil, akan muncul pesan seperti:

```bash
Hi arhan321! You've successfully authenticated, but GitHub does not provide shell access.
```

Jika muncul:

```bash
Permission denied (publickey)
```

Berarti SSH key belum benar, permission salah, atau public key belum ditambahkan ke GitHub.

---

## 5. Cek Permission SSH Key

Pastikan permission SSH key benar:

```bash
sudo chown -R backend:backend /etc/ssh/github_keys
sudo chmod 700 /etc/ssh/github_keys
sudo chmod 600 /etc/ssh/github_keys/id_ed25519_github
sudo chmod 644 /etc/ssh/github_keys/id_ed25519_github.pub
```

Cek file key:

```bash
ls -lah /etc/ssh/github_keys
```

---

## 6. Error `Author identity unknown`

Jika muncul error:

```bash
Author identity unknown
```

Set user Git untuk project:

```bash
cd /home/backend/didin_tenda
git config user.name "backend auto backup"
git config user.email "arhanmali96@gmail.com"
```

Atau global:

```bash
git config --global user.name "backend auto backup"
git config --global user.email "arhanmali96@gmail.com"
```

---

## 7. Error Branch / Refspec

Jika muncul error seperti:

```bash
src refspec master does not match any
```

Cek branch aktif:

```bash
cd /home/backend/didin_tenda
git branch --show-current
```

Jika branch target adalah `master`, pastikan branch aktif juga `master`:

```bash
git branch -M master
```

Cek remote:

```bash
git remote -v
```

Pastikan remote mengarah ke repo yang benar:

```bash
git remote set-url origin git@github.com:arhan321/didin_tenda.git
```

---

## 8. Error Conflict Saat Pull Rebase

Jika muncul error seperti:

```bash
CONFLICT
```

Artinya ada konflik antara file lokal dan file di GitHub.

Cek status:

```bash
git status
```

Jika ingin membatalkan rebase:

```bash
git rebase --abort
```

Jika ingin lanjut setelah memperbaiki konflik:

```bash
git add --all .
git rebase --continue
```

Setelah selesai:

```bash
git push origin master
```

---

## 9. Catatan Penting Backup Database

Folder database engine seperti ini bisa berubah terus saat database sedang aktif:

```bash
database/data/aria_log.00000001
database/data/aria_log_control
database/data/ib_logfile0
database/data/ib_logfile1
database/data/ibdata1
database/data/ibtmp1
```

File tersebut adalah file engine database MariaDB/MySQL/InnoDB.

Jika tetap ingin membackup file engine database ke GitHub, sebaiknya database dalam keadaan berhenti terlebih dahulu agar file tidak berubah saat sedang di-commit.

Namun cara yang lebih aman adalah membackup database dalam bentuk file `.sql`, misalnya:

```bash
backup_database/src/upload/uploads/backup/*.sql
```

File `.sql` lebih aman untuk backup karena berupa dump database, bukan file engine database yang sedang aktif.

---

## 10. Saran Jadwal Cron

Cron setiap 1 menit bisa terlalu sering, apalagi jika file backup database besar.

Cron saat ini:

```bash
* * * * * /bin/bash /home/backend/didin_tenda/auto_git_commit.sh >> /home/backend/didin_tenda/cron_git_runner.log 2>&1
```

Saran setiap 10 menit:

```bash
*/10 * * * * /bin/bash /home/backend/didin_tenda/auto_git_commit.sh >> /home/backend/didin_tenda/cron_git_runner.log 2>&1
```

Saran setiap 30 menit:

```bash
*/30 * * * * /bin/bash /home/backend/didin_tenda/auto_git_commit.sh >> /home/backend/didin_tenda/cron_git_runner.log 2>&1
```

---

## 11. Perintah Pemulihan Cepat

Gunakan perintah ini jika auto commit macet karena `.git/index.lock`:

```bash
cd /home/backend/didin_tenda
ps aux | grep -E '[g]it|[s]sh .*github|auto_git_commit'
rm -f .git/index.lock
git reset
/bin/bash /home/backend/didin_tenda/auto_git_commit.sh
tail -n 120 /home/backend/.auto_git_didin_tenda/auto_git_commit.log
```

---

## 12. Perintah Cek Manual Lengkap

```bash
cd /home/backend/didin_tenda

echo "Cek branch:"
git branch --show-current

echo "Cek remote:"
git remote -v

echo "Cek status:"
git status --short

echo "Tes SSH GitHub:"
ssh -i /etc/ssh/github_keys/id_ed25519_github -o IdentitiesOnly=yes -T git@github.com

echo "Jalankan auto commit manual:"
/bin/bash /home/backend/didin_tenda/auto_git_commit.sh

echo "Lihat log:"
tail -n 120 /home/backend/.auto_git_didin_tenda/auto_git_commit.log
```

---

## 13. Kesimpulan

Jika auto backup GitHub tidak berjalan, cek urutannya:

1. Cek log utama.
2. Cek apakah ada `.git/index.lock`.
3. Cek proses Git yang masih berjalan.
4. Hapus `.git/index.lock` jika tidak ada proses Git aktif.
5. Jalankan `git reset`.
6. Tes SSH GitHub.
7. Jalankan script manual.
8. Aktifkan kembali cron.

Masalah paling umum:

```bash
fatal: Unable to create '.git/index.lock': File exists.
```

Solusi paling cepat:

```bash
cd /home/backend/didin_tenda
rm -f .git/index.lock
git reset
/bin/bash /home/backend/didin_tenda/auto_git_commit.sh
```
