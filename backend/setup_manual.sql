-- Script Manual Setup Database SPMB
-- Untuk PHP 8.0 yang tidak bisa menjalankan artisan migrate

-- 1. Tabel Jurusan
CREATE TABLE jurusan (
    id BIGSERIAL PRIMARY KEY,
    kode_jurusan VARCHAR(10) UNIQUE NOT NULL,
    nama_jurusan VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    kuota INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Tabel Calon Siswa
CREATE TABLE calon_siswa (
    id BIGSERIAL PRIMARY KEY,
    no_pendaftaran VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    jenis_kelamin VARCHAR(1) CHECK (jenis_kelamin IN ('L', 'P')),
    asal_smp VARCHAR(100) NOT NULL,
    jurusan_id BIGINT REFERENCES jurusan(id) ON DELETE CASCADE,
    email VARCHAR(100) UNIQUE NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    status_pembayaran VARCHAR(20) DEFAULT 'belum_bayar' CHECK (status_pembayaran IN ('belum_bayar', 'sudah_bayar', 'verifikasi')),
    status_formulir VARCHAR(20) DEFAULT 'belum_isi' CHECK (status_formulir IN ('belum_isi', 'sudah_isi', 'lengkap')),
    status_pendaftaran VARCHAR(20) DEFAULT 'pending' CHECK (status_pendaftaran IN ('pending', 'diterima', 'ditolak')),
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabel Pembayaran
CREATE TABLE pembayaran (
    id BIGSERIAL PRIMARY KEY,
    calon_siswa_id BIGINT REFERENCES calon_siswa(id) ON DELETE CASCADE,
    no_pembayaran VARCHAR(50) UNIQUE NOT NULL,
    jumlah NUMERIC(15, 2) NOT NULL,
    metode_pembayaran VARCHAR(20) CHECK (metode_pembayaran IN ('transfer', 'cash', 'virtual_account')),
    bukti_pembayaran VARCHAR(255),
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'verified', 'rejected')),
    tanggal_bayar TIMESTAMP NOT NULL,
    tanggal_verifikasi TIMESTAMP,
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Tabel Formulir Lengkap
CREATE TABLE formulir_lengkap (
    id BIGSERIAL PRIMARY KEY,
    calon_siswa_id BIGINT REFERENCES calon_siswa(id) ON DELETE CASCADE,
    
    -- Data Pribadi
    nik VARCHAR(16) NOT NULL,
    nisn VARCHAR(10),
    tempat_lahir VARCHAR(50) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    agama VARCHAR(20) CHECK (agama IN ('Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu')),
    kewarganegaraan VARCHAR(20) DEFAULT 'Indonesia',
    anak_ke INTEGER,
    jumlah_saudara INTEGER,
    no_hp_siswa VARCHAR(20) NOT NULL,
    email_siswa VARCHAR(100) NOT NULL,
    
    -- Alamat
    alamat_lengkap TEXT NOT NULL,
    rt VARCHAR(5) NOT NULL,
    rw VARCHAR(5) NOT NULL,
    kelurahan VARCHAR(50) NOT NULL,
    kecamatan VARCHAR(50) NOT NULL,
    kota VARCHAR(50) NOT NULL,
    provinsi VARCHAR(50) NOT NULL,
    kode_pos VARCHAR(10) NOT NULL,
    
    -- Data Orang Tua - Ayah
    nama_ayah VARCHAR(100) NOT NULL,
    nik_ayah VARCHAR(16),
    pekerjaan_ayah VARCHAR(50) NOT NULL,
    pendidikan_ayah VARCHAR(30) NOT NULL,
    penghasilan_ayah NUMERIC(15, 2),
    no_hp_ayah VARCHAR(20) NOT NULL,
    
    -- Data Orang Tua - Ibu
    nama_ibu VARCHAR(100) NOT NULL,
    nik_ibu VARCHAR(16),
    pekerjaan_ibu VARCHAR(50) NOT NULL,
    pendidikan_ibu VARCHAR(30) NOT NULL,
    penghasilan_ibu NUMERIC(15, 2),
    no_hp_ibu VARCHAR(20) NOT NULL,
    
    -- Data Wali (Optional)
    nama_wali VARCHAR(100),
    hubungan_wali VARCHAR(30),
    pekerjaan_wali VARCHAR(50),
    no_hp_wali VARCHAR(20),
    alamat_wali TEXT,
    
    -- Data SMP/MTs
    npsn_smp VARCHAR(20),
    alamat_smp TEXT,
    tahun_lulus INTEGER NOT NULL,
    nilai_un NUMERIC(5, 2),
    
    -- Dokumen
    foto VARCHAR(255),
    scan_kk VARCHAR(255),
    scan_akta VARCHAR(255),
    scan_ijazah VARCHAR(255),
    
    -- Informasi Tambahan
    prestasi TEXT,
    info_tambahan TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Insert Data Jurusan
INSERT INTO jurusan (kode_jurusan, nama_jurusan, deskripsi, kuota, is_active) VALUES
('RPL', 'Rekayasa Perangkat Lunak', 'Program keahlian yang mempelajari dan mendalami cara-cara pengembangan perangkat lunak termasuk pembuatan, pemeliharaan, manajemen organisasi pengembangan perangkat lunak dan manajemen kualitas.', 36, TRUE),
('DKV', 'Desain Komunikasi Visual', 'Program keahlian yang mempelajari konsep komunikasi dan ungkapan kreatif, teknik dan media dengan memanfaatkan elemen-elemen visual ataupun rupa untuk menyampaikan pesan.', 36, TRUE),
('ANM', 'Animasi', 'Program keahlian yang mempelajari teknik pembuatan animasi 2D dan 3D, motion graphics, dan multimedia interaktif.', 36, TRUE),
('AKT', 'Akuntansi dan Keuangan Lembaga', 'Program keahlian yang mempelajari pencatatan, penggolongan, dan pelaporan transaksi keuangan suatu organisasi atau lembaga.', 36, TRUE),
('PM', 'Pemasaran', 'Program keahlian yang mempelajari strategi pemasaran, manajemen penjualan, digital marketing, dan komunikasi bisnis.', 36, TRUE);

-- 6. Buat tabel untuk Laravel Sanctum (Personal Access Tokens)
CREATE TABLE personal_access_tokens (
    id BIGSERIAL PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) UNIQUE NOT NULL,
    abilities TEXT,
    last_used_at TIMESTAMP,
    expires_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index 
ON personal_access_tokens (tokenable_type, tokenable_id);

-- Selesai!
SELECT 'Database SPMB berhasil disetup!' AS status;
SELECT 'Total jurusan: ' || COUNT(*) AS info FROM jurusan;
