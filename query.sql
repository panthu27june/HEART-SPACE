CREATE DATABASE register;

USE register;

CREATE TABLE signup (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    mobileno VARCHAR(11) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL
);

CREATE DATABASE heart_space;
USE heart_space;

CREATE TABLE voices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    uploader_id VARCHAR(255),
    upload_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE texts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    uploader_id VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
