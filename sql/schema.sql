CREATE DATABASE IF NOT EXISTS dream_job_db;
USE dream_job_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS developers (
    developer_id INT AUTO_INCREMENT PRIMARY KEY,
    studio_name VARCHAR(255) NOT NULL,
    lead_developer VARCHAR(255) NOT NULL,
    contact_number VARCHAR(100) NOT NULL,
    specialization VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS game_projects (
    project_id INT AUTO_INCREMENT PRIMARY KEY,
    developer_id INT NOT NULL,
    project_title VARCHAR(255) NOT NULL,
    budget DECIMAL(15, 2) NOT NULL,
    FOREIGN KEY (developer_id) REFERENCES developers(developer_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS activity_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    operation VARCHAR(50) NOT NULL,
    developer_id INT NULL,
    done_by VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
