create or replace
algorithm = UNDEFINED view `fnfp_view` as
select
    concat(substr(`all_view`.`al_id`, 1, 1), '0', substr(`all_view`.`al_id`, 3, 5)) as `id`,
    group_concat(concat(substr(`all_view`.`al_id`, 9), '_', date_format(`all_view`.`al_date`, '%Y-%m-%d %H:%i:%s'), '_', `all_view`.`al_stat`)
order by
    `all_view`.`al_date` asc separator ',') as `dta`
from
    `gail_alarm`.`all_view`
where
    `all_view`.`al_date` between `gail_alarm`.`from_dt`() and `gail_alarm`.`to_dt`()
group by
    concat(substr(`all_view`.`al_id`, 1, 1), '0', substr(`all_view`.`al_id`, 3, 5))