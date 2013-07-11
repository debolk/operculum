--
-- Table structure for table `people`
--

CREATE TABLE IF NOT EXISTS `people` (
  `uid` char(255) NOT NULL,
  `nickname` text,
  `study` text,
  `alive` tinyint(1) NOT NULL DEFAULT '1',
  `inauguration` date DEFAULT NULL,
  `resignation` date DEFAULT NULL,
  `IVA` tinyint(1) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
