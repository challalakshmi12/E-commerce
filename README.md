# E-commerce Website

This is a simple e-commerce website built using **PHP**, **MySQL**, and **HTML/CSS**. It includes features like:

- User registration and login
- Product listing
- Cart system
- Admin panel for managing products

## 👤 Author

**Challa Lakshmi**  
GitHub: [challalakshmi12](https://github.com/challalakshmi12)

---

## 🔧 Technologies Used

- PHP
- MySQL (via phpMyAdmin)
- HTML5 / CSS3
- XAMPP (for local server setup)
- Git & GitHub

## 📁 Project Structure

<pre> ``` ecommerce_website/ ├── admin/ │ ├── add_product.php │ ├── dashboard.php │ ├── login.php │ ├── logout.php │ └── manage_products.php ├── css/ │ └── style.css ├── images/ │ └── product images, cart icon, etc. ├── includes/ │ └── db.php ├── pages/ │ ├── login.php │ ├── logout.php │ ├── register.php │ └── cart.php ├── index.php └── README.md ``` </pre>

## 🚀 How to Run

1. Clone this repository or download the ZIP file.
2. Move it to your `htdocs` folder inside XAMPP.
3. Start **Apache** and **MySQL** in the XAMPP control panel.
4. Import the database using `phpMyAdmin`.
5. Visit `http://localhost/ecommerce_website` in your browser.

## 🗃️ Database Setup

Import this table into your MySQL database:
sql

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100),
  email VARCHAR(100),
  password VARCHAR(255),
  role VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  price DECIMAL(10,2),
  description TEXT,
  image VARCHAR(255)
);
To add an admin manually:

INSERT INTO users (username, email, password, role, created_at)
VALUES ('Super Admin', 'admin@ecommerce.com', '$2y$10$abcdefghijk1234567890LMNOPQRSTUVWXyz12345678', 'admin', NOW());
(Use password_hash() in PHP to generate secure password hashes.)


💡 Features
Public product listing

Secure login/register

Admin dashboard to add/manage products

Image upload for products

Session-based cart
This project is licensed under the MIT License.  
You are free to use, modify, and distribute this code.

