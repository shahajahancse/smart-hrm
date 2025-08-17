CREATE TABLE `meeting_attendees` (
  `attendee_id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `meeting_attendees`
  ADD PRIMARY KEY (`attendee_id`);

ALTER TABLE `meeting_attendees`
  MODIFY `attendee_id` int(11) NOT NULL AUTO_INCREMENT;
