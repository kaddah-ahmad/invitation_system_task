# Invitation Management System

This project is an admin panel-based invitation system built with Laravel, Filament, and Livewire. It supports multi-language (Arabic/English), email sending, a dynamic UI for managing invitations, and role-based grouping of invitees.

## Tech Stack

*   **Laravel 12**
*   **Filament 3**
*   **Livewire 3**
*   PHP 8.1+
*   Composer
*   Node.js & npm (or yarn)
*   Database (MySQL, PostgreSQL, SQLite recommended)
*   Mail Server/Service (e.g., Mailtrap, Mailpit, SMTP)

## Features

*   **Admin Panel:** Secure admin panel built with Filament.
*   **User Groups:** Manage invitations across four distinct groups:
    *   Managers
    *   Peers
    *   Subordinates
    *   Friends and Family
*   **Tabbed Interface:** Invitations are displayed in a tabbed interface, with one tab per group.
*   **Send Invitations:**
    *   Modal-based form to send new invitations.
    *   Input for email address.
    *   Automatic token generation for invitation links.
*   **Multilingual Support:**
    *   UI and email content support English and Arabic.
    *   Language switcher in the admin panel.
    *   RTL (Right-to-Left) layout for Arabic.
*   **Email Notifications:**
    *   Localized invitation emails sent to invitees.
    *   Emails include a unique survey link (placeholder) with a token.
*   **Dynamic UI:** Invitation lists refresh dynamically after sending new invitations (specifically the relevant tab's content).
*   **Invitation Management:**
    *   View invitation status (Sent, Accepted).
    *   Resend invitations.
    *   Delete invitations.
*   **Data Export:** Export invitation lists per group as CSV files.
*   **Database Seeders:** Includes seeders for dummy users and invitations for easy testing.

## Setup Instructions

1.  **Clone the Repository:**
    ```bash
    git clone https://your-repository-url/invitation-system.git
    cd invitation-system
    ```

2.  **Install PHP Dependencies:**
    ```bash
    composer install
    ```

3.  **Install JavaScript Dependencies:**
    ```bash
    npm install
    npm run build
    # or
    # yarn install
    # yarn build
    ```

4.  **Environment Configuration:**
    *   Copy the example environment file:
        ```bash
        cp .env.example .env
        ```
    *   Generate an application key:
        ```bash
        php artisan key:generate
        ```

5.  **Configure `.env` File:**
    Open the `.env` file and update the following settings:
    *   **Application URL:**
        ```
        APP_URL=http://localhost:8000
        ```
    *   **Database Connection:** (Example for MySQL)
        ```
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=invitation_system_db
        DB_USERNAME=root
        DB_PASSWORD=
        ```
        *Ensure the database `invitation_system` (or your chosen name) exists or that your DB user has privileges to create it.*
    *   **Mail Configuration:** (Example for Mailpit or Mailtrap)
        ```
        MAIL_MAILER=smtp
        MAIL_HOST=localhost #  smtp.mailtrap.io for Mailtrap
        MAIL_PORT=1025    #  2525/587/465 for Mailtrap
        MAIL_USERNAME=null #  your Mailtrap username
        MAIL_PASSWORD=null # your Mailtrap password
        MAIL_ENCRYPTION=null # tls/ssl for Mailtrap
        MAIL_FROM_ADDRESS="noreply@example.com"
        MAIL_FROM_NAME="${APP_NAME}"
        ```

6.  **Run Database Migrations:**
    This will create the necessary tables in your database.
    ```bash
    php artisan migrate
    ```

7.  **Seed the Database (Optional but Recommended):**
    This will populate the database with dummy users (including an admin) and invitations for testing.
    ```bash
    php artisan db:seed
    ```
    *   Default Admin User (if seeded):
        *   Email: `admin@kaddah.com`
        *   Password: `12345678`

8.  **Create a Filament Admin User (if not using seeded admin):**
    If you skipped seeding or want a different admin user:
    ```bash
    php artisan make:filament-user
    ```
    Follow the prompts to create your admin user.


9. **Serve the Application:**
    ```bash
    php artisan serve
    ```
    The application will typically be available at `http://localhost:8000`.

## Accessing the Admin Panel

Navigate to `http://your-app-url/admin` (e.g., `http://localhost:8000/admin`) in your web browser and log in with your admin credentials.

## Working Features Checklist

*   [x] Livewire modals for sending invitations.
*   [x] Multilingual emails (English/Arabic) with unique tokens.
*   [x] 4-tab group management (Managers, Peers, Subordinates, Friends & Family).
*   [x] Export functionality (CSV per group).
*   [x] Language switcher for UI (English/Arabic).
*   [x] RTL layout support for Arabic.

## Directory Structure Highlights

*   `app/Enums/`: Contains `InvitationGroupType.php` and `InvitationStatus.php`.
*   `app/Filament/Resources/InvitationResource.php`: Defines the Filament resource for invitations.
*   `app/Filament/Resources/InvitationResource/Pages/ManageInvitations.php`: Custom page for listing invitations with tabs.
*   `app/Http/Middleware/SetLocale.php`: Middleware to set the application language.
*   `app/Livewire/SendInvitationForm.php`: Livewire component for the "Send Invitation" modal.
*   `app/Livewire/LanguageSwitcher.php`: Livewire component for the language switcher.
*   `app/Mail/SendInvitationEmail.php`: Mailable class for sending invitation emails.
*   `app/Models/Invitation.php`, `app/Models/User.php`: Eloquent models.
*   `database/migrations/`: Database migration files.
*   `database/seeders/`: Database seeder files.
*   `lang/en/`, `lang/ar/`: Language translation files.
*   `resources/views/emails/invitations/`: Blade views for invitation emails (Markdown).
*   `resources/views/livewire/`: Blade views for Livewire components.
*   `resources/views/filament/`: Custom Filament view overrides.