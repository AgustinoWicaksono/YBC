TYPE=VIEW
query=select `sap_php`.`t_grpodlv_header`.`id_grpodlv_header` AS `id_grpodlv_header`,`sap_php`.`t_grpodlv_header`.`posting_date` AS `posting_date`,`sap_php`.`t_grpodlv_header`.`do_no` AS `do_no`,`sap_php`.`t_grpodlv_header`.`grpodlv_no` AS `gr_no`,`sap_php`.`t_grpodlv_header`.`delivery_date` AS `delivery_date`,`sap_php`.`t_grpodlv_header`.`plant` AS `plant`,`sap_php`.`t_grpodlv_header`.`storage_location` AS `storage_location`,`sap_php`.`t_grpodlv_header`.`item_group_code` AS `item_group_code`,`sap_php`.`t_grpodlv_header`.`status` AS `status`,`sap_php`.`t_grpodlv_detail`.`id_grpodlv_h_detail` AS `id_grpodlv_h_detail`,`sap_php`.`t_grpodlv_detail`.`material_no` AS `material_no`,`sap_php`.`t_grpodlv_detail`.`material_desc` AS `material_desc`,`sap_php`.`t_grpodlv_detail`.`outstanding_qty` AS `outstanding_qty`,`sap_php`.`t_grpodlv_detail`.`gr_quantity` AS `gr_quantity`,`sap_php`.`t_grpodlv_detail`.`uom` AS `uom`,`sap_php`.`t_grpodlv_detail`.`item_storage_location` AS `item_storage_location` from (`sap_php`.`t_grpodlv_header` join `sap_php`.`t_grpodlv_detail` on((`sap_php`.`t_grpodlv_header`.`id_grpodlv_header` = `sap_php`.`t_grpodlv_detail`.`id_grpodlv_header`)))
md5=6e659c8f9c6340b5066697b008988849
updatable=1
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2016-08-02 03:32:55
create-version=1
source=select `t_grpodlv_header`.`id_grpodlv_header` AS `id_grpodlv_header`,`t_grpodlv_header`.`posting_date` AS `posting_date`,`t_grpodlv_header`.`do_no` AS `do_no`,`t_grpodlv_header`.`grpodlv_no` AS `gr_no`,`t_grpodlv_header`.`delivery_date` AS `delivery_date`,`t_grpodlv_header`.`plant` AS `plant`,`t_grpodlv_header`.`storage_location` AS `storage_location`,`t_grpodlv_header`.`item_group_code` AS `item_group_code`,`t_grpodlv_header`.`status` AS `status`,`t_grpodlv_detail`.`id_grpodlv_h_detail` AS `id_grpodlv_h_detail`,`t_grpodlv_detail`.`material_no` AS `material_no`,`t_grpodlv_detail`.`material_desc` AS `material_desc`,`t_grpodlv_detail`.`outstanding_qty` AS `outstanding_qty`,`t_grpodlv_detail`.`gr_quantity` AS `gr_quantity`,`t_grpodlv_detail`.`uom` AS `uom`,`t_grpodlv_detail`.`item_storage_location` AS `item_storage_location` from (`t_grpodlv_header` join `t_grpodlv_detail` on((`t_grpodlv_header`.`id_grpodlv_header` = `t_grpodlv_detail`.`id_grpodlv_header`)))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `sap_php`.`t_grpodlv_header`.`id_grpodlv_header` AS `id_grpodlv_header`,`sap_php`.`t_grpodlv_header`.`posting_date` AS `posting_date`,`sap_php`.`t_grpodlv_header`.`do_no` AS `do_no`,`sap_php`.`t_grpodlv_header`.`grpodlv_no` AS `gr_no`,`sap_php`.`t_grpodlv_header`.`delivery_date` AS `delivery_date`,`sap_php`.`t_grpodlv_header`.`plant` AS `plant`,`sap_php`.`t_grpodlv_header`.`storage_location` AS `storage_location`,`sap_php`.`t_grpodlv_header`.`item_group_code` AS `item_group_code`,`sap_php`.`t_grpodlv_header`.`status` AS `status`,`sap_php`.`t_grpodlv_detail`.`id_grpodlv_h_detail` AS `id_grpodlv_h_detail`,`sap_php`.`t_grpodlv_detail`.`material_no` AS `material_no`,`sap_php`.`t_grpodlv_detail`.`material_desc` AS `material_desc`,`sap_php`.`t_grpodlv_detail`.`outstanding_qty` AS `outstanding_qty`,`sap_php`.`t_grpodlv_detail`.`gr_quantity` AS `gr_quantity`,`sap_php`.`t_grpodlv_detail`.`uom` AS `uom`,`sap_php`.`t_grpodlv_detail`.`item_storage_location` AS `item_storage_location` from (`sap_php`.`t_grpodlv_header` join `sap_php`.`t_grpodlv_detail` on((`sap_php`.`t_grpodlv_header`.`id_grpodlv_header` = `sap_php`.`t_grpodlv_detail`.`id_grpodlv_header`)))