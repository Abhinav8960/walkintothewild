# Walk Into The Wild - Safari Booking Platform

A comprehensive safari booking and wildlife tourism platform built with modern web technologies.

## 🏗️ Architecture

This project follows a **multi-tier architecture** with separate applications for different concerns:

- **Frontend** - Customer-facing web application
- **Backend** - Administrative panel and content management
- **API** - RESTful API for mobile apps and third-party integrations
- **Console** - Command-line tools and background jobs
- **Common** - Shared components and models

## 🛠️ Technology Stack

### Backend Framework
- **PHP 7.4+** - Server-side programming language
- **Yii2 Framework 2.0.51** - Advanced PHP framework
- **Yii2 Advanced Project Template** - Multi-tier application structure

### Database
- **MySQL 5.7** - Primary database
- **Database Sessions** - Session management

### Frontend Technologies
- **Bootstrap 5** - CSS framework for responsive design
- **jQuery** - JavaScript library
- **Mobile Detection** - Responsive mobile optimization
- **reCAPTCHA v3** - Security and bot protection

### API & Integrations
- **RESTful API** - JSON-based API endpoints
- **JWT Authentication** - Secure API authentication
- **WhatsApp Cloud API** - Messaging integration
- **Firebase** - Push notifications
- **AWS SDK** - Cloud services integration
- **Google API Client** - Google services integration

### Payment & Financial
- **PayU Payment Gateway** - Payment processing
- **Transaction Management** - Financial transaction handling
- **Refund & Cancellation** - Payment lifecycle management

### Media & File Management
- **AWS S3** - Cloud file storage
- **Flysystem** - File system abstraction
- **Image Processing** - Yii2 Imagine extension
- **Video Processing** - PHP-FFMpeg
- **PDF Generation** - mPDF library

### Development & Testing
- **Codeception** - Testing framework
- **PHPUnit** - Unit testing
- **Docker** - Containerization
- **Vagrant** - Development environment

### Queue & Background Jobs
- **Yii2 Queue** - Background job processing
- **Pusher** - Real-time notifications
- **SQS Integration** - Message queuing

### Security & Monitoring
- **Audit Logging** - User activity tracking
- **Error Handling** - Custom error management
- **Request Sanitization** - Input validation
- **Security Headers** - Enhanced security

## 📁 Project Structure

```
walkintothewild/
├── frontend/          # Customer-facing web application
├── backend/           # Administrative panel
├── api/              # RESTful API endpoints
├── console/          # Command-line tools
├── common/           # Shared components
├── support/          # Customer support system
├── business/         # Business management
├── cms/             # Content management
├── webhook/         # Webhook handlers
├── tinyurl/         # URL shortening service
├── accounts/        # User account management
└── environments/    # Environment configurations
```

## 🚀 Key Features

### Safari Management
- **Package Management** - Safari package creation and management
- **Operator Management** - Safari operator profiles and verification
- **Booking System** - Complete booking and reservation system
- **Payment Processing** - Secure payment gateway integration
- **Real-time Chat** - Customer support and communication

### User Experience
- **Mobile Responsive** - Optimized for all devices
- **Multi-language Support** - Internationalization ready
- **Social Login** - Google and social media authentication
- **User Profiles** - Comprehensive user management
- **Wishlist & Favorites** - User preference management

### Content Management
- **CMS Integration** - Content management system
- **Media Gallery** - Image and video management
- **Blog & Articles** - Content publishing
- **SEO Optimization** - Search engine optimization
- **Meta Management** - Dynamic meta tags

### Analytics & Reporting
- **User Analytics** - User behavior tracking
- **Booking Reports** - Financial and booking analytics
- **Performance Monitoring** - System performance tracking
- **Audit Logs** - Complete activity logging

## 🐳 Docker Setup

The project includes Docker configuration for easy development:

```bash
# Start all services
docker-compose up -d

# Services will be available at:
# Frontend: http://localhost:20080
# Backend: http://localhost:21080
# MySQL: localhost:3306
```

## 📱 Mobile & API

- **RESTful API** - Complete API for mobile applications
- **Push Notifications** - Firebase integration
- **WhatsApp Integration** - Customer communication
- **Real-time Updates** - Live booking and chat updates

## 🔧 Development

### Prerequisites

Before starting the installation, ensure you have the following software installed:

#### Required Software
- **PHP 7.4 or higher** with extensions:
  - `php-mysql` - MySQL database support
  - `php-curl` - HTTP requests
  - `php-gd` - Image processing
  - `php-mbstring` - String handling
  - `php-xml` - XML processing
  - `php-zip` - Archive handling
  - `php-intl` - Internationalization
  - `php-bcmath` - Arbitrary precision mathematics
  - `php-soap` - SOAP client
  - `php-json` - JSON support

- **MySQL 5.7+** or **MariaDB 10.2+**
- **Composer** (PHP dependency manager)
- **Git** (version control)
- **Node.js & NPM** (for frontend assets)

#### Optional Software
- **Docker & Docker Compose** (for containerized development)
- **Vagrant** (for virtualized development environment)
- **Redis** (for caching and sessions)

### Installation Guide

#### Method 1: Traditional Installation (Recommended for Development)

##### Step 1: Clone the Repository
```bash
# Clone the repository
git clone https://github.com/your-username/walkintothewild.git
cd walkintothewild

# Checkout the desired branch (if not main)
git checkout main
```

##### Step 2: Install PHP Dependencies
```bash
# Install Composer dependencies
composer install --no-dev --optimize-autoloader

# For development (includes dev dependencies)
composer install
```

**Expected Output:**
```
Loading composer repositories with package information
Installing dependencies (including require-dev) from lock file
Package operations: 123 installs, 0 updates, 0 removals
  - Installing yiisoft/yii2 (2.0.51): Loading from cache
  - Installing symfony/mailer (6.0.0): Loading from cache
  ...
Writing lock file
Generating optimized autoloader
```

##### Step 3: Database Setup
```bash
# Create MySQL database
mysql -u root -p
```

```sql
-- In MySQL console
CREATE DATABASE walkintothewild CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'witw_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON walkintothewild.* TO 'witw_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

##### Step 4: Environment Configuration
```bash
# Copy environment configuration files
cp environments/dev/common/config/main-local.php.dist common/config/main-local.php
cp environments/dev/common/config/params-local.php.dist common/config/params-local.php
cp environments/dev/frontend/config/main-local.php.dist frontend/config/main-local.php
cp environments/dev/backend/config/main-local.php.dist backend/config/main-local.php
cp environments/dev/api/config/main-local.php.dist api/config/main-local.php
```

**Configure Database Connection:**
Edit `common/config/main-local.php`:
```php
<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=walkintothewild',
            'username' => 'witw_user',
            'password' => 'your_secure_password',
            'charset' => 'utf8mb4',
            'tablePrefix' => '',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
    ],
];
```

**Configure Application Parameters:**
Edit `common/config/params-local.php`:
```php
<?php
return [
    'adminEmail' => 'admin@walkintothewild.com',
    'supportEmail' => 'support@walkintothewild.com',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    
    // AWS Configuration
    'aws.accessKey' => 'your_aws_access_key',
    'aws.secretKey' => 'your_aws_secret_key',
    'aws.region' => 'us-east-1',
    'aws.bucket' => 'walkintothewild-assets',
    
    // Payment Gateway Configuration
    'payu.merchantKey' => 'your_payu_merchant_key',
    'payu.merchantSalt' => 'your_payu_merchant_salt',
    'payu.authHeader' => 'your_payu_auth_header',
    'payu.merchantId' => 'your_payu_merchant_id',
    
    // WhatsApp Configuration
    'whatsapp.accessToken' => 'your_whatsapp_access_token',
    'whatsapp.phoneNumberId' => 'your_whatsapp_phone_number_id',
    
    // Firebase Configuration
    'firebase.projectId' => 'your_firebase_project_id',
    'firebase.privateKey' => 'your_firebase_private_key',
    'firebase.clientEmail' => 'your_firebase_client_email',
];
```

##### Step 5: Initialize Application
```bash
# Initialize the application
php init

# Select environment (0 for Development)
# 0) Development
# 1) Production
# 2) Testing
# Your choice [0-2]: 0
```

**Expected Output:**
```
Initialize application environment

Environment to initialize [Development]:
  [0] Development
  [1] Production
  [2] Testing

Your choice [0-2]: 0

Initializing the application under 'Development' environment...
```

##### Step 6: Run Database Migrations
```bash
# Run database migrations
php yii migrate --interactive=0

# Or for interactive mode
php yii migrate
```

**Expected Output:**
```
Yii Migration Tool (based on Yii v2.0.51)

Total 45 new migrations to be applied:
    m000000_000000_create_user_table
    m000000_000001_create_park_table
    m000000_000002_create_package_table
    ...

Apply the above migrations? (yes|no) [no]:yes

*** applying m000000_000000_create_user_table
    > create table user ... done (time: 0.123s)
*** applying m000000_000001_create_park_table
    > create table park ... done (time: 0.456s)
...
*** applied 45 migrations (time: 12.345s)
```

##### Step 7: Set File Permissions
```bash
# Set proper permissions for runtime directories
chmod -R 755 frontend/runtime
chmod -R 755 backend/runtime
chmod -R 755 api/runtime
chmod -R 755 console/runtime
chmod -R 755 common/runtime

# Set permissions for web assets
chmod -R 755 frontend/web/assets
chmod -R 755 backend/web/assets
```

##### Step 8: Install Frontend Dependencies (if any)
```bash
# If you have package.json for frontend assets
npm install

# Build frontend assets
npm run build
```

##### Step 9: Configure Web Server

**For Apache (.htaccess):**
```apache
# frontend/web/.htaccess
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.php

# backend/web/.htaccess
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.php
```

**For Nginx:**
```nginx
server {
    listen 80;
    server_name walkintothewild.local;
    root /path/to/walkintothewild/frontend/web;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

##### Step 10: Start Development Server
```bash
# Start PHP built-in server for development
php -S localhost:8080 -t frontend/web

# In another terminal for backend
php -S localhost:8081 -t backend/web

# In another terminal for API
php -S localhost:8082 -t api/web
```

**Access URLs:**
- Frontend: http://localhost:8080
- Backend: http://localhost:8081
- API: http://localhost:8082

#### Method 2: Docker Installation (Recommended for Production-like Environment)

##### Step 1: Clone and Setup
```bash
# Clone the repository
git clone https://github.com/your-username/walkintothewild.git
cd walkintothewild

# Copy environment files
cp environments/dev/common/config/main-local.php.dist common/config/main-local.php
cp environments/dev/common/config/params-local.php.dist common/config/params-local.php
```

##### Step 2: Configure Docker Environment
Edit `docker-compose.yml` if needed:
```yaml
version: '3.2'

services:
  frontend:
    build: frontend
    ports:
      - "20080:80"
    volumes:
      - ~/.composer-docker/cache:/root/.composer/cache:delegated
      - ./:/app
    depends_on:
      - mysql

  backend:
    build: backend
    ports:
      - "21080:80"
    volumes:
      - ~/.composer-docker/cache:/root/.composer/cache:delegated
      - ./:/app
    depends_on:
      - mysql

  mysql:
    image: mysql:5.7
    environment:
      - MYSQL_ROOT_PASSWORD=verysecret
      - MYSQL_DATABASE=walkintothewild
      - MYSQL_USER=walkintothewild
      - MYSQL_PASSWORD=secret
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql

volumes:
  mysql_data:
```

##### Step 3: Build and Start Containers
```bash
# Build Docker images
docker-compose build

# Start all services
docker-compose up -d

# Check container status
docker-compose ps
```

**Expected Output:**
```
Name                     Command               State           Ports
walkintothewild_frontend_1   docker-php-entrypoint apache2-foreground   Up      0.0.0.0:20080->80/tcp
walkintothewild_backend_1    docker-php-entrypoint apache2-foreground   Up      0.0.0.0:21080->80/tcp
walkintothewild_mysql_1      docker-entrypoint.sh mysqld                Up      0.0.0.0:3306->3306/tcp
```

##### Step 4: Initialize Application in Docker
```bash
# Run migrations in Docker
docker-compose exec frontend php yii migrate --interactive=0

# Initialize application
docker-compose exec frontend php init
```

**Access URLs:**
- Frontend: http://localhost:20080
- Backend: http://localhost:21080
- MySQL: localhost:3306

### Post-Installation Setup

#### Step 1: Create Admin User
```bash
# Create admin user via console
php yii user/create-admin --username=admin --email=admin@walkintothewild.com --password=admin123
```

#### Step 2: Seed Initial Data
```bash
# Seed parks data
php yii seed/parks

# Seed packages data
php yii seed/packages

# Seed operators data
php yii seed/operators
```

#### Step 3: Configure Cron Jobs
```bash
# Add to crontab
crontab -e

# Add these lines:
# Run queue worker every minute
* * * * * cd /path/to/walkintothewild && php yii queue/run >/dev/null 2>&1

# Clean up old logs daily
0 2 * * * cd /path/to/walkintothewild && php yii log/cleanup >/dev/null 2>&1
```

#### Step 4: Verify Installation
```bash
# Check application status
php yii health/check

# Test database connection
php yii db/test

# Check queue status
php yii queue/info
```

### Testing

#### Run All Tests
```bash
# Run complete test suite
./vendor/bin/codecept run

# Run with coverage report
./vendor/bin/codecept run --coverage --coverage-html coverage/
```

#### Run Specific Test Suites
```bash
# Unit tests only
./vendor/bin/codecept run unit

# Functional tests only
./vendor/bin/codecept run functional

# API tests only
./vendor/bin/codecept run api

# Run specific test
./vendor/bin/codecept run unit tests/unit/models/UserTest.php
```

#### Run Tests in Docker
```bash
# Run tests in Docker environment
docker-compose exec frontend ./vendor/bin/codecept run
```

### Troubleshooting

#### Common Issues and Solutions

**1. Composer Memory Limit Error:**
```bash
# Increase PHP memory limit
php -d memory_limit=2G /usr/local/bin/composer install
```

**2. Database Connection Error:**
```bash
# Check MySQL service
sudo systemctl status mysql

# Test connection
mysql -u walkintothewild -p -h localhost walkintothewild
```

**3. Permission Denied Errors:**
```bash
# Fix ownership
sudo chown -R www-data:www-data /path/to/walkintothewild
sudo chmod -R 755 /path/to/walkintothewild
```

**4. Missing PHP Extensions:**
```bash
# Install required extensions (Ubuntu/Debian)
sudo apt-get install php-mysql php-curl php-gd php-mbstring php-xml php-zip php-intl php-bcmath php-soap

# Restart web server
sudo systemctl restart apache2
# or
sudo systemctl restart nginx
```

**5. Docker Container Issues:**
```bash
# Rebuild containers
docker-compose down
docker-compose build --no-cache
docker-compose up -d

# Check logs
docker-compose logs frontend
docker-compose logs backend
docker-compose logs mysql
```

### Development Workflow

#### Daily Development Setup
```bash
# Start development servers
php -S localhost:8080 -t frontend/web &
php -S localhost:8081 -t backend/web &
php -S localhost:8082 -t api/web &

# Run queue worker
php yii queue/listen &

# Watch for file changes (if using file watcher)
npm run watch
```

#### Code Quality Checks
```bash
# Run PHP CodeSniffer
./vendor/bin/phpcs --standard=PSR12 frontend/ backend/ api/ common/

# Fix coding standards
./vendor/bin/phpcbf --standard=PSR12 frontend/ backend/ api/ common/

# Run static analysis
./vendor/bin/phpstan analyse frontend/ backend/ api/ common/
```

## 🌐 Environment Configuration

The project supports multiple environments:
- **Development** - Local development setup
- **Production** - Live production environment
- **Testing** - Automated testing environment

## 📊 Monitoring & Logging

- **Error Tracking** - Comprehensive error logging
- **Performance Monitoring** - System performance metrics
- **User Activity Logs** - Complete audit trail
- **Payment Logs** - Financial transaction tracking

## 🔒 Security Features

- **reCAPTCHA v3** - Bot protection
- **CSRF Protection** - Cross-site request forgery prevention
- **Input Validation** - Comprehensive input sanitization
- **Secure Authentication** - Multi-factor authentication support
- **API Security** - Token-based authentication

## 📈 Scalability

- **Microservices Architecture** - Modular service design
- **Queue System** - Background job processing
- **Cloud Integration** - AWS services for scalability
- **Caching** - Performance optimization
- **Load Balancing** - High availability support

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Submit a pull request

## 📄 License

This project is licensed under the BSD-3-Clause License.

## 🆘 Support

For support and questions:
- Create an issue in the repository
- Contact the development team
- Check the documentation

---

**Walk Into The Wild** - Connecting wildlife enthusiasts with amazing safari experiences while promoting conservation and responsible tourism.