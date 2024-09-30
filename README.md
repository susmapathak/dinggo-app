# CakePHP 5.1 Application

This is a CakePHP 5.1 application built with PHP 8. It provides functionality to import cars and quotes, using REST APIs to fetch and upsert data.

## Features:
- Cars management
- Quotes management
- Integration with external APIs

## Prerequisites

Before setting up the project locally, make sure you have the following installed:

- **PHP 8.1 or higher**.
- **Composer**: PHP dependency manager.
- **MySQL** or any other supported database.
- **Git**: For cloning the project repository.

Optional:
- **MAMP/XAMPP/WAMP**: For local development environments that bundle PHP, MySQL, and Apache.

## Setup Instructions

Follow these steps to set up the project on your local machine:

### 1. Clone the repository
Clone the project repository from GitHub to your local machine:

```bash
git clone https://github.com/susmapathak/dinggo-app.git
cd dinggo-app
```

### 2. Install dependencies

After cloning the repository, navigate into the project directory and install the required dependencies using Composer:

```bash
composer install
```

### 3. Set up the database

1. Create a new database for the application (e.g., `dinggo_app_db`).
2. Create `.env` inside `config` folder. Update your `.env` file with the database credentials:

```env
DB_HOST=127.0.0.1
DB_PORT=8889
DB_NAME=dinggo_app_db
DB_USER=root
DB_PASSWORD=password
```
3. Run the database migrations to set up the necessary tables.
```bash
bin/cake migrations migrate
```
This will create the necessary tables in the database.

### 4. Run the application

You can now start the CakePHP development server to run the application locally:

```bash
bin/cake server
```
By default, the application will be accessible at `http://localhost:8765`. You can open this URL in your browser to view the app.