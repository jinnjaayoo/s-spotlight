
# S'Spotlight — Student Achievement & Portfolio Platform

S'Spotlight is a web-based information system designed to showcase student achievements, talents, portfolios, and school activities at **SMKN 2 Purwakarta**.

The platform provides a space for students' creative works and achievements to be documented, shared, and appreciated.

## ✨ Features

- **Portfolio Showcase** — Display student projects and creative works.
- **Gallery** — Showcase documentation of school activities and achievements.
- **General Information** — Publish news, announcements, and upcoming events.
- **Category Filtering** — Organize information and portfolios by category.
- **Search Functionality** — Find portfolios and information more easily.
- **Admin Dashboard** — Manage portfolios, gallery content, and general information.
- **Content Management** — Create, edit, and delete content through the admin panel.
- **Responsive Design** — Designed to provide a comfortable experience across different screen sizes.

## 🛠️ Technologies

- **Framework:** Laravel
- **Programming Language:** PHP
- **Frontend:** HTML, CSS, JavaScript
- **Database:** MySQL
- **Development Environment:** Laragon
- **Code Editor:** Visual Studio Code

## 📂 Main Sections

### Public Website

- Home
- Portfolio
- Portfolio Details
- Gallery
- General Information
- Information Details
- Profile

### Admin Panel

- Admin Login
- Dashboard
- Portfolio Management
- Gallery Management
- Information Management
- Content Search and Filtering

## 🚀 Installation

### 1. Clone or Download the Repository

Download the project or clone this repository to your local machine.

### 2. Install Dependencies

Open the project directory in your terminal and run:

```bash
composer install
```

### 3. Configure the Environment

Create a `.env` file based on `.env.example`:

```bash
cp .env.example .env
```

Configure your database connection in the `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 4. Generate the Application Key

```bash
php artisan key:generate
```

### 5. Configure the Database

Create a MySQL database and import the provided database backup if available.

If migrations are available, run:

```bash
php artisan migrate
```

### 6. Start the Development Server

```bash
php artisan serve
```

Open the local URL displayed in your terminal.

## 🔐 Admin Access

The admin panel is intended for authorized users to manage website content.

> Use the administrator account configured in the project database.

## 📌 Project Purpose

S'Spotlight was developed as a school project to support the documentation and presentation of student achievements, talents, and creative works.

The platform aims to make student accomplishments easier to discover while providing a digital space for school-related information.

## 👩‍💻 Developer

Developed as a final-year student project at:

**SMKN 2 Purwakarta**

---

© S'Spotlight — Student Achievement & Portfolio Platform