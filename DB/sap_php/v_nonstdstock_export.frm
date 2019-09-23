TYPE=VIEW
query=select `sap_php`.`t_nonstdstock_header`.`id_nonstdstock_header` AS `id_nonstdstock_header`,`sap_php`.`t_nonstdstock_header`.`pr_no` AS `pr_no`,`sap_php`.`t_nonstdstock_header`.`plant` AS `plant`,`sap_php`.`t_nonstdstock_header`.`storage_location` AS `storage_location`,`sap_php`.`t_nonstdstock_header`.`request_reason` AS `request_reason`,`sap_php`.`t_nonstdstock_header`.`item_group_code` AS `item_group_code`,`sap_php`.`t_nonstdstock_header`.`created_date` AS `created_date`,`sap_php`.`t_nonstdstock_header`.`status` AS `status`,`sap_php`.`t_nonstdstock_detail`.`id_nonstdstock_h_detail` AS `id_nonstdstock_h_detail`,`sap_php`.`t_nonstdstock_detail`.`material_no` AS `material_no`,`sap_php`.`t_nonstdstock_detail`.`material_desc` AS `material_desc`,`sap_php`.`t_nonstdstock_detail`.`delivery_date` AS `delivery_date`,`sap_php`.`t_nonstdstock_detail`.`lead_time` AS `lead_time`,`sap_php`.`t_nonstdstock_detail`.`requirement_qty` AS `requirement_qty`,`sap_php`.`t_nonstdstock_detail`.`uom` AS `uom` from (`sap_php`.`t_nonstdstock_header` join `sap_php`.`t_nonstdstock_detail` on((`sap_php`.`t_nonstdstock_header`.`id_nonstdstock_header` = `sap_php`.`t_nonstdstock_detail`.`id_nonstdstock_header`)))
md5=1e70b4f0b0e075535623701e40732597
updatable=1
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2016-08-02 03:32:56
create-version=1
source=select `t_nonstdstock_header`.`id_nonstdstock_header` AS `id_nonstdstock_header`,`t_nonstdstock_header`.`pr_no` AS `pr_no`,`t_nonstdstock_header`.`plant` AS `plant`,`t_nonstdstock_header`.`storage_location` AS `storage_location`,`t_nonstdstock_header`.`request_reason` AS `request_reason`,`t_nonstdstock_header`.`item_group_code` AS `item_group_code`,`t_nonstdstock_header`.`created_date` AS `created_date`,`t_nonstdstock_header`.`status` AS `status`,`t_nonstdstock_detail`.`id_nonstdstock_h_detail` AS `id_nonstdstock_h_detail`,`t_nonstdstock_detail`.`material_no` AS `material_no`,`t_nonstdstock_detail`.`material_desc` AS `material_desc`,`t_nonstdstock_detail`.`delivery_date` AS `delivery_date`,`t_nonstdstock_detail`.`lead_time` AS `lead_time`,`t_nonstdstock_detail`.`requirement_qty` AS `requirement_qty`,`t_nonstdstock_detail`.`uom` AS `uom` from (`t_nonstdstock_header` join `t_nonstdstock_detail` on((`t_nonstdstock_header`.`id_nonstdstock_header` = `t_nonstdstock_detail`.`id_nonstdstock_header`)))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `sap_php`.`t_nonstdstock_header`.`id_nonstdstock_header` AS `id_nonstdstock_header`,`sap_php`.`t_nonstdstock_header`.`pr_no` AS `pr_no`,`sap_php`.`t_nonstdstock_header`.`plant` AS `plant`,`sap_php`.`t_nonstdstock_header`.`storage_location` AS `storage_location`,`sap_php`.`t_nonstdstock_header`.`request_reason` AS `request_reason`,`sap_php`.`t_nonstdstock_header`.`item_group_code` AS `item_group_code`,`sap_php`.`t_nonstdstock_header`.`created_date` AS `created_date`,`sap_php`.`t_nonstdstock_header`.`status` AS `status`,`sap_php`.`t_nonstdstock_detail`.`id_nonstdstock_h_detail` AS `id_nonstdstock_h_detail`,`sap_php`.`t_nonstdstock_detail`.`material_no` AS `material_no`,`sap_php`.`t_nonstdstock_detail`.`material_desc` AS `material_desc`,`sap_php`.`t_nonstdstock_detail`.`delivery_date` AS `delivery_date`,`sap_php`.`t_nonstdstock_detail`.`lead_time` AS `lead_time`,`sap_php`.`t_nonstdstock_detail`.`requirement_qty` AS `requirement_qty`,`sap_php`.`t_nonstdstock_detail`.`uom` AS `uom` from (`sap_php`.`t_nonstdstock_header` join `sap_php`.`t_nonstdstock_detail` on((`sap_php`.`t_nonstdstock_header`.`id_nonstdstock_header` = `sap_php`.`t_nonstdstock_detail`.`id_nonstdstock_header`)))
