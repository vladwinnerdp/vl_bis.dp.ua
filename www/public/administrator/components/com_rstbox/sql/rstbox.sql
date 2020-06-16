CREATE TABLE IF NOT EXISTS `#__rstbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `testmode` tinyint(1) NOT NULL DEFAULT '0',
  `boxtype` varchar(30) CHARACTER SET utf8 NOT NULL,
  `customhtml` text CHARACTER SET utf8,
  `position` varchar(30) CHARACTER SET utf8 NOT NULL,
  `triggermethod` varchar(50) CHARACTER SET utf8 NOT NULL,
  `cookie` mediumint(9) NOT NULL,
  `params` text CHARACTER SET utf8 NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `#__rstbox_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` varchar(64) CHARACTER SET utf8 NOT NULL,
  `visitorid` varchar(64) CHARACTER SET utf8 NOT NULL,
  `user` int(11) NOT NULL,
  `box` int(11) NOT NULL,
  `event` tinyint(6) NOT NULL DEFAULT '1',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `visitorid` (`visitorid`),
  KEY `box` (`box`),
  KEY `sessionid` (`sessionid`),
  KEY `date` (`date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;