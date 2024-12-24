# Test Driven Development - TDD

## Description
This is a simple project to implement TDD (Test Driven Development) in Laravel 11. This project is a simple authentication system that uses the Laravel default authentication system. This project uses Pestphp as a unit test.

## Tech Stack
- Laravel 11
- Pestphp (unit test)
- Xdebug
- PHP 8.1+ or higher

## Documentation of reading
- medium: https://medium.com/@marsudi11/test-driven-development-implementasi-laravel-pestphp-6d216b1b431b


## Requirements Example TDD
- Jika Login null/kosong maka tampilkan pesan errors email dan password (422)
- Jika Login email kosong maka tampilkan pesan errors email is required (422)
- Jika Login password kosong maka tampilkan pesan errors password is required (422)
- Jika Login email/password salah maka tampilkan pesan Unauthorized (401)
- jika Login email/password benar maka tampilkan pesan Login Successfully (200)

- Jika data user tidak membawa token maka error (401)
- jika data user membawa token tapi tidak invalid maka error (401)
- Jika data user membawa token yang valid maka berhasil (200)


