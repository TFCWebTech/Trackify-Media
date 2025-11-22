# Trackify-Media Setup Guide

This guide will help you set up and run the Trackify-Media application on XAMPP (Windows).

## Prerequisites

Before starting, ensure you have:
- ✅ **XAMPP** installed and running (Apache & MySQL)
- ✅ **PHP 8.2 or higher** (included with XAMPP)
- ✅ **Composer** installed globally
- ✅ **Node.js** and **npm** installed
- ✅ **Git** (optional, for version control)

## Step-by-Step Setup

### Step 1: Start XAMPP Services

1. Open **XAMPP Control Panel**
2. Start **Apache** server
3. Start **MySQL** server

### Step 2: Create Database

1. Open **phpMyAdmin** (http://localhost/phpmyadmin)
2. Click on **"New"** to create a new database
3. Name it: `newsreport` (or your preferred name)
4. Select **Collation**: `utf8mb4_unicode_ci`
5. Click **"Create"**

### Step 3: Configure Environment File

1. Navigate to the project directory:
   ```powershell
   cd C:\xampp\htdocs\Trackify-Media
   ```

2. Create `.env` file (copy from `.env.example` if it exists, or create new):
   ```powershell
   # If .env.example exists:
   copy .env.example .env
   
   # Or create manually
   ```

3. Edit `.env` file with your database credentials:
   ```env
   APP_NAME="Trackify Media"
   APP_ENV=local
   APP_KEY=
   APP_DEBUG=true
   APP_TIMEZONE=UTC
   APP_URL=http://localhost/Trackify-Media/public

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=newsreport
   DB_USERNAME=root
   DB_PASSWORD=

   BROADCAST_CONNECTION=log
   FILESYSTEM_DISK=local
   QUEUE_CONNECTION=database

   SESSION_DRIVER=database
   SESSION_LIFETIME=120

   MAIL_MAILER=smtp
   MAIL_HOST=localhost
   MAIL_PORT=2525
   MAIL_USERNAME=null
   MAIL_PASSWORD=null
   MAIL_ENCRYPTION=null
   MAIL_FROM_ADDRESS="hello@example.com"
   MAIL_FROM_NAME="${APP_NAME}"
   ```

### Step 4: Install PHP Dependencies

1. Open PowerShell/Command Prompt in the project directory
2. Install Composer dependencies:
   ```powershell
   composer install
   ```

   **Note:** If you don't have Composer installed, download it from https://getcomposer.org/

### Step 5: Generate Application Key

```powershell
php artisan key:generate
```

This will automatically update your `.env` file with `APP_KEY`.

### Step 6: Run Database Migrations

```powershell
php artisan migrate
```

This will create all necessary database tables.

### Step 7: Install Node.js Dependencies

```powershell
npm install
```

### Step 8: Build Frontend Assets (Development)

For development:
```powershell
npm run dev
```

For production:
```powershell
npm run build
```

**Note:** Keep `npm run dev` running in a separate terminal window during development.

### Step 9: Set Up Storage Link

```powershell
php artisan storage:link
```

### Step 10: Set Permissions (if needed)

Ensure these directories are writable:
- `storage/`
- `bootstrap/cache/`

### Step 11: Access the Application

1. **Admin/Reporter Login:**
   - URL: `http://localhost/Trackify-Media/public/`
   - Or: `http://localhost/Trackify-Media/public/login`

2. **Client Dashboard Login:**
   - URL: `http://localhost/Trackify-Media/public/admin-login`

## Quick Start Commands (All at Once)

If you want to run all setup commands in sequence:

```powershell
# Navigate to project
cd C:\xampp\htdocs\Trackify-Media

# Install dependencies
composer install
npm install

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate

# Link storage
php artisan storage:link

# Build assets (in separate terminal)
npm run dev
```

## Troubleshooting

### Issue: PHP Version Error - "requires php ^8.2 but your php version (8.1.x) does not satisfy"
**Problem:** Your current PHP version is 8.1.x, but Laravel 11 requires PHP 8.2 or higher.

**Solutions:**

#### Option 1: Upgrade XAMPP (Recommended)
1. Download the latest XAMPP version with PHP 8.2+ from: https://www.apachefriends.org/
2. Install it (you can keep your existing htdocs folder)
3. Restart Apache and MySQL from XAMPP Control Panel
4. Verify PHP version:
   ```powershell
   php -v
   ```
   Should show PHP 8.2.x or higher

#### Option 2: Manually Upgrade PHP in XAMPP
1. Stop Apache in XAMPP Control Panel
2. Download PHP 8.2+ from: https://windows.php.net/download/
3. Extract to a temporary folder
4. Backup your current PHP folder: `C:\xampp\php` → `C:\xampp\php_backup`
5. Copy new PHP files to `C:\xampp\php` (replace old files)
6. Copy `php.ini` from backup and update paths if needed
7. Restart Apache
8. Verify: `php -v`

#### Option 3: Use Standalone PHP (if you have it installed)
If you have PHP 8.2+ installed separately, update your system PATH:
1. Find where PHP 8.2+ is installed
2. Add it to Windows PATH environment variable
3. Restart terminal/command prompt
4. Verify: `php -v`

**After upgrading PHP, run:**
```powershell
composer install
```

### Issue: "Class not found" or Autoload errors
**Solution:**
```powershell
composer dump-autoload
```

### Issue: Database connection error
**Solution:**
- Verify MySQL is running in XAMPP
- Check database credentials in `.env`
- Ensure database `newsreport` exists

### Issue: 500 Internal Server Error
**Solution:**
- Check `storage/logs/laravel.log` for errors
- Ensure `APP_DEBUG=true` in `.env` for detailed errors
- Verify file permissions on `storage/` and `bootstrap/cache/`

### Issue: Assets not loading
**Solution:**
- Run `npm run dev` or `npm run build`
- Clear browser cache
- Check `public/build/` directory exists

### Issue: Route not found
**Solution:**
```powershell
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

## Development Workflow

1. **Start XAMPP** (Apache & MySQL)
2. **Run Vite dev server** (in one terminal):
   ```powershell
   npm run dev
   ```
3. **Access application** at `http://localhost/Trackify-Media/public/`

## Production Deployment

For production:
1. Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`
2. Run `npm run build` to compile assets
3. Run `php artisan config:cache` and `php artisan route:cache`
4. Ensure proper file permissions

## Additional Notes

- Default database name: `newsreport`
- Default MySQL user: `root` (no password)
- Application uses Laravel 11.9 with PHP 8.2+
- Frontend uses Vite for asset compilation

---

**Need Help?** Check Laravel documentation: https://laravel.com/docs

