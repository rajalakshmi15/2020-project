CREATE DEFINER=`swarna`@`localhost` FUNCTION `gail_alarm`.`from_dt`() RETURNS datetime(6)
begin

	return @date_from;

END
CREATE DEFINER=`swarna`@`localhost` FUNCTION `gail_alarm`.`get_al_min_dt`() RETURNS datetime(6)
begin

	return @al_min_dt;

END
CREATE DEFINER=`swarna`@`localhost` FUNCTION `gail_alarm`.`get_grp_int`() RETURNS varchar(20) CHARSET latin1
begin

	return @grp_interval;

END
CREATE DEFINER=`swarna`@`localhost` FUNCTION `gail_alarm`.`set_al_min_dt`() RETURNS datetime(6)
begin

	declare x1 datetime(6);

	select min(dt) into @al_min_dt from all_bet_dt;

return @al_min_dt;
END
