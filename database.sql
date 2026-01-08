CREATE DATABASE IF NOT EXISTS job_portal;
USE job_portal;
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    dob DATE,
    role ENUM('admin', 'employer', 'seeker') NOT NULL,
    is_verified TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, email, password, dob, role, is_verified) 
VALUES ('admin', 'admin@portal.com', 'admin123', '1990-01-01', 'admin', 1)
ON DUPLICATE KEY UPDATE username=username;

INSERT INTO categories (name) VALUES 
('Web Development'), 
('Graphics Design'), 
('Digital Marketing'), 
('Data Entry')
ON DUPLICATE KEY UPDATE name=name;
