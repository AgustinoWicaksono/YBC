TYPE=VIEW
query=select `a`.`plant` AS `plant`,`a`.`periode` AS `periode`,`b`.`material_no` AS `material_no` from (`sap_php`.`m_opnd_header` `a` join `sap_php`.`m_opnd_detail` `b`) where (`a`.`id_opnd_header` = `b`.`id_opnd_header`)
md5=c1f4b29b3b4f9a7fc73f55920280cfd0
updatable=1
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2016-08-02 03:32:56
create-version=1
source=select `a`.`plant` AS `plant`,`a`.`periode` AS `periode`,`b`.`material_no` AS `material_no` from (`m_opnd_header` `a` join `m_opnd_detail` `b`) where (`a`.`id_opnd_header` = `b`.`id_opnd_header`)
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `a`.`plant` AS `plant`,`a`.`periode` AS `periode`,`b`.`material_no` AS `material_no` from (`sap_php`.`m_opnd_header` `a` join `sap_php`.`m_opnd_detail` `b`) where (`a`.`id_opnd_header` = `b`.`id_opnd_header`)
