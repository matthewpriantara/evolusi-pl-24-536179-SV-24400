#!/bin/bash
set -e

echo "=== Memulai Proses Deployment Laravel ==="

# 1. Masuk ke mode maintenance agar pengguna tidak mengakses saat update
echo "[1/7] Mengaktifkan mode maintenance..."
php artisan down || true

# 2. Menarik kode terbaru dari branch main
echo "[2/7] Menarik perubahan kode terbaru dari repository..."
git pull origin main

# 3. Memasang dependensi PHP untuk production (tanpa paket dev)
echo "[3/7] Menginstall dependencies Composer untuk production..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# 4. Menjalankan migrasi database
echo "[4/7] Menjalankan migrasi database..."
php artisan migrate --force

# 5. Membersihkan & membuat cache konfigurasi
echo "[5/7] Melakukan caching konfigurasi aplikasi..."
php artisan config:cache

# 6. Melakukan caching routing aplikasi
echo "[6/7] Melakukan caching routing..."
php artisan route:cache

# 7. Mematikan mode maintenance (aplikasi aktif kembali)
echo "[7/7] Mematikan mode maintenance (aplikasi kembali online)..."
php artisan up

echo "=== Deployment Berhasil Diselesaikan! ==="