CREATE TABLE `gail_alarms` (
  `al_id` varchar(20) DEFAULT NULL,
  `al_date` datetime(6) DEFAULT NULL,
  `al_stat` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1

CREATE TABLE `gail_events` (
  `ev_id` varchar(20) DEFAULT NULL,
  `ev_date` datetime(6) DEFAULT NULL,
  `ev_stat` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1

CREATE TABLE `gail_stat` (
  `st_id` varchar(20) DEFAULT NULL,
  `st_date` datetime(6) DEFAULT NULL,
  `st_stat` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1