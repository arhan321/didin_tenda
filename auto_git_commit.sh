#!/usr/bin/env bash

set -Eeuo pipefail

# ==================================================
# AUTO GIT BACKUP - DIDIN TENDA
# Root/Super User Mode + Auto Repair .git
# ==================================================
#
# Fitur:
# - Wajib jalan sebagai root/super user.
# - Kalau dijalankan manual oleh user biasa, otomatis relaunch pakai sudo.
# - Tetap backup .env, file .sql, dan raw database folder.
# - Kalau .git corrupt / HEAD rusak / object kosong, script otomatis repair
#   dengan mengambil .git bersih dari GitHub tanpa mengubah isi folder project.
# - Tidak stop/start container database.
#
# Catatan:
# - Commit raw database saat database hidup bisa tidak konsisten.
# - Backup paling aman tetap file dump .sql, tapi raw DB tetap ikut di-force add
#   sesuai kebutuhan backup server.

# --------------------------------------------------
# Jalankan sebagai root
# --------------------------------------------------
if [ "$(id -u)" -ne 0 ]; then
    echo "[INFO] Script butuh root/super user. Menjalankan ulang dengan sudo..."
    exec sudo -E /bin/bash "$0" "$@"
fi

export PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
export HOME=/root

PROJECT_DIR="/home/backend/didin_tenda"
BRANCH="master"
REMOTE_URL="git@github.com:arhan321/didin_tenda.git"

# Global SSH key untuk semua project GitHub
SSH_KEY="/etc/ssh/github_keys/id_ed25519_github"
export GIT_SSH_COMMAND="ssh -i $SSH_KEY -o IdentitiesOnly=yes -o StrictHostKeyChecking=accept-new"

# Log tetap di folder lama agar mudah dicek seperti biasa
RUNTIME_DIR="/home/backend/.auto_git_didin_tenda"
LOG_FILE="$RUNTIME_DIR/auto_git_commit.log"

# Lock root mode agar cron tiap menit tidak menumpuk
LOCK_FILE="/var/lock/auto_git_didin_tenda.lock"

# Identitas commit
GIT_USER_NAME="Didin Tenda Auto Backup"
GIT_USER_EMAIL="arhanmali96@gmail.com"

# Sesuai kebutuhan:
# - .env ikut GitHub sebagai backup.
# - file backup .sql ikut GitHub walaupun kena .gitignore.
# - raw database folder ikut GitHub kalau foldernya ada.
INCLUDE_ENV_FILE="true"
INCLUDE_BACKUP_SQL="true"
INCLUDE_RAW_DB_DATA="true"

# Folder backup SQL yang biasa dipakai di project ini.
BACKUP_SQL_DIRS=(
    "backup_database/src/uploads/backup"
    "backup_database/src/upload/uploads/backup"
    "backup_database/src/upload/backup"
    "backup_database/src/uploads/backup"
)

# Folder raw database engine files.
# Folder akan di-force add hanya kalau benar-benar ada.
RAW_DB_DIRS=(
    "db/data"
    "database/data"
    "mysql/data"
    "mariadb/data"
)

mkdir -p "$RUNTIME_DIR"
touch "$LOG_FILE" 2>/dev/null || true

timestamp() {
    date '+%Y-%m-%d %H:%M:%S'
}

log() {
    echo "[$(timestamp)] $*"
}

is_file_in_use() {
    local file="$1"

    if command -v fuser >/dev/null 2>&1; then
        fuser "$file" >/dev/null 2>&1
        return $?
    fi

    if command -v lsof >/dev/null 2>&1; then
        lsof "$file" >/dev/null 2>&1
        return $?
    fi

    return 1
}

run_git() {
    GIT_SSH_COMMAND="$GIT_SSH_COMMAND" git "$@"
}

check_requirements() {
    if [ ! -d "$PROJECT_DIR" ]; then
        log "ERROR: Project directory tidak ditemukan: $PROJECT_DIR"
        exit 1
    fi

    if [ ! -f "$SSH_KEY" ]; then
        log "ERROR: SSH key tidak ditemukan: $SSH_KEY"
        exit 1
    fi

    chmod 700 "$(dirname "$SSH_KEY")" 2>/dev/null || true
    chmod 600 "$SSH_KEY" 2>/dev/null || true
    chmod 644 "$SSH_KEY.pub" 2>/dev/null || true

    if [ ! -r "$SSH_KEY" ]; then
        log "ERROR: SSH key tidak bisa dibaca oleh root: $SSH_KEY"
        exit 1
    fi
}

setup_git_identity_and_safe_dir() {
    run_git config --global user.name "$GIT_USER_NAME" 2>/dev/null || true
    run_git config --global user.email "$GIT_USER_EMAIL" 2>/dev/null || true

    if ! run_git config --global --get-all safe.directory | grep -Fx "$PROJECT_DIR" >/dev/null 2>&1; then
        run_git config --global --add safe.directory "$PROJECT_DIR" 2>/dev/null || true
    fi
}

cleanup_old_git_locks() {
    cd "$PROJECT_DIR"

    if [ ! -d "$PROJECT_DIR/.git" ]; then
        return 0
    fi

    local old_locks
    old_locks="$(find "$PROJECT_DIR/.git" -type f -name "*.lock" -mmin +3 2>/dev/null || true)"

    if [ -z "$old_locks" ]; then
        return 0
    fi

    log "Git lock lama ditemukan:"
    echo "$old_locks"

    echo "$old_locks" | while read -r lock_file; do
        if [ -z "$lock_file" ] || [ ! -f "$lock_file" ]; then
            continue
        fi

        if is_file_in_use "$lock_file"; then
            log "Lock masih dipakai proses aktif, tidak dihapus: $lock_file"
            continue
        fi

        log "Menghapus Git lock lama: $lock_file"
        rm -f "$lock_file"
    done
}

repair_git_metadata_from_remote() {
    log "Mulai repair metadata .git tanpa backup folder project..."

    cd "$PROJECT_DIR"

    local ts
    local tmp_clone
    local corrupt_git_dir

    ts="$(date +%F_%H%M%S)"
    tmp_clone="/tmp/didin_tenda_clean_$ts"
    corrupt_git_dir="/tmp/didin_tenda_git_corrupt_$ts"

    if [ -d "$PROJECT_DIR/.git" ]; then
        log "Memindahkan .git rusak ke: $corrupt_git_dir"
        mv "$PROJECT_DIR/.git" "$corrupt_git_dir"
    fi

    rm -rf "$tmp_clone"

    log "Clone repository bersih dari GitHub ke temporary folder..."
    if ! run_git clone -b "$BRANCH" "$REMOTE_URL" "$tmp_clone"; then
        log "ERROR: Gagal clone repository dari GitHub."
        log "Cek SSH key, akses repo, atau koneksi internet."
        exit 1
    fi

    log "Menyalin .git bersih ke project lama..."
    cp -a "$tmp_clone/.git" "$PROJECT_DIR/.git"
    rm -rf "$tmp_clone"

    chmod -R u+rwX "$PROJECT_DIR/.git" 2>/dev/null || true

    setup_git_identity_and_safe_dir

    cd "$PROJECT_DIR"

    if run_git rev-parse --verify HEAD >/dev/null 2>&1; then
        log "Repair .git berhasil. File project tetap di folder lama."
    else
        log "ERROR: Repair .git gagal. HEAD masih tidak valid."
        exit 1
    fi
}

init_git_if_needed() {
    cd "$PROJECT_DIR"

    if [ ! -d "$PROJECT_DIR/.git" ]; then
        log ".git tidak ditemukan. Akan repair dari remote GitHub."
        repair_git_metadata_from_remote
    fi
}

check_git_integrity_or_repair() {
    cd "$PROJECT_DIR"

    if ! run_git rev-parse --git-dir >/dev/null 2>&1; then
        log "Repository Git tidak valid. Akan repair .git."
        repair_git_metadata_from_remote
        return 0
    fi

    chmod -R u+rwX "$PROJECT_DIR/.git" 2>/dev/null || true

    if ! run_git rev-parse --verify HEAD >/dev/null 2>&1; then
        log "HEAD Git rusak/belum valid. Akan repair .git dari remote."
        repair_git_metadata_from_remote
        return 0
    fi

    local empty_objects
    empty_objects="$(find "$PROJECT_DIR/.git/objects" -type f -empty 2>/dev/null || true)"

    if [ -n "$empty_objects" ]; then
        log "Ditemukan object Git kosong/rusak:"
        echo "$empty_objects"
        log "Akan repair .git otomatis dari remote."
        repair_git_metadata_from_remote
        return 0
    fi

    if ! run_git fsck --connectivity-only --no-dangling >/dev/null 2>&1; then
        log "Git fsck gagal. Repository kemungkinan bermasalah."
        log "Akan repair .git otomatis dari remote."
        repair_git_metadata_from_remote
        return 0
    fi

    log "Git integrity OK."
}

check_git_state() {
    cd "$PROJECT_DIR"

    if [ -d "$PROJECT_DIR/.git/rebase-merge" ] || [ -d "$PROJECT_DIR/.git/rebase-apply" ]; then
        log "Ada proses rebase Git yang belum selesai. Membatalkan rebase..."
        run_git rebase --abort || true
    fi

    if [ -f "$PROJECT_DIR/.git/MERGE_HEAD" ]; then
        log "Ada proses merge Git yang belum selesai. Membatalkan merge..."
        run_git merge --abort || true
    fi
}

setup_git_repo() {
    cd "$PROJECT_DIR"

    setup_git_identity_and_safe_dir

    run_git config core.fileMode false 2>/dev/null || true

    local current_remote
    current_remote="$(run_git remote get-url origin 2>/dev/null || true)"

    if [ -z "$current_remote" ]; then
        log "Remote origin belum ada. Menambahkan origin..."
        run_git remote add origin "$REMOTE_URL"
    elif [ "$current_remote" != "$REMOTE_URL" ]; then
        log "Remote origin berbeda. Mengubah remote origin..."
        log "Remote lama: $current_remote"
        log "Remote baru: $REMOTE_URL"
        run_git remote set-url origin "$REMOTE_URL"
    fi

    local active_branch
    active_branch="$(run_git branch --show-current || true)"

    if [ -z "$active_branch" ]; then
        log "Branch aktif kosong. Membuat/memakai branch $BRANCH..."
        run_git checkout -B "$BRANCH"
        active_branch="$BRANCH"
    elif [ "$active_branch" != "$BRANCH" ]; then
        log "Branch aktif bukan $BRANCH. Mencoba checkout ke $BRANCH..."

        if run_git show-ref --verify --quiet "refs/heads/$BRANCH"; then
            run_git checkout "$BRANCH"
        else
            run_git checkout -B "$BRANCH"
        fi

        active_branch="$(run_git branch --show-current || true)"
    fi

    log "User aktif: $(whoami)"
    log "Project dir: $PROJECT_DIR"
    log "Branch target: $BRANCH"
    log "Branch aktif: ${active_branch:-unknown}"
    log "Remote URL: $REMOTE_URL"
    log "SSH key aktif: $SSH_KEY"
}

sync_with_remote_before_commit() {
    cd "$PROJECT_DIR"

    log "Fetch remote terbaru..."
    if ! run_git fetch origin "$BRANCH" --prune; then
        log "WARNING: Fetch remote gagal. Lanjut commit lokal dulu."
        return 0
    fi

    if ! run_git rev-parse --verify "origin/$BRANCH" >/dev/null 2>&1; then
        log "origin/$BRANCH belum ada. Lanjut commit lalu push branch baru."
        return 0
    fi

    if ! run_git rev-parse --verify HEAD >/dev/null 2>&1; then
        log "Local HEAD belum ada. Skip sync remote sebelum initial commit."
        return 0
    fi

    local local_sha
    local remote_sha
    local base_sha

    local_sha="$(run_git rev-parse HEAD)"
    remote_sha="$(run_git rev-parse "origin/$BRANCH")"
    base_sha="$(run_git merge-base HEAD "origin/$BRANCH" || true)"

    if [ "$local_sha" = "$remote_sha" ]; then
        log "Branch lokal sudah sama dengan origin/$BRANCH."
        return 0
    fi

    if [ "$local_sha" = "$base_sha" ]; then
        log "Branch lokal tertinggal dari origin/$BRANCH. Menjalankan pull rebase..."
        if ! run_git pull --rebase --autostash origin "$BRANCH"; then
            log "WARNING: Pull rebase gagal. Membatalkan rebase jika ada, lanjut commit lokal."
            run_git rebase --abort || true
        fi
        return 0
    fi

    if [ "$remote_sha" = "$base_sha" ]; then
        log "Branch lokal lebih maju dari origin/$BRANCH. Lanjut commit/push."
        return 0
    fi

    log "Branch lokal dan remote berbeda/diverged. Mencoba pull rebase dengan autostash..."
    if ! run_git pull --rebase --autostash origin "$BRANCH"; then
        log "WARNING: Pull rebase diverged gagal. Membatalkan rebase jika ada."
        run_git rebase --abort || true
    fi
}

stage_backup_sql_files() {
    if [ "$INCLUDE_BACKUP_SQL" != "true" ]; then
        return 0
    fi

    cd "$PROJECT_DIR"

    local dir
    local sql_file
    local rel_path

    for dir in "${BACKUP_SQL_DIRS[@]}"; do
        if [ ! -d "$PROJECT_DIR/$dir" ]; then
            continue
        fi

        for sql_file in "$PROJECT_DIR/$dir"/*.sql; do
            if [ ! -f "$sql_file" ]; then
                continue
            fi

            rel_path="${sql_file#$PROJECT_DIR/}"

            if is_file_in_use "$sql_file"; then
                log "Skip backup SQL karena masih dipakai proses lain: $rel_path"
                continue
            fi

            log "Force stage backup SQL: $rel_path"
            run_git add -f "$rel_path" 2>/dev/null || true
        done
    done
}

stage_env_file() {
    cd "$PROJECT_DIR"

    if [ "$INCLUDE_ENV_FILE" != "true" ]; then
        run_git restore --staged -- .env 2>/dev/null || true
        return 0
    fi

    if [ -f "$PROJECT_DIR/.env" ]; then
        log "Force stage .env sesuai kebutuhan backup."
        run_git add -f .env 2>/dev/null || true
    fi
}

stage_raw_db_dirs() {
    cd "$PROJECT_DIR"

    if [ "$INCLUDE_RAW_DB_DATA" != "true" ]; then
        local dir
        for dir in "${RAW_DB_DIRS[@]}"; do
            run_git restore --staged -- "$dir" 2>/dev/null || true
        done
        return 0
    fi

    local dir

    log "INCLUDE_RAW_DB_DATA=true, container database TIDAK akan distop."

    for dir in "${RAW_DB_DIRS[@]}"; do
        if [ ! -d "$PROJECT_DIR/$dir" ]; then
            continue
        fi

        log "Force stage raw database dir tanpa stop container: $dir"
        run_git add -f "$dir" 2>/dev/null || {
            log "WARNING: Gagal stage sebagian/seluruh raw database dir: $dir"
            log "Kemungkinan file sedang berubah/permission tidak cukup. Script tetap lanjut."
        }
    done
}

unstage_runtime_and_lock_files() {
    cd "$PROJECT_DIR"

    run_git restore --staged -- auto_git_commit.log 2>/dev/null || true
    run_git restore --staged -- cron_git_runner.log 2>/dev/null || true
    run_git restore --staged -- .gitignore.lock 2>/dev/null || true
    run_git restore --staged -- "$LOG_FILE" 2>/dev/null || true

    local lock_files
    lock_files="$(run_git diff --cached --name-only | grep -E '(^|/).*\.lock$' || true)"

    if [ -n "$lock_files" ]; then
        echo "$lock_files" | while read -r lock_path; do
            if [ -n "$lock_path" ]; then
                log "Unstage lock file: $lock_path"
                run_git restore --staged -- "$lock_path" 2>/dev/null || true
            fi
        done
    fi
}

stage_changes() {
    cd "$PROJECT_DIR"

    log "Status perubahan sebelum add:"
    run_git status --short || true

    log "Menambahkan perubahan umum ke staging..."
    run_git add -A

    stage_env_file
    stage_backup_sql_files
    stage_raw_db_dirs
    unstage_runtime_and_lock_files

    log "Status perubahan setelah staging:"
    run_git status --short || true
}

commit_and_push() {
    cd "$PROJECT_DIR"

    if run_git diff --cached --quiet; then
        log "Tidak ada perubahan untuk di-commit."
    else
        local commit_message
        commit_message="auto commit didin_tenda: $(timestamp)"
        log "Membuat commit: $commit_message"
        run_git commit -m "$commit_message"
    fi

    log "Push ke GitHub..."

    if run_git push origin "HEAD:$BRANCH"; then
        log "Auto commit dan push berhasil."
        return 0
    fi

    log "Push gagal. Mencoba fetch + pull rebase lalu push ulang..."

    run_git fetch origin "$BRANCH" --prune || true

    if run_git pull --rebase --autostash origin "$BRANCH"; then
        log "Pull rebase berhasil. Mencoba push ulang..."
        run_git push origin "HEAD:$BRANCH"
        log "Auto commit dan push berhasil setelah rebase."
    else
        log "ERROR: Pull rebase gagal."
        run_git rebase --abort || true
        log "Cek manual: cd $PROJECT_DIR && git status"
        exit 1
    fi
}

main() {
    flock -n 9 || {
        log "Script masih berjalan, skip."
        exit 0
    }

    echo "=================================================="
    log "Mulai auto commit didin_tenda ROOT mode..."

    check_requirements

    cd "$PROJECT_DIR"

    setup_git_identity_and_safe_dir
    init_git_if_needed
    cleanup_old_git_locks
    check_git_integrity_or_repair
    check_git_state
    setup_git_repo

    log "Remote aktif:"
    run_git remote -v || true

    log "Cek koneksi SSH GitHub dengan key yang benar..."
    ssh -i "$SSH_KEY" -o IdentitiesOnly=yes -o StrictHostKeyChecking=accept-new -T git@github.com || true

    sync_with_remote_before_commit
    stage_changes
    commit_and_push

    log "Selesai."
}

main 9>"$LOCK_FILE" >> "$LOG_FILE" 2>&1
