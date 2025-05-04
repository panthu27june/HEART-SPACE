-- Users table (signup table)
CREATE TABLE IF NOT EXISTS signup (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    mobileno VARCHAR(15) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Voice recordings table
CREATE TABLE IF NOT EXISTS voice_recordings (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    file_path VARCHAR(255) NOT NULL,
    duration INTEGER NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES signup(id) ON DELETE CASCADE
);

-- Text shares table
CREATE TABLE IF NOT EXISTS text_shares (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES signup(id) ON DELETE CASCADE
);

-- Chat messages table
CREATE TABLE IF NOT EXISTS chat_messages (
    id SERIAL PRIMARY KEY,
    user_id INTEGER,
    message TEXT NOT NULL,
    is_ai BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES signup(id) ON DELETE SET NULL
);

-- Google auth users table
CREATE TABLE IF NOT EXISTS google_users (
    id SERIAL PRIMARY KEY,
    google_id VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    picture VARCHAR(255),
    user_id INTEGER NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES signup(id) ON DELETE CASCADE
);

-- Create uploads directory
-- Run mkdir -p uploads/voice
