-- Job Portal Database Schema
CREATE DATABASE IF NOT EXISTS job_portal;
USE job_portal;
-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    user_type ENUM('admin', 'employer', 'jobseeker') NOT NULL,
    status ENUM('pending', 'approved', 'banned') DEFAULT 'pending',
    is_verified TINYINT(1) DEFAULT 0,
    verification_token VARCHAR(100),
    reset_token VARCHAR(100),
    reset_token_expiry DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_user_type (user_type)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- Jobs table
CREATE TABLE IF NOT EXISTS jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employer_id INT NOT NULL,
    category_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    requirements TEXT,
    salary_range VARCHAR(100),
    location VARCHAR(100),
    job_type ENUM(
        'full-time',
        'part-time',
        'contract',
        'internship'
    ) NOT NULL,
    status ENUM('pending', 'approved', 'rejected', 'closed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (employer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT,
    INDEX idx_status (status),
    INDEX idx_employer (employer_id),
    INDEX idx_category (category_id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- Applications table
CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT NOT NULL,
    jobseeker_id INT NOT NULL,
    cover_letter TEXT,
    resume_path VARCHAR(255),
    status ENUM(
        'pending',
        'reviewed',
        'shortlisted',
        'rejected',
        'accepted'
    ) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    FOREIGN KEY (jobseeker_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_job (job_id),
    INDEX idx_jobseeker (jobseeker_id),
    INDEX idx_status (status)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- Activity logs table
CREATE TABLE IF NOT EXISTS activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE
    SET NULL,
        INDEX idx_user (user_id),
        INDEX idx_created (created_at)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- Insert default admin user (password: admin123)
INSERT INTO users (
        username,
        email,
        password,
        full_name,
        user_type,
        status
    )
VALUES (
        'admin',
        'admin@jobportal.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'System Administrator',
        'admin',
        'approved'
    );
-- Insert default categories
INSERT INTO categories (name, description)
VALUES (
        'Information Technology',
        'IT and software development jobs'
    ),
    (
        'Marketing',
        'Marketing and advertising positions'
    ),
    ('Sales', 'Sales and business development roles'),
    (
        'Human Resources',
        'HR and recruitment positions'
    ),
    ('Finance', 'Finance and accounting jobs'),
    ('Healthcare', 'Medical and healthcare positions'),
    ('Education', 'Teaching and education roles'),
    ('Engineering', 'Engineering positions'),
    ('Design', 'Creative and design jobs'),
    ('Customer Service', 'Customer support positions');
