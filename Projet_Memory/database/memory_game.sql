CREATE DATABASE IF NOT EXISTS memory_game;
USE memory_game;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `scores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `time_elapsed` int(11) NOT NULL,
  `difficulty` varchar(10) NOT NULL,
  `badge` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`username`, `email`, `password`) VALUES
('admin', 'admin@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC'),
('user', 'user@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC'),
('user1', 'user1@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC'),
('user2', 'user2@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC'),
('user3', 'user3@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC'),
('user4', 'user4@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC'),
('user5', 'user5@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC'),
('user6', 'user6@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC'),
('user7', 'user7@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC'),
('user8', 'user8@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC'),
('user9', 'user9@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC'),
('user10', 'user10@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC'),
('user11', 'user11@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC'),
('user12', 'user12@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC'),
('user13', 'user13@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC'),
('user14', 'user14@example.com', '$2y$10$aFhUngYU2m.o7aqwUw.XXeBf3Dd3enwCCTxGRArBMcFInQOTZe6lC');


INSERT INTO `scores` (`user_id`, `score`, `time_elapsed`, `difficulty`, `badge`) VALUES
(1, 500, 200, 'easy', 'gold'),
(1, 450, 250, 'medium', 'silver'),
(2, 600, 180, 'hard', 'gold'),
(2, 550, 220, 'easy', 'silver'),
(3, 700, 150, 'medium', 'gold'),
(4, 800, 140, 'hard', 'gold'),
(5, 650, 210, 'easy', 'silver'),
(6, 750, 190, 'medium', 'gold'),
(7, 500, 230, 'hard', 'silver'),
(8, 550, 220, 'easy', 'silver'),
(9, 600, 210, 'medium', 'gold'),
(10, 700, 200, 'hard', 'gold'),
(11, 800, 190, 'easy', 'gold'),
(12, 650, 180, 'medium', 'silver'),
(13, 750, 170, 'hard', 'gold'),
(14, 500, 160, 'easy', 'silver'),
(15, 550, 150, 'medium', 'gold');
