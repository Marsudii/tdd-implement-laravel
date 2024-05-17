# Test Driven Development

## Requirements Login
 - Jika Login null/kosong maka tampilkan pesan errors email dan password (422)
 - Jika Login email kosong maka tampilkan pesan errors email is required (422)
 - Jika Login password kosong maka tampilkan pesan errors password is required (422)
 - Jika Login email/password salah maka tampilkan pesan Unauthorized (401)
 - jika Login email/password benar maka tampilkan pesan Login Successfully (200)


## Requirements Users
 - Jika data user tidak membawa token maka error (401)
 - jika data user membawa token tapi tidak invalid maka error (401)
 - Jika data user membawa token yang valid maka berhasil (200)

XDEBUG_MODE=coverage ./vendor/bin/pest --coverage
