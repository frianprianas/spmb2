-- Script untuk membuat database SPMB
-- Jalankan dengan: psql -U postgres -f create_database.sql

-- Drop database jika sudah ada (HATI-HATI: ini akan menghapus semua data)
-- DROP DATABASE IF EXISTS spmb_smk;

-- Buat database baru
CREATE DATABASE spmb_smk
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Indonesian_Indonesia.1252'
    LC_CTYPE = 'Indonesian_Indonesia.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;

-- Berikan akses penuh ke user postgres
GRANT ALL PRIVILEGES ON DATABASE spmb_smk TO postgres;

-- Pesan sukses
\echo 'Database spmb_smk berhasil dibuat!'
\echo 'Silakan jalankan: php artisan migrate'
