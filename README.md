# Ticket-reservation
hi i'm abdullah

and i'll five you an interviwe abdoy this website
out website is talking about how to book an ticket wheter is football match ticket or any thing else


the database code is below.
notice :-
not all classes are woke some of them are not connected with the main page .

how to enter admin page
in login page
email abdoalhmali092@gmail.com
password abdullah




the map og files :

event_management/
├── classes/models
│   ├── Person.php
│   ├── Client.php
│   ├── Admin.php
│   ├── Event.php
│   ├── Ticket.php
│   ├── Payment.php
│   ├── Notification.php
│   └── Database.php
├── config/
│   └── config.php
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── navbar.php
├── admin/
│   ├── dashboard.php
│   ├── manage-events.php
│   ├── manage-users.php
│   └── reports.php
├── client/
│   ├── dashboard.php
│   ├── book-ticket.php
│   ├── my-tickets.php
│   └── profile.php
├── index.php
├── login.php
└── register.php


code of database:-

-- Database Schema
CREATE DATABASE event_management;
USE event_management;

-- Persons table (abstract, not actually created)
CREATE TABLE clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    isPremium BOOLEAN DEFAULT FALSE,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admins (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE events (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    date DATETIME NOT NULL,
    location VARCHAR(200) NOT NULL,
    capacity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(100),
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE tickets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    clientId INT NOT NULL,
    eventId INT NOT NULL,
    quantity INT NOT NULL,
    paymentId INT,
    status VARCHAR(50) NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (clientId) REFERENCES clients(id),
    FOREIGN KEY (eventId) REFERENCES events(id)
);

CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    clientId INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    paymentMethod VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL,
    transactionId VARCHAR(100) UNIQUE NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    refundedAt TIMESTAMP NULL,
    FOREIGN KEY (clientId) REFERENCES clients(id)
);

CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    userId INT NOT NULL,
    type VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    readAt TIMESTAMP NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
