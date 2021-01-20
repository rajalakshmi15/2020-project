create or replace
algorithm = UNDEFINED view `all_master` as
select
    `gam`.`m_al_id` as `m_al_id`,
    `gam`.`m_al_desc` as `m_al_desc`,
    `gam`.`m_al_pri` as `m_al_pri`,
    `gam`.`m_al_plant` as `m_al_plant`
from
    `gail_al_master` `gam`
union
select
    `gem`.`m_ev_id` as `m_ev_id`,
    `gem`.`m_ev_desc` as `m_ev_desc`,
    `gem`.`m_ev_pri` as `m_ev_pri`,
    `gem`.`m_ev_plant` as `m_ev_plant`
from
    `gail_ev_master` `gem`
union
select
    `gsm`.`m_st_id` as `m_st_id`,
    `gsm`.`m_st_desc` as `m_st_desc`,
    `gsm`.`m_st_pri` as `m_st_pri`,
    `gsm`.`m_st_plant` as `m_st_plant`
from
    `gail_st_master` `gsm`