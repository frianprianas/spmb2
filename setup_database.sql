-- Script Setup Database SPMB
-- Jalankan dengan: psql -U postgres -f setup_database.sql
-- Masukkan password: buhun666

-- Drop database jika sudah ada (HATI-HATI!)
-- Uncomment baris di bawah jika ingin hapus database lama
-- DROP DATABASE IF EXISTS spmb_smk;

-- Buat database baru
CREATE DATABASE spmb_smk
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    CONNECTION LIMIT = -1;

-- Berikan privilege
GRANT ALL PRIVILEGES ON DATABASE spmb_smk TO postgres;

\echo '==============================================='
\echo 'Database spmb_smk berhasil dibuat!'
\echo 'Silakan lanjutkan dengan:'
\echo '  cd backend'
\echo '  php artisan migrate'
\echo '  php artisan db:seed --class=JurusanSeeder'
\echo '==============================================='
