TYPE=VIEW
query=select `a`.`posting_date` AS `posting_date`,`a`.`plant` AS `plant`,`a`.`status_eod_transight` AS `status_eod_transight`,`a`.`status_eod_transight_errcode` AS `status_eod_transight_errcode`,`a`.`status_eod_transight_errdesc` AS `status_eod_transight_errdesc`,`a`.`status_eod_transight_time` AS `status_eod_transight_time`,`a`.`status_eod_pos` AS `status_eod_pos`,`a`.`status_eod_opname` AS `status_eod_opname`,`a`.`status_eod_waste` AS `status_eod_waste`,`a`.`status_eod_sap` AS `status_eod_sap`,`a`.`status_hr` AS `status_hr`,`a`.`remarkflag` AS `remarkflag`,`b`.`OUTLET_NAME2` AS `plant_name`,`b`.`COMP_CODE` AS `comp_code` from (`sap_php`.`t_statuseod` `a` join `sap_php`.`m_outlet` `b`) where ((`a`.`plant` = `b`.`OUTLET`) and (`b`.`OUTLET_STATUS` = 1))
md5=d01ed34622ddaf63848f8869f6079a53
updatable=0
algorithm=1
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2016-08-02 03:32:56
create-version=1
source=select `a`.`posting_date` AS `posting_date`,`a`.`plant` AS `plant`,`a`.`status_eod_transight` AS `status_eod_transight`,`a`.`status_eod_transight_errcode` AS `status_eod_transight_errcode`,`a`.`status_eod_transight_errdesc` AS `status_eod_transight_errdesc`,`a`.`status_eod_transight_time` AS `status_eod_transight_time`,`a`.`status_eod_pos` AS `status_eod_pos`,`a`.`status_eod_opname` AS `status_eod_opname`,`a`.`status_eod_waste` AS `status_eod_waste`,`a`.`status_eod_sap` AS `status_eod_sap`,`a`.`status_hr` AS `status_hr`,`a`.`remarkflag` AS `remarkflag`,`b`.`OUTLET_NAME2` AS `plant_name`,`b`.`COMP_CODE` AS `comp_code` from (`t_statuseod` `a` join `m_outlet` `b`) where ((`a`.`plant` = `b`.`OUTLET`) and (`b`.`OUTLET_STATUS` = 1))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `a`.`posting_date` AS `posting_date`,`a`.`plant` AS `plant`,`a`.`status_eod_transight` AS `status_eod_transight`,`a`.`status_eod_transight_errcode` AS `status_eod_transight_errcode`,`a`.`status_eod_transight_errdesc` AS `status_eod_transight_errdesc`,`a`.`status_eod_transight_time` AS `status_eod_transight_time`,`a`.`status_eod_pos` AS `status_eod_pos`,`a`.`status_eod_opname` AS `status_eod_opname`,`a`.`status_eod_waste` AS `status_eod_waste`,`a`.`status_eod_sap` AS `status_eod_sap`,`a`.`status_hr` AS `status_hr`,`a`.`remarkflag` AS `remarkflag`,`b`.`OUTLET_NAME2` AS `plant_name`,`b`.`COMP_CODE` AS `comp_code` from (`sap_php`.`t_statuseod` `a` join `sap_php`.`m_outlet` `b`) where ((`a`.`plant` = `b`.`OUTLET`) and (`b`.`OUTLET_STATUS` = 1))
