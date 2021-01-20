create or replace
algorithm = UNDEFINED view `all_view` as
select
    `a1`.`al_id` as `al_id`,
    `a1`.`al_date` as `al_date`,
    `a1`.`al_stat` as `al_stat`,
    `a2`.`m_al_id` as `m_al_id`,
    `a2`.`m_al_desc` as `m_al_desc`,
    `a2`.`m_al_pri` as `m_al_pri`,
    `a2`.`m_al_plant` as `m_al_plant`
from
    ((
    select
        `gail_alarm`.`gail_alarms`.`al_id` as `al_id`,
        `gail_alarm`.`gail_alarms`.`al_date` as `al_date`,
        `gail_alarm`.`gail_alarms`.`al_stat` as `al_stat`
    from
        `gail_alarm`.`gail_alarms`
union all
    select
        `gail_alarm`.`gail_events`.`ev_id` as `ev_id`,
        `gail_alarm`.`gail_events`.`ev_date` as `ev_date`,
        `gail_alarm`.`gail_events`.`ev_stat` as `ev_stat`
    from
        `gail_alarm`.`gail_events`
union all
    select
        `gail_alarm`.`gail_stat`.`st_id` as `st_id`,
        `gail_alarm`.`gail_stat`.`st_date` as `st_date`,
        `gail_alarm`.`gail_stat`.`st_stat` as `st_stat`
    from
        `gail_alarm`.`gail_stat`) `a1`
left join `gail_alarm`.`all_master` `a2` on
    (`a1`.`al_id` = `a2`.`m_al_id`))