
CREATE TABLE `users` (
  `user_id` int(12) NOT NULL,
  `user_level` int(5) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `active` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);
COMMIT;


INSERT INTO `users` (`user_id`, `user_level`, `username`, `password`, `active`) VALUES
(1594613248, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Y');

