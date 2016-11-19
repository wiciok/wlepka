TYPE=VIEW
query=select `wkaras`.`shares`.`id_permission` AS `id_permission`,`wkaras`.`shares`.`id_user` AS `id_user`,`wkaras`.`shares`.`id_file` AS `id_file`,`wkaras`.`permissions`.`permisson_name` AS `permisson_name`,`wkaras`.`permissions`.`id_shared_user` AS `id_shared_user` from (`wkaras`.`shares` join `wkaras`.`permissions` on((`wkaras`.`shares`.`id_permission` = `wkaras`.`permissions`.`id_permission`)))
md5=32a84937b1d70cb8665611a4c0b5a19c
updatable=1
algorithm=0
definer_user=wkaras
definer_host=%
suid=1
with_check_option=0
timestamp=2016-11-19 16:15:05
create-version=2
source=select `wkaras`.`shares`.`id_permission` AS `id_permission`,`wkaras`.`shares`.`id_user` AS `id_user`,`wkaras`.`shares`.`id_file` AS `id_file`,`wkaras`.`permissions`.`permisson_name` AS `permisson_name`,`wkaras`.`permissions`.`id_shared_user` AS `id_shared_user` from (`shares` join `permissions` on((`wkaras`.`shares`.`id_permission` = `wkaras`.`permissions`.`id_permission`)))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `wkaras`.`shares`.`id_permission` AS `id_permission`,`wkaras`.`shares`.`id_user` AS `id_user`,`wkaras`.`shares`.`id_file` AS `id_file`,`wkaras`.`permissions`.`permisson_name` AS `permisson_name`,`wkaras`.`permissions`.`id_shared_user` AS `id_shared_user` from (`wkaras`.`shares` join `wkaras`.`permissions` on((`wkaras`.`shares`.`id_permission` = `wkaras`.`permissions`.`id_permission`)))
mariadb-version=100116
