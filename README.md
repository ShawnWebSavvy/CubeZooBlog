CubeZooBlog

Features
User authentication (Admin, Author roles)
CRUD operations for blog posts
Soft delete functionality
Search and filter by tags
Role-based access control using policies
Comment system for authenticated users
Post status management (draft/published)
Scheduled publishing of posts
File uploads (images for posts)
Activity log for admin
Full-text search
Requirements
PHP >= 8.x
Composer
Laravel 10.x
Node.js & npm
MySQL or any other supported database
Bootstrap (for styling)

Setup Instructions
Follow these steps to set up and run the project locally:

1. Clone the Repository
git clone https://github.com/ShawnWebSavvy/CubeZooBlog.git

2. Install Dependencies
Run the following commands to install the required dependencies:
composer install
npm install
npm run dev

3. Set Up Environment Variables
Create a .env file by copying the provided example:
cp .env.example .env
Open the .env file and configure the database connection and other environment variables:
APP_NAME=CubeZooBlog
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cubezooblog
DB_USERNAME=root
DB_PASSWORD=mysql

4. Generate Application Key
Run the following Artisan command to generate the application key:
php artisan key:generate

5. Run Database Migrations and Seed the Database
Run the migrations to create the necessary tables and seed the database with initial data:
php artisan migrate --seed

6. Set Up File Storage 
php artisan storage:link

7. Start the Development Server
php artisan serve
Your application should now be accessible at http://localhost:8000.

8. Run Unit Tests
To ensure everything is functioning properly, you can run the tests:
php artisan test

Additional Information
Roles:
Admin: Can manage all posts, tags, and comments, and view the activity log.
Author: Can only manage their own posts, including creating, editing, and deleting them.
Guest: Can view published posts but cannot interact with the blog (e.g., commenting).
APIs
An API is available for blog post management, secured by API tokens. Example:

GET: /api/posts (List all posts)
POST: /api/posts (Create a new post)
DELETE: /api/posts/{id} (Delete a post)
For authentication, include an API token in the request header:

