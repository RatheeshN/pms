# Mini Project Management System

## Setup Instructions
1. Create a MySQL database and import `database.sql`
2. Update `config/database.php` with your database credentials
3. Place files in your web server directory
4. Ensure `public/uploads/` is writable
5. Access via `public/index.php`

## Test Credentials
- Admin: username: admin, password: password
- Member: username: member1, password: password

## Project Structure
- `config/`: Database configuration
- `controllers/`: MVC controllers for auth, projects, and tasks
- `models/`: Data models
- `views/`: Template files
- `public/`: Web root with assets and entry point
- `routes/`: Routing configuration

## Design Decisions
- Used PDO with prepared statements for security
- Implemented custom routing via query parameters
- Added pagination for tasks (LIMIT 10)
- Included task status change logging
- Used Bootstrap for responsive UI
- Implemented file upload with type/size validation
- Followed strict MVC pattern with clear separation of concerns