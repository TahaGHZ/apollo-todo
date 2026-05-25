# Apollo Todo App

## Requirements

Make sure you have installed:

- PHP
- Composer
- Node.js and npm
- PostgreSQL

Also make sure PostgreSQL support is enabled in PHP.

In your `php.ini` file, these extensions should be enabled:

```ini
extension=pdo_pgsql
extension=pgsql
```

If they are commented with `;`, remove the `;`, then restart your terminal/server.

You can check enabled PHP modules with:

```bash
php -m
```

You should see:

```text
pdo_pgsql
pgsql
```

---

## How to Run the App

### 1. Clone the project

```bash
git clone https://github.com/TahaGHZ/apollo-todo.git
cd apollo-todo
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install frontend dependencies

```bash
npm install
```

### 4. Create the environment file

```bash
cp .env.example .env
```

On Windows PowerShell:

```powershell
copy .env.example .env
```

### 5. Generate the application key

```bash
php artisan key:generate
```

---

## Database Setup

This project uses PostgreSQL.

### 1. Create the database

Create a PostgreSQL database named:

```text
apollo_todo
```

Using `psql`:

```bash
psql -U postgres
```

Then inside PostgreSQL:

```sql
CREATE DATABASE apollo_todo;
\q
```

You can also create the database using pgAdmin.

### 2. Configure `.env`

Open the `.env` file and update the database section:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=apollo_todo
DB_USERNAME=your_postgres_username
DB_PASSWORD=your_postgres_password
```

Replace `your_postgres_username` and `your_postgres_password` with your local PostgreSQL credentials.

### 3. Run migrations

```bash
php artisan migrate
```

---

## Start the App

Build the frontend assets:

```bash
npm run build
```

Start the Laravel server:

```bash
php artisan serve
```

Open the app in your browser:

```text
http://127.0.0.1:8000
```

---

## Email Verification and Password Reset

This app is configured for local testing.

Emails are written to the Laravel log file instead of being sent through a real email provider.

In your `.env` file, use:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@apollo-todo.local"
MAIL_FROM_NAME="Apollo Todo"
```

When testing email verification or password reset, check this file:

```text
storage/logs/laravel.log
```

The verification or password reset link will appear inside the log file.

```text
Note: The app is not deployed, so real email delivery is not configured.
```

---

## Testing the App

1. Register a new account.
2. Log in.
3. Create a project.
4. Add tasks to the project.
5. Edit, mark as done, or delete tasks.
6. Log out and register another user to confirm each user only sees their own projects and tasks.
