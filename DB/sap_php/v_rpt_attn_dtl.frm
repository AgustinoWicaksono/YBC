TYPE=VIEW
query=select `b`.`employee_id` AS `employee_id`,`b`.`kode_cabang` AS `cabang`,`a`.`nik` AS `nik`,`b`.`nama` AS `nama`,`a`.`tanggal` AS `tanggal`,max(`a`.`shift`) AS `shift`,max(`a`.`kd_shift`) AS `kd_shift`,max(`a`.`shift_in`) AS `shift_in`,max(`a`.`shift_out`) AS `shift_out`,max(`a`.`shift_break_in`) AS `shift_break_in`,max(`a`.`shift_break_out`) AS `shift_break_out`,max(`a`.`kd_aktual`) AS `kd_aktual`,max(`a`.`in`) AS `in`,max(`a`.`out`) AS `out`,max(`a`.`break_in`) AS `break_in`,max(`a`.`break_out`) AS `break_out` from (`sap_php`.`t_employee_absent` `a` join `sap_php`.`m_employee` `b` on((`a`.`nik` = `b`.`nik`))) group by `b`.`employee_id`,`b`.`kode_cabang`,`a`.`nik`,`b`.`nama`,`a`.`tanggal`
md5=811113484f8b7b6b6823db22297d37da
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2016-08-02 03:32:56
create-version=1
source=select `b`.`employee_id` AS `employee_id`,`b`.`kode_cabang` AS `cabang`,`a`.`nik` AS `nik`,`b`.`nama` AS `nama`,`a`.`tanggal` AS `tanggal`,max(`a`.`shift`) AS `shift`,max(`a`.`kd_shift`) AS `kd_shift`,max(`a`.`shift_in`) AS `shift_in`,max(`a`.`shift_out`) AS `shift_out`,max(`a`.`shift_break_in`) AS `shift_break_in`,max(`a`.`shift_break_out`) AS `shift_break_out`,max(`a`.`kd_aktual`) AS `kd_aktual`,max(`a`.`in`) AS `in`,max(`a`.`out`) AS `out`,max(`a`.`break_in`) AS `break_in`,max(`a`.`break_out`) AS `break_out` from (`t_employee_absent` `a` join `m_employee` `b` on((`a`.`nik` = `b`.`nik`))) group by `b`.`employee_id`,`b`.`kode_cabang`,`a`.`nik`,`b`.`nama`,`a`.`tanggal`
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `b`.`employee_id` AS `employee_id`,`b`.`kode_cabang` AS `cabang`,`a`.`nik` AS `nik`,`b`.`nama` AS `nama`,`a`.`tanggal` AS `tanggal`,max(`a`.`shift`) AS `shift`,max(`a`.`kd_shift`) AS `kd_shift`,max(`a`.`shift_in`) AS `shift_in`,max(`a`.`shift_out`) AS `shift_out`,max(`a`.`shift_break_in`) AS `shift_break_in`,max(`a`.`shift_break_out`) AS `shift_break_out`,max(`a`.`kd_aktual`) AS `kd_aktual`,max(`a`.`in`) AS `in`,max(`a`.`out`) AS `out`,max(`a`.`break_in`) AS `break_in`,max(`a`.`break_out`) AS `break_out` from (`sap_php`.`t_employee_absent` `a` join `sap_php`.`m_employee` `b` on((`a`.`nik` = `b`.`nik`))) group by `b`.`employee_id`,`b`.`kode_cabang`,`a`.`nik`,`b`.`nama`,`a`.`tanggal`
