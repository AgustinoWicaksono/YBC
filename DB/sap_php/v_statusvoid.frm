TYPE=VIEW
query=select `a`.`posting_date` AS `posting_date`,`a`.`plant` AS `plant`,`b`.`OUTLET_NAME2` AS `plant_name`,`a`.`emplname` AS `emplname`,`a`.`totalvoid` AS `totalvoid`,`a`.`numbervoid` AS `numbervoid` from (`sap_php`.`t_statusvoid` `a` join `sap_php`.`m_outlet` `b`) where (`a`.`plant` = `b`.`OUTLET`)
md5=e9ab8c5191e20ddc7cbb19aa7b25a896
updatable=1
algorithm=0
definer_user=root
definer_host=192.168.143.77
suid=1
with_check_option=0
timestamp=2016-08-02 03:32:56
create-version=1
source=select `a`.`posting_date` AS `posting_date`,`a`.`plant` AS `plant`,`b`.`OUTLET_NAME2` AS `plant_name`,`a`.`emplname` AS `emplname`,`a`.`totalvoid` AS `totalvoid`,`a`.`numbervoid` AS `numbervoid` from (`t_statusvoid` `a` join `m_outlet` `b`) where (`a`.`plant` = `b`.`OUTLET`)
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `a`.`posting_date` AS `posting_date`,`a`.`plant` AS `plant`,`b`.`OUTLET_NAME2` AS `plant_name`,`a`.`emplname` AS `emplname`,`a`.`totalvoid` AS `totalvoid`,`a`.`numbervoid` AS `numbervoid` from (`sap_php`.`t_statusvoid` `a` join `sap_php`.`m_outlet` `b`) where (`a`.`plant` = `b`.`OUTLET`)
