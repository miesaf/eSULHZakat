-- 2026-11 PHP 8.5 port: passwords are stored with password_hash(), which needs more than 50 characters.
-- Run once, then run tools/hash-passwords.php to hash the existing plain-text passwords.
ALTER TABLE ASNAF MODIFY KATA_LALUAN varchar(255) NOT NULL;
ALTER TABLE MUZAKKI MODIFY KATA_LALUAN varchar(255) NOT NULL;
ALTER TABLE NEGERI MODIFY KATA_LALUAN varchar(255) NOT NULL;
