# Laravel To Do List CRUD

This is a simple Laravel application for managing contact profiles. It provides basic CRUD functionality (Create, Read, Update, Delete) for contact profiles.

## Prerequisites

Before you begin, ensure you have met the following requirements:

- PHP >= 8.2
- Composer installed
- Laravel installed (you can install it using `composer global require laravel/installer`)

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/robbirodhiyan/energeek_test.git
    ```

2. Navigate to the project's root directory:

    ```bash
    cd energeek_test
    ```

3. Install dependencies:

    ```bash
    composer install
    ```

4. Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

5. Generate an application key:

    ```bash
    php artisan key:generate
    ```

6. Configure your database connection in the `.env` file.

7. Create your database:

    ```bash
    CREATE DATABASE energeek_test;
    ```

8. Run the database migrations:

    ```bash
    php artisan migrate
    ```
9. Seeding Database:

    ```bash
    php artisan db:seed
    ```

10. Import API Documentation in postman:

    ```bash
    energeek-app.postman_collection.json
    ```

11. if you use valet 

    ```bash
    valet link energeek-app-todo
    ```
    
12. app wil run at

    ```bash
    http://energeek-app-todo.test
    ```

