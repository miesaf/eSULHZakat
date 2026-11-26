# CLAUDE.md

Project memory for Claude Code. Keep it short and current. Never commit credentials, server addresses, account names or
database names; the hosting details live in the owner's private notes.

## What this is

**e-Asnaf Transfer / e-SULH Zakat** (2017): native PHP pages on the SB Admin 2 theme (Bootstrap 3), MySQL, UI in Malay.
An innovation-competition concept for transferring zakat to asnaf (recipients) across states. **Archived project** in
the owner's project archive (https://app.dimensikini.xyz/zakat/, folder `zakat`).

- History: first at `dimensikini.xyz/dkr/zakat` (mysql_* code), then the mysqli version on app.dimensikini.xyz (2020-22,
  PHP 7.4). Ported to PHP 8.5 on 2026-11-26 (ClickUp `86d4e29py`, under `86d4e29pu`). Its own `.htaccess` pins PHP 8.5
  (`SetHandler application/x-lsphp85`); keep the pin even though the whole archive site defaults to PHP 8.5 since 2026-11-27.

## Data

Tables (`sql/esulh_db_structure.sql`): `ASNAF` (recipients, key `NO_KP` = IC number), `MUZAKKI` (payers), `NEGERI`
(states; each row is also the admin login of that state's zakat body), `PERMOHONAN` (applications: household counts,
`KIFAYAH_BAKI` / `KIFAYAH_KREDIT` in whole ringgit, `LOG_BAYARAN` = payment log stored with `<br>` separators),
`CADANG_ASNAF` (public suggestions, `BUKTI` = file in `bukti/`), lookups `DAERAH`, `PERUMAHAN`, `JENIS_ASNAF`, `BANK`.
The host MySQL is case-sensitive: table names are upper case. Rows hold IC numbers, phone numbers and bank accounts of
real people: never copy real data or uploads into the repo or an issue.

Pages: public `index.php` (muzakki login; `checkLogin.php` also takes `akaun` 1 = asnaf, 3 = admin), `daftar_muzakki.php`,
`daftar_asnaf.php` (unlinked), `cadang_asnaf.php` (suggest, with upload), `input.php` (unlinked "bypass" form: asnaf +
application, had kifayah computed there); logged in: `utama.php`, `senarai_permohonan*.php` / `senarai_cadangan.php`
(filter by state, district, housing area), `rincian.php`, `rincian_cadangan.php`, `cetak.php`, `bukti.php` (serves a
proof), `bayar.php` (muzakki only; the balance check and update are one `UPDATE ... WHERE KIFAYAH_BAKI >= ?`).

## Code conventions (2026 port — keep them)

- `connectDB.php` reads `config.php` (git-ignored; copy `config.example.php`), sets `mysqli_report(MYSQLI_REPORT_OFF)`,
  a non-strict `sql_mode` and the `Asia/Kuala_Lumpur` time zone, and defines `db_query($sql, [$params])` (prepared
  statements), `db_value()`, `e()` (HTML escape), `js()` (JS string), `log_html()`, `request_text()` / `request_id()` /
  `request_ic()` / `request_count()`, `kod_sah()`, `asnaf_fields()`, `permohonan_row()`, `js_alert()` and
  `require_login([$roles])`. Never interpolate request data into SQL.
- Session keys are prefixed `zakat_` (other apps on the same host share the session cookie); roles `ASNF`, `MZKI`, `ADMN`.
- Passwords: `password_hash()` / `password_verify()`; a plain-text password left in the DB is hashed on its first login;
  an empty password never logs in. `tools/set-password.php` sets one.
- Uploads (`cadang_asnaf.php`): PDF/JPG/PNG checked by extension and content (finfo), 5 MB, random file names in
  `bukti/`, which `bukti/.htaccess` closes to the web (no direct access, no PHP); `bukti.php` serves them to logged-in
  users. Uploaded files are git-ignored.
- Payment statement mail: sender and optional Bcc from `config.php` (`mail_from`, `mail_bcc`).
- Pages start with `<?php ob_start(); ?>` so `session_start()` and `header()` work after HTML.
- `.htaccess` denies `config*.php`, `connectDB.php`, `sql/`, `tools/`, `*.md`, `LICENSE*`, logs.
- No AI attribution in commits or PRs.

## Local test

PHP 8.5 with mysqli and fileinfo, and a local MariaDB (the owner uses EnvKit). Import a dump, run
`sql/2026-11-hash-passwords.sql`, write `config.php`, then
`php -d display_errors=1 -d error_reporting=-1 -d sendmail_path=<a script that writes to a file> -S 127.0.0.1:8132 -t .`
(the dump has real e-mail addresses: never let a test payment send real mail). The built-in server ignores `.htaccess`,
so check the deny rules on the real host.

## Status (2026-11-27)

- Deployed on 2026-11-26 (PR #1, PHP 8.5.13) to the `zakat` folder. ClickUp `86d4e29py` is complete.
- The 4 NEGERI admin accounts whose passwords were in the public repo were locked with random hashes (owner's OK).
  Open: the owner sets new ones with `tools/set-password.php admin <code>`. Old passwords stay in git history.
- The archive's root `.htaccess` (not in this repo) also refuses `..` requests and serves no `connectDB.php`, `config.json`,
  `*.sql`, `*.log`, `*.md`, `error_log`, `LICENSE*` or composer/package files in any folder.

## Deploy

No git on the host. Upload `master` with `git archive master | ssh … 'tar -x -C …/public_html/zakat'`; `config.php`
(mode 600) and the files in `bukti/` stay on the server and are never overwritten. Schema changes go in `sql/` and are
run by hand. Every change on the server needs the owner's OK: show the exact commands first. Smoke test: pages answer
200 on PHP 8.5, and `config.php`, `connectDB.php`, `sql/`, `tools/`, `error_log` and any file under `bukti/` answer 403.
