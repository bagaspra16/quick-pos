<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Quick POS

Quick POS is a web-based Point of Sale (POS) application developed using the Laravel framework. This application is designed to help restaurant or café management in managing orders, payments, and other operational activities.

## Key Features

### 1. Menu Management
- Manage product catalog (food and beverages)
- Categorize products for easier navigation
- Product availability settings (available/unavailable)
- Upload product images

### 2. Table Management
- Manage tables with capacity and status (available, occupied, reserved)
- Generate unique QR Code for each table
- Customers can scan QR Code to view menu and place orders

### 3. Ordering
- Direct ordering from tables using smartphones (QR Code scan)
- Ordering from cashier/staff
- Real-time order status (pending, processing, completed, cancelled)
- Monitor status of each order item (pending, preparing, ready, served)
- Special notes for each order and order item

### 4. Payments
- Support for various payment methods (cash, debit, credit, QRIS, etc.)
- Print payment receipts
- Record received amount and change
- Payment status tracking

### 5. Dashboard & Analytics
- Daily sales summary
- Top-selling products
- Real-time table status
- Weekly and monthly sales charts
- Performance monitoring by category (food/beverage)
- Payment method analysis
- Average order value
- Table performance

### 6. User Management
- Multi-role (Admin, Cashier, Staff, etc.)
- Role-based permission management
- User profiles and security settings

## Technology

Quick POS is built using the following technologies:

- **Backend**: Laravel 10.x, PHP 8.1+
- **Database**: PostgreSQL
- **Frontend**: Blade Template, TailwindCSS, Alpine.js
- **Authentication**: Laravel's built-in authentication
- **QR Code**: Developed for digital menu access
- **Dashboard**: Chart.js for data visualization

## System Requirements

- PHP 8.1 or newer
- Composer
- PostgreSQL
- Node.js & NPM for frontend assets
- Web server (Apache/Nginx)

## Installation

Follow these steps to install and run the Quick POS application in your local environment:

1. Clone the repository:
```bash
git clone https://github.com/bagaspra16/quick-pos.git
cd quick-pos
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Configure environment:
   - Copy `.env.example` file to `.env`
   - Adjust database and application settings in the `.env` file

5. Generate application key:
```bash
php artisan key:generate
```

6. Run migrations and seeders:
```bash
php artisan migrate --seed
```

7. Link storage:
```bash
php artisan storage:link
```

8. Compile frontend assets:
```bash
npm run build
```

9. Run server:
```bash
php artisan serve
```

10. Access the application in your browser: `http://localhost:8000`

## Basic Usage

### Administrator Login
- Username: admin@example.com
- Password: digitalquickpos123

### Basic Operation Steps
1. Create product categories (Food, Beverages, etc.)
2. Add products to categories
3. Create and set up tables with QR Codes
4. Start receiving orders from tables or cashier
5. Process payments

## Application Workflow

1. **Customer Arrival**:
   - Staff welcomes and directs to a table
   - Customer sits and scans the QR Code on the table

2. **Ordering**:
   - Customer views digital menu
   - Customer orders through smartphone
   - Order enters the system

3. **Kitchen & Bar**:
   - Kitchen/bar staff sees new orders
   - Staff processes and updates status

4. **Serving**:
   - Waiter delivers the order to the table
   - Order item status is updated to "served"

5. **Payment**:
   - Customer requests the bill
   - Cashier processes payment
   - Receipt is printed

## Future Development

- Integration with thermal printers
- Mobile application for staff
- Real-time notifications using WebSockets
- Table reservation system
- Inventory and stock reports
- Customer loyalty program

## Contact & Support

For questions or support, please contact [bagaspratamajunianika72@gmail.com](mailto:bagaspratamajunianika72@gmail.com)
