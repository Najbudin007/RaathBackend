# RaathBackend - Admin Dashboard

## 🎉 Admin Dashboard Integrated!

Your RaathBackend project now includes a complete admin dashboard interface for managing all aspects of your application.

---

## 🚀 Quick Start

### 1. Setup (One Command)
```bash
./setup-admin.sh
```

### 2. Create Admin User
```bash
php artisan tinker
```
```php
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'is_active' => true
]);
```

### 3. Access Dashboard
🔗 **http://localhost:8000/admin/login**

---

## 📖 Documentation

- 📘 **[Quick Start Guide](ADMIN_QUICK_START.md)** - Get started in 3 steps
- 📗 **[Complete Setup Guide](ADMIN_SETUP_GUIDE.md)** - Detailed instructions
- 📕 **[Integration Summary](INTEGRATION_SUMMARY.md)** - What was integrated

---

## 🎯 Key Features

### Content Management System
- ✅ Blogs & Categories
- ✅ Services & Categories
- ✅ Portfolio & Categories
- ✅ Banners & Sliders
- ✅ Media Library

### Organization Management
- ✅ Temples
- ✅ Branches & Programs
- ✅ Departments
- ✅ Team Members
- ✅ Clients

### Operations
- ✅ Career Postings & Job Roles
- ✅ Volunteer Management
- ✅ Email Subscriptions
- ✅ Success Metrics
- ✅ Tags System

### System & Settings
- ✅ General Settings
- ✅ Email Configuration
- ✅ Social Media Links
- ✅ Google Analytics
- ✅ User Profile Management

---

## 🔐 Admin Access

| Route | Description |
|-------|-------------|
| `/admin/login` | Admin login page |
| `/dashboard` | Admin dashboard (requires auth) |
| `/admin/*` | Admin management pages |

**Default Credentials** (after setup):
- Email: `admin@example.com`
- Password: `password`

⚠️ **Change these immediately after first login!**

---

## 💻 Development

### Start Development Server
```bash
# Backend
php artisan serve

# Frontend (in separate terminal)
npm run dev

# Both together
composer dev
```

### Clear Caches
```bash
php artisan optimize:clear
```

### Rebuild Assets
```bash
npm run build
```

---

## 🏗️ Project Structure

### Backend (Laravel)
```
app/
├── Http/Controllers/Admin/  # Admin controllers
├── Models/                   # Database models
├── Enums/                    # Enumerations
├── Traits/                   # Reusable traits
└── Providers/                # Service providers
```

### Frontend
```
resources/
├── views/admin/             # Admin templates
├── css/app.css              # Tailwind CSS
└── js/app.js                # JavaScript

public/
└── assets/                  # Compiled assets
```

### Routes
```
routes/
├── web.php                  # Web & Admin routes
├── auth.php                 # Authentication
└── api.php                  # API endpoints
```

---

## 🔧 Technology Stack

### Backend
- Laravel 12.0
- Livewire 3.6
- Spatie Laravel Analytics 5.5
- Laravel Sanctum 4.2

### Frontend
- Vite 7.0
- Tailwind CSS 4.0
- Choices.js 11.1
- Axios

---

## 📦 Dependencies

### PHP (composer.json)
```json
{
  "livewire/livewire": "^3.6",
  "spatie/laravel-analytics": "^5.5"
}
```

### JavaScript (package.json)
```json
{
  "choices.js": "^11.1.0",
  "@tailwindcss/vite": "^4.0.0"
}
```

---

## 🔒 Security Notes

- ✅ All admin routes require authentication
- ✅ CSRF protection enabled
- ✅ XSS protection via Laravel
- ✅ Password hashing with bcrypt
- ✅ Role-based access control

**Production Checklist:**
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Use strong admin passwords
- [ ] Enable HTTPS
- [ ] Configure proper file permissions
- [ ] Set up regular backups

---

## 🆘 Troubleshooting

### Login Issues
```bash
# Create/reset admin user
php artisan tinker
# Then create user as shown above
```

### Asset Loading Issues
```bash
npm run build
php artisan config:clear
```

### Database Issues
```bash
# Check .env configuration
# Then run:
php artisan migrate:fresh
```

### Permission Issues
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 📊 API Integration

The admin dashboard works seamlessly with your existing API:

- **API Routes**: `/api/*` (unchanged)
- **Admin Routes**: `/admin/*` (new)
- **Shared Models**: Both use same database models
- **Authentication**: Separate from API Sanctum tokens

---

## 🚀 Deployment

### Production Setup

1. **Environment**
```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

2. **Optimize**
```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan optimize
```

3. **Security**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📈 Next Steps

1. ✅ Complete the setup process
2. ✅ Create your admin user
3. ✅ Login and explore the dashboard
4. ✅ Customize settings
5. ✅ Add your content
6. ✅ Configure Google Analytics (optional)
7. ✅ Deploy to production

---

## 📞 Support

For issues or questions:
1. Check the log files: `storage/logs/laravel.log`
2. Review documentation files in project root
3. Check Laravel documentation: https://laravel.com/docs

---

## 📄 License

This project is open-sourced software licensed under the MIT license.

---

**Built with ❤️ using Laravel & Livewire**

*Last Updated: October 12, 2025*

