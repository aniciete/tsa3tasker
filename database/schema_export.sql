-- ====================================================================
-- IT0049 (Web System Technologies) - Technical Summative Assessment 3
-- Project: Tasker (Tasks for Today Management System in Laravel)
-- File: database/schema_export.sql
-- ====================================================================

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `username`, `full_name`, `email`, `created_at`, `updated_at`) VALUES
(1, 'charles', 'Charles Lawrence Aniciete', 'charles@example.com', NOW(), NOW());

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `task_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tasks` (`title`, `status`, `task_date`, `created_at`, `updated_at`) VALUES
('Buy groceries (milk, eggs, and bread)', 'pending', CURDATE(), NOW(), NOW()),
('Morning 30-minute jog in the park', 'completed', CURDATE(), NOW(), NOW()),
('Water the indoor plants', 'completed', CURDATE(), NOW(), NOW()),
('Prepare dinner and wash the dishes', 'pending', CURDATE(), NOW(), NOW()),
('Do laundry and fold clothes', 'completed', DATE_SUB(CURDATE(), INTERVAL 1 DAY), NOW(), NOW()),
('Take out the trash and recycling bins', 'completed', DATE_SUB(CURDATE(), INTERVAL 1 DAY), NOW(), NOW()),
('Clean the kitchen counters and vacuum living room', 'completed', DATE_SUB(CURDATE(), INTERVAL 1 DAY), NOW(), NOW()),
('Pay monthly electric and water bills', 'pending', DATE_ADD(CURDATE(), INTERVAL 1 DAY), NOW(), NOW()),
('Schedule dentist checkup appointment', 'pending', DATE_ADD(CURDATE(), INTERVAL 1 DAY), NOW(), NOW()),
('Wash the car and check tire pressure', 'pending', DATE_ADD(CURDATE(), INTERVAL 2 DAY), NOW(), NOW());
