#!/usr/bin/env bash

set -Eeuo pipefail

export PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
export HOME=/home/backend

PROJECT_DIR="/home/backend/didin_tenda"
BRANCH="master"
REMOTE_URL="git@github.com:arhan321/didin_tenda.git"

# Global SSH key untuk semua project GitHub
SSH_KEY="/etc/ssh/github_keys/id_ed25519_github"
export GIT_SSH_COMMAND="ssh -i $SSH_KEY -o IdentitiesOnly=yes -o StrictHostKeyChecking=accept-new"

RUNTIME_DIR="/home/backend/.auto_git_didin_tenda"
LOG_FILE="$RUNTIME_DIR/auto_git_commit.log"
LOCK_FILE="$RUNTIME_DIR/auto_git_commit.lock"

# Sesuai kebutuhan bro: .env dan backup database tetap ikut GitHub sebagai sarana backup.
# Catatan: pastikan repository GitHub kamu private kalau file ini berisi credential/database asli.
INCLUDE_ENV_FILE="true"
INCLUDE_BACKUP_SQL="true"
INCLUDE_RAW_DB_DATA="true"

# Kalau auto-detect service database kurang cocok, isi manual.
# Contoh:
# DB_SERVICES_MANUAL="db"
# DB_SERVICES_MANUAL="mysql"
# DB_SERVICES_MANUAL="mariadb"
DB_SERVICES_MANUAL=""

DB_SERVICES_STOPPED="false"
DB_SERVICES=""

# Folder backup SQL yang biasa dipakai di project ini.
BACKUP_SQL_DIRS=(
    "backup_database/src/uploads/backup"
    "backup_database/src/upload/uploads/backup"
)

# Folder raw database engine files. Folder akan di-force add hanya kalau benar-benar ada.
RAW_DB_DIRS=(
    "db/data"
    "database/data"
    "mysql/data"
    "mariadb/data"
)

mkdir -p "$RUNTIME_DIR"

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

docker_compose_cmd() {
    if command -v docker >/dev/null 2>&1 && docker compose version >/dev/null 2>&1; then
        echo "docker compose"
        return 0
    fi

    if command -v docker-compose >/dev/null 2>&1; then
        echo "docker-compose"
        return 0
    fi

    return 1
}

raw_db_dir_exists() {
    local dir

    for dir in "${RAW_DB_DIRS[@]}"; do
        if [ -d "$PROJECT_DIR/$dir" ]; then
            return 0
        fi
    done

    return 1
}

detect_db_services() {
    cd "$PROJECT_DIR"

    if [ -n "$DB_SERVICES_MANUAL" ]; then
        DB_SERVICES="$DB_SERVICES_MANUAL"
        return 0
    fi

    local dc
    dc="$(docker_compose_cmd || true)"

    if [ -z "$dc" ]; then
        DB_SERVICES=""
        return 0
    fi

    DB_SERVICES="$($dc config --services 2>/dev/null | grep -Ei '^(db|database|mysql|mariadb)$|mysql|mariadb' || true)"
}

stop_database_services() {
    if [ "$INCLUDE_RAW_DB_DATA" != "true" ]; then
        return 0
    fi

    if ! raw_db_dir_exists; then
        log "Raw db engine dir tidak ditemukan. Database service tidak perlu distop."
        return 0
    fi

    cd "$PROJECT_DIR"

    detect_db_services

    if [ -z "$DB_SERVICES" ]; then
        log "WARNING: Service database tidak terdeteksi otomatis."
        log "Raw database akan tetap di-commit, tapi database mungkin masih hidup."
        log "Kalau mau aman, isi DB_SERVICES_MANUAL di script, contoh: DB_SERVICES_MANUAL=\"db\""
        return 0
    fi

    local dc
    dc="$(docker_compose_cmd || true)"

    if [ -z "$dc" ]; then
        log "WARNING: docker compose/docker-compose tidak ditemukan. Database tidak bisa distop otomatis."
        return 0
    fi

    log "Stop service database sebelum commit raw database:"
    echo "$DB_SERVICES"

    # shellcheck disable=SC2086
    $dc stop $DB_SERVICES

    DB_SERVICES_STOPPED="true"
}

start_database_services() {
    if [ "$DB_SERVICES_STOPPED" != "true" ]; then
        return 0
    fi

    if [ -z "$DB_SERVICES" ]; then
        return 0
    fi

    cd "$PROJECT_DIR"

    local dc
    dc="$(docker_compose_cmd || true)"

    if [ -z "$dc" ]; then
        log "WARNING: docker compose/docker-compose tidak ditemukan. Database tidak bisa distart otomatis."
        return 0
    fi

    log "Start ulang service database:"
    echo "$DB_SERVICES"

    # shellcheck disable=SC2086
    $dc start $DB_SERVICES

    DB_SERVICES_STOPPED="false"
}

on_exit() {
    local exit_code=$?

    if [ "$DB_SERVICES_STOPPED" = "true" ]; then
        log "Script selesai/gagal. Menyalakan ulang database..."
        start_database_services || true
    fi

    exit "$exit_code"
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

check_requirements() {
    if [ ! -d "$PROJECT_DIR" ]; then
        log "ERROR: Project directory tidak ditemukan: $PROJECT_DIR"
        exit 1
    fi

    if [ ! -f "$SSH_KEY" ]; then
        log "ERROR: SSH key tidak ditemukan: $SSH_KEY"
        exit 1
    fi

    if [ ! -r "$SSH_KEY" ]; then
        log "ERROR: SSH key tidak bisa dibaca oleh user $(whoami): $SSH_KEY"
        log "Jalankan:"
        log "sudo chown -R backend:backend /etc/ssh/github_keys"
        log "sudo chmod 700 /etc/ssh/github_keys"
        log "sudo chmod 600 /etc/ssh/github_keys/id_ed25519_github"
        log "sudo chmod 644 /etc/ssh/github_keys/id_ed25519_github.pub"
        exit 1
    fi
}

init_git_if_needed() {
    cd "$PROJECT_DIR"

    if [ ! -d "$PROJECT_DIR/.git" ]; then
        log "Git belum di-init. Menjalankan git init..."
        git init
        git branch -M "$BRANCH" 2>/dev/null || true
    fi
}

check_git_integrity() {
    cd "$PROJECT_DIR"

    if ! git rev-parse --git-dir >/dev/null 2>&1; then
        log "ERROR: Repository Git tidak valid."
        exit 1
    fi

    chmod -R u+rwX "$PROJECT_DIR/.git" 2>/dev/null || true

    if ! git rev-parse --verify HEAD >/dev/null 2>&1; then
        log "HEAD belum punya commit. Lanjut sebagai initial commit."
        return 0
    fi

    local empty_objects
    empty_objects="$(find "$PROJECT_DIR/.git/objects" -type f -empty 2>/dev/null || true)"

    if [ -n "$empty_objects" ]; then
        log "ERROR: Ditemukan object Git kosong/rusak:"
        echo "$empty_objects"
        log "Auto commit dihentikan supaya repository tidak makin rusak."
        exit 1
    fi

    if ! git fsck --connectivity-only --no-dangling >/dev/null 2>&1; then
        log "ERROR: Git fsck gagal. Repository kemungkinan masih bermasalah."
        log "Auto commit dihentikan."
        exit 1
    fi
}

check_git_state() {
    cd "$PROJECT_DIR"

    if [ -d "$PROJECT_DIR/.git/rebase-merge" ] || [ -d "$PROJECT_DIR/.git/rebase-apply" ]; then
        log "ERROR: Ada proses rebase Git yang belum selesai."
        log "Cek manual: cd $PROJECT_DIR && git status"
        log "Jika ingin batalkan: cd $PROJECT_DIR && git rebase --abort"
        exit 1
    fi

    if [ -f "$PROJECT_DIR/.git/MERGE_HEAD" ]; then
        log "ERROR: Ada proses merge Git yang belum selesai."
        log "Cek manual: cd $PROJECT_DIR && git status"
        log "Jika ingin batalkan: cd $PROJECT_DIR && git merge --abort"
        exit 1
    fi
}

setup_git_repo() {
    cd "$PROJECT_DIR"

    chmod 700 /home/backend/.ssh 2>/dev/null || true
    chmod 700 /etc/ssh/github_keys 2>/dev/null || true
    chmod 600 "$SSH_KEY" 2>/dev/null || true
    chmod 644 "$SSH_KEY.pub" 2>/dev/null || true

    if ! git config --global --get-all safe.directory | grep -Fx "$PROJECT_DIR" >/dev/null 2>&1; then
        git config --global --add safe.directory "$PROJECT_DIR" 2>/dev/null || true
    fi

    git config core.fileMode false 2>/dev/null || true

    local current_remote
    current_remote="$(git remote get-url origin 2>/dev/null || true)"

    if [ -z "$current_remote" ]; then
        log "Remote origin belum ada. Menambahkan origin..."
        git remote add origin "$REMOTE_URL"
    elif [ "$current_remote" != "$REMOTE_URL" ]; then
        log "Remote origin berbeda. Mengubah remote origin..."
        log "Remote lama: $current_remote"
        log "Remote baru: $REMOTE_URL"
        git remote set-url origin "$REMOTE_URL"
    fi

    local active_branch
    active_branch="$(git branch --show-current || true)"

    if [ -z "$active_branch" ]; then
        log "Branch aktif kosong. Membuat/memakai branch $BRANCH..."
        git checkout -B "$BRANCH"
        active_branch="$BRANCH"
    elif [ "$active_branch" != "$BRANCH" ]; then
        log "Branch aktif bukan $BRANCH. Mencoba checkout ke $BRANCH..."

        if git show-ref --verify --quiet "refs/heads/$BRANCH"; then
            git checkout "$BRANCH"
        else
            git checkout -B "$BRANCH"
        fi

        active_branch="$(git branch --show-current || true)"
    fi

    log "Project dir: $PROJECT_DIR"
    log "Branch target: $BRANCH"
    log "Branch aktif: ${active_branch:-unknown}"
    log "SSH key aktif: $SSH_KEY"
}

sync_with_remote_before_commit() {
    cd "$PROJECT_DIR"

    log "Fetch remote terbaru tanpa mengandalkan FETCH_HEAD..."
    git fetch origin "$BRANCH" --prune

    if ! git rev-parse --verify "origin/$BRANCH" >/dev/null 2>&1; then
        log "origin/$BRANCH belum ada. Lanjut commit lalu push branch baru."
        return 0
    fi

    if ! git rev-parse --verify HEAD >/dev/null 2>&1; then
        log "Local HEAD belum ada. Skip sync remote sebelum initial commit."
        return 0
    fi

    local local_sha
    local remote_sha
    local base_sha

    local_sha="$(git rev-parse HEAD)"
    remote_sha="$(git rev-parse "origin/$BRANCH")"
    base_sha="$(git merge-base HEAD "origin/$BRANCH")"

    if [ "$local_sha" = "$remote_sha" ]; then
        log "Branch lokal sudah sama dengan origin/$BRANCH."
        return 0
    fi

    if [ "$local_sha" = "$base_sha" ]; then
        log "Branch lokal tertinggal dari origin/$BRANCH. Menjalankan pull rebase..."
        git pull --rebase --autostash origin "$BRANCH"
        return 0
    fi

    if [ "$remote_sha" = "$base_sha" ]; then
        log "Branch lokal lebih maju dari origin/$BRANCH. Lanjut commit/push."
        return 0
    fi

    log "Branch lokal dan remote berbeda/diverged. Mencoba pull rebase dengan autostash..."
    git pull --rebase --autostash origin "$BRANCH"
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
            git add -f "$rel_path" 2>/dev/null || true
        done
    done
}

stage_env_file() {
    if [ "$INCLUDE_ENV_FILE" != "true" ]; then
        git restore --staged -- .env 2>/dev/null || true
        return 0
    fi

    cd "$PROJECT_DIR"

    if [ -f "$PROJECT_DIR/.env" ]; then
        log "Force stage .env sesuai kebutuhan backup."
        git add -f .env 2>/dev/null || true
    fi
}

stage_raw_db_dirs() {
    if [ "$INCLUDE_RAW_DB_DATA" != "true" ]; then
        local dir
        for dir in "${RAW_DB_DIRS[@]}"; do
            git restore --staged -- "$dir" 2>/dev/null || true
        done
        return 0
    fi

    cd "$PROJECT_DIR"

    local dir

    for dir in "${RAW_DB_DIRS[@]}"; do
        if [ ! -d "$PROJECT_DIR/$dir" ]; then
            continue
        fi

        log "Force stage raw database dir: $dir"
        git add -f "$dir" 2>/dev/null || true
    done
}

unstage_runtime_and_lock_files() {
    cd "$PROJECT_DIR"

    git restore --staged -- auto_git_commit.log 2>/dev/null || true
    git restore --staged -- cron_git_runner.log 2>/dev/null || true
    git restore --staged -- .gitignore.lock 2>/dev/null || true

    local lock_files
    lock_files="$(git diff --cached --name-only | grep -E '(^|/).*\.lock$' || true)"

    if [ -n "$lock_files" ]; then
        echo "$lock_files" | while read -r lock_path; do
            if [ -n "$lock_path" ]; then
                log "Unstage lock file: $lock_path"
                git restore --staged -- "$lock_path" 2>/dev/null || true
            fi
        done
    fi
}

stage_changes() {
    cd "$PROJECT_DIR"

    log "Status perubahan sebelum add:"
    git status --short

    log "Menambahkan perubahan umum ke staging..."
    git add -A

    stage_env_file
    stage_backup_sql_files
    stage_raw_db_dirs
    unstage_runtime_and_lock_files

    log "Status perubahan setelah staging:"
    git status --short
}

commit_and_push() {
    cd "$PROJECT_DIR"

    if git diff --cached --quiet; then
        log "Tidak ada perubahan untuk di-commit."
    else
        local commit_message
        commit_message="auto commit didin_tenda: $(timestamp)"
        log "Membuat commit: $commit_message"
        git commit -m "$commit_message"
    fi

    log "Push ke GitHub..."

    if git push origin "HEAD:$BRANCH"; then
        log "Auto commit dan push berhasil."
    else
        log "Push gagal. Mencoba fetch + pull rebase lalu push ulang..."

        git fetch origin "$BRANCH" --prune

        if git pull --rebase --autostash origin "$BRANCH"; then
            log "Pull rebase berhasil. Mencoba push ulang..."
            git push origin "HEAD:$BRANCH"
            log "Auto commit dan push berhasil setelah rebase."
        else
            log "ERROR: Pull rebase gagal."
            log "Cek manual: cd $PROJECT_DIR && git status"
            exit 1
        fi
    fi
}

{
    flock -n 9 || {
        log "Script masih berjalan, skip."
        exit 0
    }

    trap on_exit EXIT

    echo "=================================================="
    log "Mulai auto commit didin_tenda..."

    check_requirements

    cd "$PROJECT_DIR"

    init_git_if_needed
    cleanup_old_git_locks
    check_git_integrity
    check_git_state
    setup_git_repo

    log "Remote aktif:"
    git remote -v

    log "Cek koneksi SSH GitHub dengan key yang benar..."
    ssh -i "$SSH_KEY" -o IdentitiesOnly=yes -o StrictHostKeyChecking=accept-new -T git@github.com || true

    stop_database_services

    sync_with_remote_before_commit
    stage_changes
    commit_and_push

    start_database_services

    log "Selesai."

} 9>"$LOCK_FILE" >> "$LOG_FILE" 2>&1
