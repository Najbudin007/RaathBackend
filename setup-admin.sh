#!/bin/bash

echo "🚀 Setting up Admin Dashboard for RaathBackend..."
echo ""

# Change to the project directory
cd "$(dirname "$0")"

# Step 1: Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install
if [ $? -ne 0 ]; then
    echo "❌ Composer install failed!"
    exit 1
fi
echo "✅ PHP dependencies installed"
echo ""

# Step 2: Install Node dependencies
echo "📦 Installing Node dependencies..."
npm install
if [ $? -ne 0 ]; then
    echo "❌ NPM install failed!"
    exit 1
fi
echo "✅ Node dependencies installed"
echo ""

# Step 3: Check .env file
if [ ! -f .env ]; then
    echo "⚠️  No .env file found. Copying from .env.example..."
    cp .env.example .env
    echo "✅ .env file created"
else
    echo "✅ .env file already exists"
fi
echo ""

# Step 4: Generate application key
echo "🔑 Generating application key..."
php artisan key:generate --force
echo "✅ Application key generated"
echo ""

# Step 5: Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate
if [ $? -ne 0 ]; then
    echo "⚠️  Migration warning - check your database configuration in .env"
else
    echo "✅ Migrations completed"
fi
echo ""

# Step 6: Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
echo "✅ Caches cleared"
echo ""

# Step 7: Build frontend assets
echo "🎨 Building frontend assets..."
npm run build
if [ $? -ne 0 ]; then
    echo "⚠️  Build warning - you may need to run 'npm run dev' separately"
else
    echo "✅ Frontend assets built"
fi
echo ""

# Step 8: Create storage symlink
echo "🔗 Creating storage symlink..."
php artisan storage:link
echo "✅ Storage linked"
echo ""

echo "✨ Setup Complete!"
echo ""
echo "📝 Next Steps:"
echo "   1. Configure your database in .env file"
echo "   2. Create an admin user (see ADMIN_SETUP_GUIDE.md)"
echo "   3. Start the server: php artisan serve"
echo "   4. Visit: http://localhost:8000/admin/login"
echo ""
echo "💡 For development with hot reload, run: npm run dev (in a separate terminal)"
echo ""
echo "📖 Read ADMIN_SETUP_GUIDE.md for detailed instructions"

