#!/usr/bin/env bash

set -Eeuo pipefail

export PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
export HOME=/home/backend

PROJECT_DIR="/home/backend/didin_tenda"
BRANCH="master"

# Ganti repo ini kalau nama repository GitHub kamu berbeda
REPO_SSH="git@github.com:arhan321/didin_tenda.git"

# Global SSH key untuk semua project GitHub
SSH_KEY="/etc/ssh/github_keys/id_ed25519_github"
export GIT_SSH_COMMAND="ssh -i $SSH_KEY -o IdentitiesOnly=yes -o StrictHostKeyChecking=accept-new"

RUNTIME_DIR="/home/backend/.auto_git_didin_tenda"
LOG_FILE="$RUNTIME_DIR/auto_git_commit.log"
LOCK_FILE="$RUNTIME_DIR/auto_git_commit.lock"

mkdir -p "$RUNTIME_DIR"

{
    flock -n 9 || {
        echo "[$(date '+%Y-%m-%d %H:%M:%S')] Script masih berjalan, skip."
        exit 0
    }

    echo "=================================================="
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Mulai auto commit didin_tenda..."

    if [ ! -d "$PROJECT_DIR" ]; then
        echo "[$(date '+%Y-%m-%d %H:%M:%S')] ERROR: Project directory tidak ditemukan: $PROJECT_DIR"
        exit 1
    fi

    if [ ! -f "$SSH_KEY" ]; then
        echo "[$(date '+%Y-%m-%d %H:%M:%S')] ERROR: SSH key tidak ditemukan: $SSH_KEY"
        exit 1
    fi

    if [ ! -r "$SSH_KEY" ]; then
        echo "[$(date '+%Y-%m-%d %H:%M:%S')] ERROR: SSH key tidak bisa dibaca oleh user $(whoami): $SSH_KEY"
        echo "[$(date '+%Y-%m-%d %H:%M:%S')] Fix permission:"
        echo "sudo chown -R backend:backend /etc/ssh/github_keys"
        echo "sudo chmod 700 /etc/ssh/github_keys"
        echo "sudo chmod 600 /etc/ssh/github_keys/id_ed25519_github"
        echo "sudo chmod 644 /etc/ssh/github_keys/id_ed25519_github.pub"
        exit 1
    fi

    chmod 700 /home/backend/.ssh 2>/dev/null || true

    cd "$PROJECT_DIR"

    git config --global --add safe.directory "$PROJECT_DIR" 2>/dev/null || true
    git config core.fileMode false 2>/dev/null || true

    if [ ! -d ".git" ]; then
        echo "[$(date '+%Y-%m-%d %H:%M:%S')] Git belum di-init, menjalankan git init..."
        git init
        git branch -M "$BRANCH"
    fi

    if git remote get-url origin >/dev/null 2>&1; then
        git remote set-url origin "$REPO_SSH"
    else
        git remote add origin "$REPO_SSH"
    fi

    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Project dir: $PROJECT_DIR"
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Branch target: $BRANCH"
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Branch aktif: $(git branch --show-current)"
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] SSH key aktif: $SSH_KEY"

    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Remote aktif:"
    git remote -v

    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Tes koneksi SSH GitHub..."
    ssh -i "$SSH_KEY" -o IdentitiesOnly=yes -o StrictHostKeyChecking=accept-new -T git@github.com || true

    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Status perubahan sebelum add:"
    git status --short

    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Menambahkan semua file..."
    git add --all .

    if git diff --cached --quiet; then
        echo "[$(date '+%Y-%m-%d %H:%M:%S')] Tidak ada perubahan untuk di-commit."
    else
        git commit -m "auto commit didin_tenda: $(date '+%Y-%m-%d %H:%M:%S')"
    fi

    echo "[$(date '+%Y-%m-%d %H:%M:%S')] Push ke GitHub..."

    if git push origin "$BRANCH"; then
        echo "[$(date '+%Y-%m-%d %H:%M:%S')] Auto commit dan push berhasil."
    else
        echo "[$(date '+%Y-%m-%d %H:%M:%S')] Push gagal, coba pull rebase lalu push ulang..."
        git pull --rebase --autostash origin "$BRANCH"
        git push origin "$BRANCH"
        echo "[$(date '+%Y-%m-%d %H:%M:%S')] Auto commit dan push berhasil setelah rebase."
    fi

} 9>"$LOCK_FILE" >> "$LOG_FILE" 2>&1