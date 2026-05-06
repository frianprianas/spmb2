-- Hapus semua data calon siswa dan data terkait
DELETE FROM formulir_lengkap;
DELETE FROM pembayaran;
DELETE FROM verification_tokens;
DELETE FROM calon_siswa;

-- Reset sequence untuk auto increment
ALTER SEQUENCE calon_siswa_id_seq RESTART WITH 1;
ALTER SEQUENCE verification_tokens_id_seq RESTART WITH 1;

-- Tampilkan jumlah data yang tersisa
SELECT 'calon_siswa' as table_name, COUNT(*) as count FROM calon_siswa
UNION ALL
SELECT 'verification_tokens', COUNT(*) FROM verification_tokens
UNION ALL
SELECT 'pembayaran', COUNT(*) FROM pembayaran
UNION ALL
SELECT 'formulir_lengkap', COUNT(*) FROM formulir_lengkap;
