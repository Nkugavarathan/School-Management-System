CREATE DATABASE smartschool;
USE smartschool;

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  identification_number VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('principal','office_staff','teacher','student','parent') NOT NULL
);
-- Insert sample users for testing
INSERT INTO users (name, email, identification_number, password, role) VALUES
('Principal User', 'principal@example.com', 'pl001', '$2y$10$w7WbZ9TnClP4KZqG6IfK1uxHy3pvFjv74WWkAEM8ye2cA/egF9EZ6', 'principal'),
('Office Staff User', 'officestaff@example.com', 'os001', '$2y$10$w7WbZ9TnClP4KZqG6IfK1uxHy3pvFjv74WWkAEM8ye2cA/egF9EZ6', 'office_staff'),
('Teacher User', 'teacher@example.com', 'tec001', '$2y$10$w7WbZ9TnClP4KZqG6IfK1uxHy3pvFjv74WWkAEM8ye2cA/egF9EZ6', 'teacher'),
('Student User', 'student@example.com', 'stu001', '$2y$10$w7WbZ9TnClP4KZqG6IfK1uxHy3pvFjv74WWkAEM8ye2cA/egF9EZ6', 'student'),
('Parent User', 'parent@example.com', 'pr001', '$2y$10$w7WbZ9TnClP4KZqG6IfK1uxHy3pvFjv74WWkAEM8ye2cA/egF9EZ6', 'parent');
