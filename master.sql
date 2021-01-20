CREATE TABLE `gail_al_master` (
  `m_al_id` varchar(20) DEFAULT NULL,
  `m_al_desc` varchar(200) DEFAULT NULL,
  UNIQUE KEY `gail_al_master_un` (`m_al_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1

CREATE TABLE `gail_ev_master` (
  `m_ev_id` varchar(20) DEFAULT NULL,
  `m_ev_desc` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1

CREATE TABLE `gail_st_master` (
  `m_st_id` varchar(20) DEFAULT NULL,
  `m_st_desc` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1