TYPE=VIEW
query=select `wkaras`.`users`.`login` AS `login`,`wkaras`.`users`.`id_user` AS `id_user`,`wkaras`.`users`.`city` AS `city`,`wkaras`.`users`.`user_type` AS `user_type`,`wkaras`.`files`.`id_file` AS `id_file`,`wkaras`.`files`.`path` AS `path` from (`wkaras`.`users` join `wkaras`.`files` on((`wkaras`.`users`.`id_user` = `wkaras`.`files`.`id_user`)))
md5=9341c821f264b7080f38e803cf3a09c7
updatable=1
algorithm=0
definer_user=wkaras
definer_host=%
suid=1
with_check_option=0
timestamp=2016-10-19 16:48:46
create-version=2
source=select `USERS`.`login` AS `login`,`USERS`.`id_user` AS `id_user`,`USERS`.`city` AS `city`,`USERS`.`user_type` AS `user_type`,`FILES`.`id_file` AS `id_file`,`FILES`.`path` AS `path` from (`USERS` join `FILES` on((`USERS`.`id_user` = `FILES`.`id_user`)))
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_unicode_ci
view_body_utf8=select `wkaras`.`users`.`login` AS `login`,`wkaras`.`users`.`id_user` AS `id_user`,`wkaras`.`users`.`city` AS `city`,`wkaras`.`users`.`user_type` AS `user_type`,`wkaras`.`files`.`id_file` AS `id_file`,`wkaras`.`files`.`path` AS `path` from (`wkaras`.`users` join `wkaras`.`files` on((`wkaras`.`users`.`id_user` = `wkaras`.`files`.`id_user`)))
mariadb-version=100116
