# Task Manager API

## Project Purpose

This project is a simple Task Manager API built with Laravel. It allows users to register, log in, and manage tasks. Each task is associated with a user and supports CRUD operations (Create, Read, Update, Delete).

## How to Run Locally

1. **Clone the repository:**

    ```sh
    git clone <your-repo-url>
    cd task_manager
    ```

2. **Install dependencies:**

    ```sh
    composer install
    npm install
    ```

3. **Copy and configure environment:**

    ```sh
    cp .env.example .env
    ```

    - Set your database credentials in `.env`.

4. **Generate application key:**

    ```sh
    php artisan key:generate
    ```

5. **Run migrations:**

    ```sh
    php artisan migrate
    ```

6. **Start the development server:**

    ```sh
    php artisan serve
    ```

7. **(Optional) Start frontend assets:**
    ```sh
    npm run dev
    ```

## ER Diagram

Below is the Entity Relationship (ER) diagram for the Task Manager database structure:

![ER Diagram](/er-diagram.png)

> The diagram shows the relationship between the `User` and `Task` tables.
>
> -   Each Task is linked to a User via the `created_by` and `updated_by` foreign keys.

## API Endpoint List

| Method | Endpoint        | Description               | Auth Required |
| ------ | --------------- | ------------------------- | ------------- |
| POST   | /api/register   | Register a new user       | No            |
| POST   | /api/login      | Login and get token       | No            |
| POST   | /api/logout     | Logout (invalidate token) | Yes           |
| GET    | /api/tasks      | List all tasks            | Yes           |
| POST   | /api/tasks      | Create a new task         | Yes           |
| GET    | /api/tasks/{id} | Get a specific task       | Yes           |
| PUT    | /api/tasks/{id} | Update a task             | Yes           |
| DELETE | /api/tasks/{id} | Delete a task             | Yes           |

## Authentication Guide

-   The API uses [Laravel Sanctum](https://laravel.com/docs/12.x/sanctum) for authentication.
-   Register or log in to receive an authentication token.
-   Include the token in the `Authorization` header for protected endpoints:

    ```
    Authorization: Bearer <your-token>
    ```

-   To log out, call the `/api/logout` endpoint with the token.

---

For more details, see the `routes/api.php` file and the controllers in `app/Http/Controllers`.
