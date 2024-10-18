# Velzon

Velzon

## Requirement

-   Laravel 10+
-   NPM
-   Composer
-   PHP 8.1 or newer
-   MySQL
-   Vue.js (vue3)
-   Inertia.js

### Default Account

`Backoffice`
| Super Admin / IT | |
| ---------------- | ------------------ |
| url | / |
| role | Super Admin |
| us | superadmin@admin.id |
| ps | `password` |

| Admin |                |
| ----- | -------------- |
| url   | /              |
| role  | Admin          |
| us    | admin@admin.id |
| ps    | `password`     |

## Instalation

-   Clone repository from `develop` branch
-   `composer install`
-   `cp .env.example .env`
-   Adjust .env with your environtment
-   `php artisan key:generate`
-   `php artisan migrate --seed`
-   `php artisan storage:link`
-   `npm install`
-   `npm run dev` on `local`
-   `npm run build` on `server`

### On Cpanel

Because `php artisan storage:link` cannot run in cpanel. <br />
Run this instead

```bash
ln -s /home/USERNAME/public_html/DIRECTORY/{folder}/storage/app/public public/storage
```
