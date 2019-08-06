
CREATE TABLE `gmis_mynotetbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  content text not null,
  notecode char(24) not null default '',
  `inserttime` datetime NOT NULL default '1001-01-01 00:00:00',
  `updatetime` datetime NOT NULL default '1001-01-01 00:00:00',
  `istate` char(10) NOT NULL,
  `operator` varchar(10) NOT NULL,
  primary KEY `id` (`id`),
  index k2(userid),
  index k3(inserttime)
);