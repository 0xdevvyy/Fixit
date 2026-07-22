<div align="center">

# Fixit: SMART

**Fixit: School Maintenance and Reporting Tracker**

Fixit helps Dominican College of Tarlac manage maintenance requests efficiently by allowing teachers and staff to report issues, administrators to assign work and tasks, and maintenance(technician) personnel to track and complete tasks assigned to them.

</div>

---

## Status
> **Currently under development.**

🚧 The core ticket management workflow is implemented, while additional features and improvements are actively being developed.

## ⚙️ Installation

Clone the repository.

```bash
git clone https://github.com/your-username/fixit.git
```

Navigate to the project directory.

```bash
cd fixit
```

Install PHP dependencies.

```bash
composer install
```

Install JavaScript dependencies.

```bash
npm install
```

Copy the environment file.

```bash
cp .env.example .env
```

Generate the application key.

```bash
php artisan key:generate
```

Configure your database credentials in the `.env` file.

Run the database migrations.

```bash
php artisan migrate
```

(Optional) Seed sample data.

```bash
php artisan db:seed
```

Start the development server.

```bash
php artisan serve
```

Run the frontend.

```bash
npm run dev
```

---