Before running the project, make sure you have the following installed:
XAMPP (Apache and MySQL)
Download XAMPP

Open XAMPP Control Panel and start Apache and MySQL services.

2. Download the Project Files
Clone or download this project to your local machine.

3. Place the Project in XAMPP's htdocs Folder
Move the project folder to C:\xampp\htdocs\ (or wherever your XAMPP is installed).

4. Set Up the Database
Open phpMyAdmin by navigating to http://localhost/phpmyadmin/ in your browser.

4. Set Up the Database
Open phpMyAdmin by navigating to http://localhost/phpmyadmin/ in your browser.

Create a new database named landing_page_db.

Import the provided SQL file (database.sql) into your database to create the required tables.

sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  task_description TEXT NOT NULL,
  status ENUM('pending', 'completed') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

5. Configure Database Connection
Open the config.php file in the root of the project.

Edit the database connection settings:

php
<?php
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "landing_page_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

6. Run the Project
In your browser, go to http://localhost/landing-page (or the folder name where you placed the project in htdocs).

You should see the landing page.

7. User Registration and Login
You can register a new user or log in with existing credentials.

After logging in, you can manage tasks (add, edit, delete, and view the status).

8. Task Management
Tasks are associated with the logged-in user.

You can update the status of tasks (e.g., mark them as completed).
