CREATE TABLE IF NOT EXISTS `accounts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `eid` varchar(64) NOT NULL,
  `username` varchar(24) NOT NULL,
  `email` varchar(128) NOT NULL,
  `access` tinyint(4) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email_confirm` tinyint(1) NOT NULL,
  `email_code` varchar(32) NOT NULL,
  `cookie_code` varchar(32) NOT NULL,
  `cookie_expires` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;