# API Documentation

## Base URL
```
http://localhost:8000/api
```

## Authentication

### Register User
```http
POST /auth/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+1234567890",
    "address": "123 Main St, City, State",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "User registered successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "+1234567890",
            "address": "123 Main St, City, State",
            "role": "user",
            "is_active": true
        },
        "token": "1|abc123..."
    }
}
```

### Login User
```http
POST /auth/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "User logged in successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "token": "1|abc123..."
    }
}
```

## Protected Routes

For all protected routes, include the Bearer token in the Authorization header:
```http
Authorization: Bearer 1|abc123...
```

### Get User Profile
```http
GET /auth/profile
Authorization: Bearer 1|abc123...
```

### Update User Profile
```http
PUT /user/profile
Authorization: Bearer 1|abc123...
Content-Type: application/json

{
    "name": "John Updated",
    "phone": "+1987654321",
    "address": "456 New St, City, State"
}
```

## Donations

### Create Donation (Public)
```http
POST /donations
Content-Type: application/json

{
    "project_id": 1,
    "donor_name": "Anonymous Donor",
    "donor_email": "donor@example.com",
    "donor_phone": "+1234567890",
    "amount": 100.00,
    "message": "Thank you for your work!",
    "payment_method": "online",
    "is_anonymous": false
}
```

### Get User Donations
```http
GET /donations/my
Authorization: Bearer 1|abc123...
```

## E-Commerce

### Get Products
```http
GET /products?category_id=1&featured=true&search=puja
```

### Get Product Details
```http
GET /products/1
```

### Add to Cart
```http
POST /cart/add
Authorization: Bearer 1|abc123...
Content-Type: application/json

{
    "product_id": 1,
    "quantity": 2
}
```

### Get Cart
```http
GET /cart
Authorization: Bearer 1|abc123...
```

### Checkout
```http
POST /orders/checkout
Authorization: Bearer 1|abc123...
Content-Type: application/json

{
    "shipping_address": "123 Main St, City, State",
    "billing_address": "123 Main St, City, State",
    "phone": "+1234567890",
    "email": "john@example.com",
    "payment_method": "online",
    "notes": "Please deliver in the morning"
}
```

## Memberships

### Get Membership Plans
```http
GET /memberships/plans
```

### Join Membership
```http
POST /memberships/join
Authorization: Bearer 1|abc123...
Content-Type: application/json

{
    "membership_plan_id": 1,
    "payment_method": "online"
}
```

### Get User Memberships
```http
GET /memberships/my
Authorization: Bearer 1|abc123...
```

## Projects

### Get Projects
```http
GET /projects?featured=true
```

### Get Project Details
```http
GET /projects/1
```

## Content

### Get Categories
```http
GET /categories
```

### Get Team Members
```http
GET /team
```

### Get Page by Slug
```http
GET /pages/about-us
```

## Error Responses

### Validation Error
```json
{
    "success": false,
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password field is required."
        ]
    }
}
```

### Authentication Error
```json
{
    "success": false,
    "message": "Unauthenticated."
}
```

### Authorization Error
```json
{
    "success": false,
    "message": "Unauthorized. Admin access required."
}
```

### Not Found Error
```json
{
    "success": false,
    "message": "Product not found"
}
```

## Testing with cURL

### Register User
```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Login User
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

### Get Products (with token)
```bash
curl -X GET http://localhost:8000/api/products \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## Pagination

For endpoints that return paginated results, the response includes pagination metadata:

```json
{
    "success": true,
    "message": "Products retrieved successfully",
    "data": [...],
    "pagination": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 20,
        "total": 100
    }
}
```

## Rate Limiting

The API implements rate limiting to prevent abuse. Limits are:
- 60 requests per minute for authenticated users
- 30 requests per minute for unauthenticated users

When rate limit is exceeded:
```json
{
    "success": false,
    "message": "Too Many Attempts."
}
```
