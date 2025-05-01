CREATE DATABASE pinme;
USE pinme;

-- Users table
CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    last_name VARCHAR(100),
    first_name VARCHAR(100),
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    bio TEXT,
    profile_photo_src VARCHAR(255),
    administrator BOOLEAN,
    date_joined DATETIME
) ENGINE=InnoDB;

-- Images table
CREATE TABLE Images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    src VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    categories VARCHAR(255),
    tags VARCHAR(255),
    author_id INT NOT NULL,
    likes INT NOT NULL,
    visibility ENUM('Visible', 'Private') NOT NULL,
    upload_date DATETIME NOT NULL,
    FOREIGN KEY (author_id) REFERENCES Users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- Comments table
CREATE TABLE Comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_id INT NOT NULL,
    user_id INT NOT NULL,
    comment TEXT NOT NULL,
    pinned BOOLEAN NOT NULL,
    date DATETIME NOT NULL,
    likes INT NOT NULL,
    FOREIGN KEY (image_id) REFERENCES Images(id)
        ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- Annotations table
CREATE TABLE Annotations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_id INT NOT NULL,
    title VARCHAR(255),
    user_id INT NOT NULL,
    description TEXT,
    position_x INT NOT NULL,
    position_y INT NOT NULL,
    FOREIGN KEY (image_id) REFERENCES Images(id)
        ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- Likes table (relation entre Users et Images)
CREATE TABLE Likes (
    user_id INT NOT NULL,
    image_id INT NOT NULL,
    liked_at DATETIME NOT NULL,
    PRIMARY KEY (user_id, image_id),
    FOREIGN KEY (user_id) REFERENCES Users(id)
        ON DELETE CASCADE,
    FOREIGN KEY (image_id) REFERENCES Images(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

