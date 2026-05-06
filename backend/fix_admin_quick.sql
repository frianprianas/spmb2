-- Quick fix: Update admin untuk pastikan email benar
UPDATE admin SET email = 'admin@smkbaktinusantara666.sch.id' WHERE username = 'admin';

-- Show hasil
SELECT id, username, email, nama, 'password: password' as info FROM admin WHERE username = 'admin';
