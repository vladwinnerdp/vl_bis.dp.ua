CREATE TABLE IF NOT EXISTS `#__pl_events` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `url` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `difficulty` varchar(50) DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'trade',
  `puzzle_type` varchar(100) DEFAULT NULL,
  `check_answer` tinyint(1) NOT NULL DEFAULT '1',
  `bonuses` varchar(20) DEFAULT NULL,
  `penalty` varchar(10) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `open_bonus` varchar(10) NOT NULL DEFAULT '0',
  `event_group` int(11) NOT NULL DEFAULT '0',
  `params` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


ALTER TABLE `#__pl_events`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `#__pl_events`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;