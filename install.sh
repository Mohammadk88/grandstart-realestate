#!/bin/bash
# Grand Start Real Estate - Installation Script

echo "======================================="
echo " Grand Start Real Estate - Installation"
echo "======================================="

# Check PHP
if ! command -v php &> /dev/null; then
    echo "❌ PHP not found. Please install PHP >= 8.1"
    exit 1
fi

# Check Composer
if ! command -v composer &> /dev/null; then
    echo "❌ Composer not found. Please install Composer"
    exit 1
fi

echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader

echo "⚙️  Setting up environment..."
if [ ! -f .env ]; then
    cp .env.example .env
fi

echo "🔑 Generating application key..."
php artisan key:generate

echo "📁 Creating storage directories..."
mkdir -p storage/app/public
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs

echo "🔗 Creating storage link..."
php artisan storage:link

echo ""
echo "⚠️  IMPORTANT: Configure your .env file with database credentials"
echo "   DB_DATABASE=grand_start"
echo "   DB_USERNAME=your_username"
echo "   DB_PASSWORD=your_password"
echo ""
echo "📊 Then run migrations:"
echo "   php artisan migrate"
echo "   php artisan db:seed"
echo ""
echo "🚀 Start the server:"
echo "   php artisan serve"
echo ""
echo "🔑 Admin Panel: /admin"
echo "   Email: admin@grandstartrealestate.com"
echo "   Password: admin@2024"
echo ""
echo "✅ Installation complete!"
