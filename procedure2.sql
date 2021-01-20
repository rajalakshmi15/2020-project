


CREATE DEFINER=`swarna`@`localhost` FUNCTION `gail_alarm`.`set_dt_from_to`(dt_from datetime(6), dt_to datetime(6)) RETURNS int(11)
begin

set @date_from=dt_from;

set @date_to=dt_to;

return 0;

end

CREATE DEFINER=`swarna`@`localhost` FUNCTION `gail_alarm`.`set_grp_int`(grp_int varchar(20)) RETURNS varchar(20) CHARSET latin1
begin

set @grp_interval=grp_int;

return @grp_interval ;

END


CREATE DEFINER=`swarna`@`localhost` FUNCTION `gail_alarm`.`set_grp_int`(grp_int varchar(20)) RETURNS varchar(20) CHARSET latin1
begin

set @grp_interval=grp_int;

return @grp_interval ;

END