# 🚀 Admin Dashboard - Quick Start

## ⚡ Fast Setup (3 steps)

### 1️⃣ Run Setup Script
```bash
cd /Users/mokshya/Desktop/RaathBackend
./setup-admin.sh
```

### 2️⃣ Create Admin User
```bash
php artisan tinker
```
Then paste:
```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@example.com';
$user->password = bcrypt('password');
$user->role = 'admin';
$user->is_active = true;
$user->save();
exit;
```

### 3️⃣ Start Server & Login
```bash
php artisan serve
```
Visit: **http://localhost:8000/admin/login**
- Email: `admin@example.com`
- Password: `password`

---

## 🎯 Key Routes

| Route | Purpose |
|-------|---------|
| `/admin/login` | Admin login page |
| `/dashboard` | Admin dashboard (after login) |
| `/admin/*` | All admin management pages |

---

## 🛠️ Development Commands

```bash
# Start development server
php artisan serve

# Run frontend dev server (in separate terminal)
npm run dev

# Run both with one command
composer dev

# Clear all caches
php artisan optimize:clear
```

---

## 📁 Important Files

- `routes/web.php` - Admin routes
- `routes/auth.php` - Authentication routes
- `app/Http/Controllers/Admin/` - Admin controllers
- `resources/views/admin/` - Admin views
- `public/assets/` - Admin UI assets

---

## ✅ What's Included

✨ **Full Admin Dashboard** with:
- User Authentication (login/logout)
- Dashboard with Analytics
- Content Management (Blogs, Services, Portfolio)
- Media Manager
- Settings Management
- User Management
- And much more!

---

## 🆘 Quick Troubleshooting

**Problem**: Can't login
**Solution**: Make sure you created an admin user (step 2)

**Problem**: Assets not loading
**Solution**: Run `npm run build` or `npm run dev`

**Problem**: Database errors
**Solution**: Check `.env` file database settings

**Problem**: Permission errors
**Solution**: Run `chmod -R 775 storage bootstrap/cache`

---

## 📚 More Help

See **ADMIN_SETUP_GUIDE.md** for detailed documentation.

---

**🎉 That's it! Your admin dashboard is ready!**

