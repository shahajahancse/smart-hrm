
CREATE TABLE `meeting_rooms` (
  `room_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `meeting_rooms`
  ADD PRIMARY KEY (`room_id`);

ALTER TABLE `meeting_rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `meetings` (
  `meeting_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `meeting_title` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `meetings`
  ADD PRIMARY KEY (`meeting_id`);

ALTER TABLE `meetings`
  MODIFY `meeting_id` int(11) NOT NULL AUTO_INCREMENT;
