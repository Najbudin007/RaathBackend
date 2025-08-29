# RaathBackend - Laravel 11 REST API

A comprehensive Laravel 11 REST API backend for a religious organization platform with e-commerce, donations, and membership management.

## Tech Stack

- **Laravel 11** - PHP Framework
- **MySQL** - Database
- **Laravel Sanctum** - API Authentication
- **Resourceful Controllers** - Clean API structure
- **Form Requests** - Validation
- **Eloquent Models** - Database relationships
- **API Resources** - JSON response formatting

## Features

### 🔐 Authentication & Users
- User registration and login
- Profile management
- Role-based access (User/Admin)
- Sanctum token authentication

### 🏪 E-Puja Shop
- Product catalog with categories
- Shopping cart functionality
- Order management
- Product search and filtering

### 💰 Donations & Projects
- Donation system (anonymous/public)
- Project fundraising
- Donation tracking
- Project progress monitoring

### 👥 Memberships
- Membership plans
- User membership management
- Renewal and cancellation
- Membership benefits

### 📄 Content Management
- Static pages (About, Contact, etc.)
- Team member profiles
- Category management

## Database Structure

### Core Tables
- `users` - User accounts and profiles
- `membership_plans` - Available membership tiers
- `user_memberships` - User membership records
- `donations` - Donation transactions
- `projects` - Fundraising projects

### E-Commerce Tables
- `categories` - Product categories
- `products` - Shop products
- `carts` - User shopping carts
- `cart_items` - Cart line items
- `orders` - Customer orders
- `order_items` - Order line items

### Content Tables
- `team_members` - Team profiles
- `pages` - Static content pages

## API Endpoints

### Authentication
```
POST /api/auth/register     - Register new user
POST /api/auth/login        - User login
POST /api/auth/logout       - User logout (auth required)
GET  /api/auth/profile      - Get user profile (auth required)
```

### User Management
```
PUT /api/user/profile       - Update user profile (auth required)
```

### Memberships
```
GET  /api/memberships/plans                    - List membership plans
GET  /api/memberships/plans/{id}               - Get specific plan
GET  /api/memberships/my                       - User's memberships (auth required)
POST /api/memberships/join                     - Join membership (auth required)
PUT  /api/memberships/{id}/cancel              - Cancel membership (auth required)
PUT  /api/memberships/{id}/renew               - Renew membership (auth required)
```

### Donations
```
POST /api/donations                            - Create donation (public)
GET  /api/donations/my                         - User's donations (auth required)
GET  /api/donations/{id}                       - Get donation details (auth required)
GET  /api/admin/donations                      - All donations (admin only)
```

### E-Commerce
```
GET  /api/categories                           - List categories
GET  /api/categories/{id}                      - Get category with products
GET  /api/products                             - List products
GET  /api/products/{id}                        - Get product details
GET  /api/cart                                 - Get user cart (auth required)
POST /api/cart/add                            - Add to cart (auth required)
PUT  /api/cart/items/{id}                     - Update cart item (auth required)
DELETE /api/cart/items/{id}                   - Remove from cart (auth required)
DELETE /api/cart/clear                        - Clear cart (auth required)
GET  /api/orders                               - User's orders (auth required)
POST /api/orders/checkout                     - Create order (auth required)
GET  /api/orders/{id}                         - Get order details (auth required)
GET  /api/admin/orders                        - All orders (admin only)
```

### Projects
```
GET  /api/projects                            - List active projects
GET  /api/projects/{id}                       - Get project details
```

### Content
```
GET  /api/team                                - List team members
GET  /api/pages/{slug}                        - Get page by slug
```

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd RaathBackend
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   - Update `.env` with your database credentials
   - Run migrations:
   ```bash
   php artisan migrate
   ```

5. **Start the server**
   ```bash
   php artisan serve
   ```

## API Response Format

All API responses follow a consistent JSON structure:

```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {
        // Response data
    },
    "pagination": {
        // Pagination info (when applicable)
    }
}
```

### Error Response Format

```json
{
    "success": false,
    "message": "Error description",
    "errors": {
        // Validation errors (when applicable)
    }
}
```

## Authentication

The API uses Laravel Sanctum for token-based authentication.

### Getting a Token
1. Register or login via `/api/auth/register` or `/api/auth/login`
2. Use the returned token in subsequent requests

### Using the Token
Include the token in the `Authorization` header:
```
Authorization: Bearer {your-token}
```

## Validation

All input validation is handled through Form Request classes:
- `RegisterRequest` - User registration
- `LoginRequest` - User login
- `UpdateProfileRequest` - Profile updates
- `StoreDonationRequest` - Donation creation
- `AddToCartRequest` - Cart operations
- `CheckoutRequest` - Order checkout

## Database Relationships

### User Relationships
- `User` → `Donations` (one-to-many)
- `User` → `Orders` (one-to-many)
- `User` → `UserMemberships` (one-to-many)
- `User` → `Cart` (one-to-one)

### E-Commerce Relationships
- `Category` → `Products` (one-to-many)
- `Product` → `CartItems` (one-to-many)
- `Product` → `OrderItems` (one-to-many)
- `Cart` → `CartItems` (one-to-many)
- `Order` → `OrderItems` (one-to-many)

### Other Relationships
- `MembershipPlan` → `UserMemberships` (one-to-many)
- `Project` → `Donations` (one-to-many)

## Security Features

- **CSRF Protection** - Enabled for web routes
- **Rate Limiting** - Built-in Laravel rate limiting
- **Input Validation** - Comprehensive validation rules
- **Authorization** - Role-based access control
- **SQL Injection Protection** - Eloquent ORM
- **XSS Protection** - Laravel's built-in protection

## Testing

Run the test suite:
```bash
php artisan test
```

## Production Deployment

1. **Environment**
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Optimization**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Database**
   ```bash
   php artisan migrate --force
   ```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support and questions, please contact the development team.
