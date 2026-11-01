<div align="center">

# Fixit: SMART

**Fixit: School Maintenance and Reporting Tracker**

Fixit helps Dominican College of Tarlac manage maintenance requests efficiently by allowing teachers and staff to report issues, administrators to assign work and tasks, and maintenance(technician) personnel to track and complete tasks assigned to them.

</div>

---

## Status
> **Ready for use.**

If there is an issue, please report it so it can be addressed as soon as possible.

## Features

- Teachers and staff can submit maintenance tickets and track their status.
- Administrators can assign tickets to maintenance personnel.
- Administrators can add, edit, and delete buildings from the Buildings page. Building details show the assigned maintenance personnel, if any.
- Administrators can assign or change a building's maintenance personnel when creating or editing it.
- Teachers and maintenance personnel can view buildings and their assigned maintenance personnel.
- Maintenance personnel can view and filter their assigned tickets and monitor ticket totals by status on their dashboard.
- Maintenance personnel can upload before-work and after-work photos to document repairs. Uploading the before photo marks a ticket as in progress; uploading the after photo marks it complete and notifies the reporter.
- Maintenance personnel can view ticket details and download ticket PDFs.
- Administrators can review ticket reports and download them as PDFs.

## ⚙️ Installation

Clone the repository.

```bash
git clone https://github.com/0xdevvyy/fixit.git
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