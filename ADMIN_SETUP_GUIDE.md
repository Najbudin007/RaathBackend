# Admin Dashboard Setup Guide

## Integration Complete! ✅

The admin dashboard from the `isckon` directory has been successfully integrated into your RaathBackend project. The dashboard is now accessible at `/admin/login`.

## What Was Done

### 1. **Controllers & Logic**
- ✅ Copied all Admin controllers (Dashboard, Banners, Blogs, Services, etc.)
- ✅ Copied Authentication controllers
- ✅ Copied Request validation classes
- ✅ Copied HTTP Resources for API responses

### 2. **Models & Database**
- ✅ Copied all admin-related models (Banner, Blog, Service, Portfolio, etc.)
- ✅ Copied all database migrations
- ✅ Copied database seeders
- ✅ Copied Enums, Traits, and Mixins

### 3. **Views & Frontend**
- ✅ Copied all admin blade templates
- ✅ Copied auth views
- ✅ Copied layout files
- ✅ Copied public assets (CSS, JS, images)
- ✅ Copied frontend configuration (Vite, PostCSS)

### 4. **Configuration**
- ✅ Updated `composer.json` with Livewire and Spatie Analytics
- ✅ Updated `package.json` with Choices.js
- ✅ Copied config files (analytics, custom, menu)
- ✅ Updated routes (web.php, auth.php)
- ✅ Registered BladeServiceProvider

### 5. **Routes**
- ✅ Admin login now available at: `/admin/login`
- ✅ Dashboard available at: `/dashboard` (requires auth)
- ✅ All admin routes prefixed with `/admin`

## Setup Instructions

### Step 1: Install PHP Dependencies
```bash
cd /Users/mokshya/Desktop/RaathBackend
composer install
```

### Step 2: Install Node Dependencies
```bash
npm install
```

### Step 3: Environment Setup
Make sure your `.env` file has the following configurations:

```env
APP_NAME=RaathBackend
APP_ENV=local
APP_KEY=your-app-key
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
DB_DATABASE=/Users/mokshya/Desktop/RaathBackend/database/database.sqlite

# If using MySQL, use these instead:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=raath_backend
# DB_USERNAME=root
# DB_PASSWORD=

# Session Configuration
SESSION_DRIVER=file
SESSION_LIFETIME=120

# For Google Analytics (optional)
ANALYTICS_VIEW_ID=
```

### Step 4: Generate Application Key (if not already done)
```bash
php artisan key:generate
```

### Step 5: Run Database Migrations
```bash
php artisan migrate
```

### Step 6: Seed Database (Optional)
To populate the database with sample data:
```bash
php artisan db:seed
```

### Step 7: Build Frontend Assets
```bash
npm run build
```

For development with hot reload:
```bash
npm run dev
```

### Step 8: Start the Server
```bash
php artisan serve
```

Or use the custom dev command that runs everything:
```bash
composer dev
```

## Access the Admin Dashboard

1. **Create an Admin User** (if you don't have one):
```bash
php artisan tinker
```

Then in the tinker console:
```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@example.com';
$user->password = bcrypt('password');
$user->role = 'admin';
$user->is_active = true;
$user->save();
```

2. **Visit the Admin Login Page**:
   - URL: `http://localhost:8000/admin/login`
   - Email: `admin@example.com`
   - Password: `password` (or whatever you set)

3. **After Login, Dashboard**:
   - URL: `http://localhost:8000/dashboard`

## Admin Features Available

The integrated admin dashboard includes management for:

- 📊 **Dashboard** - Analytics and overview
- 🎨 **Banners** - Homepage banners
- 📝 **Blogs** - Blog posts and categories
- 🏢 **Services** - Services and categories
- 💼 **Portfolio** - Portfolio items and categories
- 👥 **Teams** - Team members
- 👤 **Clients** - Client management
- 🏛️ **Temples** - Temple information
- 🌳 **Branches** - Branch management
- 📚 **Books** - Book catalog
- 💼 **Careers** - Job postings and roles
- 🏢 **Departments** - Department management
- 📊 **Metrics** - Success metrics
- 🎯 **Tags** - Content tags
- ⚙️ **Settings** - System settings
- 📧 **Subscriptions** - Email subscribers
- 📁 **Media** - File management
- 📈 **Google Analytics** - Analytics dashboard

## Troubleshooting

### Issue: "Class not found" errors
**Solution**: Run `composer dump-autoload`

### Issue: Assets not loading
**Solution**: 
1. Run `npm run build`
2. Clear cache: `php artisan config:clear && php artisan cache:clear`

### Issue: Login redirects to wrong page
**Solution**: Clear route cache: `php artisan route:clear`

### Issue: Database errors
**Solution**: 
1. Check your `.env` database configuration
2. Run migrations again: `php artisan migrate:fresh`

### Issue: Permission denied on storage
**Solution**: 
```bash
chmod -R 775 storage bootstrap/cache
```

## File Structure

```
RaathBackend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers
│   │   │   └── Auth/           # Auth controllers
│   │   ├── Requests/           # Validation requests
│   │   └── Resources/          # API resources
│   ├── Models/                 # All models including admin
│   ├── Enums/                  # Enumerations
│   ├── Traits/                 # Reusable traits
│   ├── Mixins/                 # Mixins
│   └── Providers/              # Service providers
├── config/
│   ├── analytics.php           # Analytics config
│   ├── custom.php              # Custom config
│   └── menu.php                # Menu config
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── public/
│   └── assets/                 # Admin dashboard assets
├── resources/
│   ├── views/
│   │   ├── admin/              # Admin views
│   │   ├── auth/               # Auth views
│   │   └── layouts/            # Layout files
│   ├── css/
│   └── js/
└── routes/
    ├── web.php                 # Web routes (includes admin)
    ├── auth.php                # Auth routes
    └── api.php                 # API routes
```

## Next Steps

1. ✅ Customize the admin dashboard theme/colors if needed
2. ✅ Configure Google Analytics (if using)
3. ✅ Set up email configuration for notifications
4. ✅ Create additional admin users
5. ✅ Configure file upload limits and storage
6. ✅ Set up backup strategy for database

## API Integration

The admin dashboard integrates seamlessly with your existing API endpoints. All admin operations are web-based, while your API routes remain unchanged at `/api/*`.

## Security Notes

- The admin dashboard uses Laravel's built-in authentication
- Make sure to use strong passwords for admin accounts
- In production, set `APP_DEBUG=false` in `.env`
- Configure HTTPS for production
- Regularly update dependencies: `composer update` and `npm update`

## Support

If you encounter any issues:
1. Check the Laravel logs: `storage/logs/laravel.log`
2. Check browser console for frontend errors
3. Verify all environment variables are set correctly
4. Ensure all dependencies are installed

---

**🎉 Your admin dashboard is ready to use!**

Access it at: `http://localhost:8000/admin/login`

