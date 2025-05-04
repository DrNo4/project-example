# PHP Contacts App

A simple PHP contacts management application that allows you to:

- Add new contacts
- Browse existing contacts
- Search contacts
- Edit contacts
- Delete contacts

## Features

- Clean, responsive UI
- Simple database structure
- Form validation
- Search functionality

## Requirements

- PHP 7.0 or higher
- MySQL 5.7 or higher
- Web server (Apache, Nginx, etc.)

## Installation

1. Clone or download this repository to your web server's document root.

2. Create the database and table by importing the `database.sql` file:
   ```
   mysql -u root2 -p < database.sql
   ```
   Or run the SQL commands in the `database.sql` file using phpMyAdmin or another MySQL client.

3. Update the database configuration in `config/db.php` with your MySQL credentials:
   ```php
   $host = 'localhost';      // Your database host
   $dbname = 'contacts_app'; // Your database name
   $username = 'root2';      // Your database username
   $password = 'password';   // Your database password
   ```

4. Make sure your web server is configured to serve the application.

5. Access the application in your web browser.

## Directory Structure

```
contacts-app/
├── config/
│   └── db.php              # Database connection
├── includes/
│   └── functions.php       # Helper functions
├── assets/
│   └── css/
│       └── style.css       # Stylesheet
├── index.php               # Main page (list contacts)
├── add.php                 # Add contact page
├── edit.php                # Edit contact page
├── delete.php              # Delete contact handler
├── database.sql            # Database structure
└── README.md               # This file
```

## Usage

- **View all contacts**: Open the main page (index.php)
- **Add a new contact**: Click the "Add New Contact" button
- **Search contacts**: Use the search bar at the top of the main page
- **Edit a contact**: Click the "Edit" button next to a contact
- **Delete a contact**: Click the "Delete" button next to a contact 