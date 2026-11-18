-- ==============================================================
-- SHAIKH EMPIRE - DATABASE SCHEMA & INITIAL DATA
-- Database Name: shaikh_empire
-- Designed for MySQL / MariaDB (XAMPP / phpMyAdmin compatible)
-- ==============================================================

CREATE DATABASE IF NOT EXISTS `shaikh_empire` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `shaikh_empire`;

-- --------------------------------------------------------------
-- Table 1: enquiries (Customer Leads & VIP Booking Requests)
-- --------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `enquiries` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `property_name` VARCHAR(100) NOT NULL DEFAULT 'Shaikh Empire',
  `configuration` VARCHAR(50) NOT NULL,
  `visit_date` DATE DEFAULT NULL,
  `chauffeured_pickup` ENUM('Yes', 'No') NOT NULL DEFAULT 'No',
  `special_request` TEXT DEFAULT NULL,
  `status` ENUM('New', 'Contacted', 'Site Visit Scheduled', 'Negotiation', 'Closed', 'Spam') NOT NULL DEFAULT 'New',
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_status` (`status`),
  INDEX `idx_phone` (`phone`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------
-- Table 2: admins (Secure Admin Credentials)
-- --------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `name` VARCHAR(100) NOT NULL DEFAULT 'Super Admin',
  `email` VARCHAR(150) DEFAULT NULL,
  `role` VARCHAR(30) NOT NULL DEFAULT 'administrator',
  `last_login` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------
-- Table 3: site_analytics (Visitor & Traffic Tracking)
-- --------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `site_analytics` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` TEXT DEFAULT NULL,
  `page_url` VARCHAR(255) DEFAULT '/',
  `referrer` VARCHAR(255) DEFAULT NULL,
  `visited_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_visited_at` (`visited_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------
-- Default Admin Account
-- Username: admin
-- Password: Admin@123
-- Hash generated using password_hash('Admin@123', PASSWORD_BCRYPT)
-- --------------------------------------------------------------
INSERT INTO `admins` (`username`, `password_hash`, `name`, `email`, `role`)
VALUES ('admin', '$2y$10$w82/1Zk9cQ2/r1o/Z.W8leN4i34dY7j1X0VjY5w2K3U3D1Z9C8iOm', 'Shaikh Empire Concierge Admin', 'admin@shaikhempire.com', 'super_admin')
ON DUPLICATE KEY UPDATE `username`=`username`;

-- --------------------------------------------------------------
-- Sample Luxury Real Estate Leads for Demonstration
-- --------------------------------------------------------------
INSERT INTO `enquiries` (`full_name`, `phone`, `email`, `property_name`, `configuration`, `visit_date`, `chauffeured_pickup`, `special_request`, `status`, `ip_address`, `created_at`) VALUES
('Dr. Tariq Al-Mansoor', '9820011223', 'tariq.mansoor@royalhealth.ae', 'Shaikh Empire', '5 BHK Presidential Sky Villa', DATE_ADD(CURDATE(), INTERVAL 2 DAY), 'Yes', 'Interested in the top floor penthouse with private infinity pool and private elevator. Require luxury pickup from Mumbai International Airport.', 'New', '127.0.0.1', NOW()),
('Vikramaditya Singhania', '9819988776', 'v.singhania@singhaniagroup.com', 'Shaikh Empire', '4 BHK Emperor Penthouse', DATE_ADD(CURDATE(), INTERVAL 4 DAY), 'Yes', 'Looking for Tower Shehanshah facing the sea/hills view. Need floor plans and vastu compliance details.', 'Site Visit Scheduled', '127.0.0.1', DATE_SUB(NOW(), INTERVAL 1 DAY)),
('Zoya Merchant', '9876543210', 'zoya.merchant@merchanttextiles.in', 'Shaikh Empire', '3 BHK Imperial Suite', DATE_ADD(CURDATE(), INTERVAL 6 DAY), 'No', 'Interested in high-rise floor (30+). Please send festive offers and EMI breakdown.', 'Contacted', '127.0.0.1', DATE_SUB(NOW(), INTERVAL 2 DAY)),
('Arjun Kapoor', '9930055443', 'arjun.kapoor@techcapital.co', 'Shaikh Empire', '2 BHK Royal Suite', DATE_ADD(CURDATE(), INTERVAL 3 DAY), 'No', 'First time luxury home buyer. Would like to understand the payment schedule and club amenities.', 'New', '127.0.0.1', DATE_SUB(NOW(), INTERVAL 3 HOUR)),
('Rehan Shaikh', '9821033445', 'rehan.shaikh@globaltrade.net', 'Shaikh Empire', '5 BHK Presidential Sky Villa', DATE_ADD(CURDATE(), INTERVAL 1 DAY), 'Yes', 'Would like to meet the master architect. Chauffeured pickup required from Bandra Kurla Complex at 11:00 AM.', 'Site Visit Scheduled', '127.0.0.1', DATE_SUB(NOW(), INTERVAL 5 HOUR));
