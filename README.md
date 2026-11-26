# e-SULH Zakat / e-Asnaf Transfer

e-SULH Zakat atau e-Asnaf Transfer adalah satu projek prototaip (2017) untuk menyepadukan sistem pembayaran zakat bagi
setiap negeri di Malaysia, dibangunkan untuk seorang pensyarah Akademi Pengajian Islam Kontemporari (ACIS), UiTM
Cawangan Melaka, bagi pertandingan inovasi. Muzakki (pembayar zakat) mendaftar, melihat senarai permohonan asnaf
mengikut negeri, daerah atau kawasan perumahan, dan membayar zakat terus ke akaun asnaf; orang awam boleh mencadangkan
asnaf baru dengan bukti pendapatan.

Archived project, live at https://app.dimensikini.xyz/zakat/ on PHP 8.5.

## Setup

1. Create a MySQL/MariaDB database and import `sql/esulh_db_structure.sql` (reference data only, no accounts).
2. Copy `config.example.php` to `config.php` and fill in the database credentials (and the optional mail sender / blind
   copy for payment statements).
3. Set the state zakat bodies' admin passwords: `php tools/set-password.php admin <state code>` (asks for the password).
   Muzakki register at `daftar_muzakki.php`.

An older database with plain-text passwords: run `sql/2026-11-hash-passwords.sql`, then `php tools/hash-passwords.php`.

The `bukti/` folder must be writable by PHP; it holds uploaded proofs of income and is never served directly.
