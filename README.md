 # Agriculture Management System

## Overview
The **Agriculture Management System** is a web-based platform designed to connect farmers and buyers, providing a seamless interface for managing agricultural transactions, user registrations, and communication. The system ensures transparency and efficiency in the agricultural supply chain, benefiting all stakeholders.

---

## Features

### Farmer Module
- **Registration/Login**: Farmers can register and log in to their accounts.
- **Manage Products**: Add, update, and remove product listings.
- **View Orders**: Track orders placed by buyers.
- **Profile Management**: Update personal and contact information.

### Buyer Module
- **Registration/Login**: Buyers can create accounts and log in.
- **Search Products**: Search for agricultural products by category or name.
- **Place Orders**: Purchase products from farmers.
- **Profile Management**: Update personal details and delivery address.

### Admin Module
- **User Management**: Manage registered farmers and buyers.
- **Product Management**: Oversee product listings and ensure compliance.
- **Order Monitoring**: Track transactions between farmers and buyers.

---

## Technologies Used

### Frontend
- **HTML5, CSS3, JavaScript**: For the user interface.
- **Bootstrap**: For responsive and mobile-first design.

### Backend
- **PHP**: For server-side processing.
- **MySQL**: For database management.

### Additional Tools
- **XAMPP/WAMP**: For local server setup.
- **phpMyAdmin**: For managing the MySQL database.

---

## Installation

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/AvishkarD2023/Agriculture-Management-System.git
   ```

2. **Setup Local Server**:
   - Install XAMPP/WAMP.
   - Start Apache and MySQL services.

3. **Import Database**:
   - Open `phpMyAdmin`.
   - Create a database named `agroculture`.
   - Import the SQL file provided in the `database` folder.

4. **Configure Database Connection**:
   - Navigate to `db.php`.
   - Update the following variables with your database credentials:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "agroculture";
     ```

5. **Run the Application**:
   - Place the project folder in the `htdocs` directory (for XAMPP).
   - Access the application via `http://localhost/agriculture-management-system`.

---

## Usage

1. **User Registration**:
   - Farmers and buyers can register with unique email IDs.
   - Verify email to activate the account.

2. **Login**:
   - Use registered credentials to log in.
   - Navigate to the appropriate dashboard.

3. **Dashboard**:
   - Farmers can manage their products.
   - Buyers can browse and place orders.

4. **Admin Panel**:
   - Accessible only to administrators.
   - Perform user and product management tasks.

---

## Folder Structure

```
Agriculture-Management-System/
|-- database/                  # Contains SQL scripts for database setup
|-- css/                       # Stylesheets for the application
|-- js/                        # JavaScript files for interactivity
|-- php/                       # PHP scripts for server-side logic
|-- images/                    # Image assets
|-- index.php                  # Homepage of the application
|-- db.php                     # Database connection file
```

---

## Known Issues
- Ensure email verification links work on your localhost setup. You may need to configure an SMTP server.
- For password resets, check your mail server configuration.

---

## Future Enhancements
- **Payment Integration**: Enable secure online payments.
- **Mobile App**: Develop a mobile version for Android/iOS.
- **Real-Time Chat**: Add chat functionality between farmers and buyers.

---

## Contributing

1. Fork the repository.
2. Create a new branch for your feature: `git checkout -b feature-name`.
3. Commit your changes: `git commit -m 'Add new feature'`.
4. Push to the branch: `git push origin feature-name`.
5. Create a pull request.

---

## License
This project is licensed under the MIT License. Feel free to use and modify it as per your needs.

---

