TYPE=VIEW
query=select `wkaras`.`users`.`id_user` AS `id_user`,`wkaras`.`users`.`login` AS `login`,`wkaras`.`users`.`passw` AS `passw`,`wkaras`.`users`.`city` AS `city`,`wkaras`.`users`.`id_country` AS `id_country`,`wkaras`.`users`.`birth_date` AS `birth_date`,`wkaras`.`users`.`user_type` AS `user_type`,`wkaras`.`files`.`id_file` AS `id_file`,`wkaras`.`files`.`path` AS `path`,`wkaras`.`files`.`id_lang` AS `id_lang` from (`wkaras`.`users` join `wkaras`.`files` on((`wkaras`.`users`.`id_user` = `wkaras`.`files`.`id_user`)))
md5=d848c479f092746a87ee27f83cde239e
updatable=1
algorithm=0
definer_user=wkaras
definer_host=%
suid=1
with_check_option=0
timestamp=2016-11-19 16:15:05
create-version=2
source=select `wkaras`.`users`.`id_user` AS `id_user`,`wkaras`.`users`.`login` AS `login`,`wkaras`.`users`.`passw` AS `passw`,`wkaras`.`users`.`city` AS `city`,`wkaras`.`users`.`id_country` AS `id_country`,`wkaras`.`users`.`birth_date` AS `birth_date`,`wkaras`.`users`.`user_type` AS `user_type`,`wkaras`.`files`.`id_file` AS `id_file`,`wkaras`.`files`.`path` AS `path`,`wkaras`.`files`.`id_lang` AS `id_lang` from (`users` join `files` on((`wkaras`.`users`.`id_user` = `wkaras`.`files`.`id_user`)))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `wkaras`.`users`.`id_user` AS `id_user`,`wkaras`.`users`.`login` AS `login`,`wkaras`.`users`.`passw` AS `passw`,`wkaras`.`users`.`city` AS `city`,`wkaras`.`users`.`id_country` AS `id_country`,`wkaras`.`users`.`birth_date` AS `birth_date`,`wkaras`.`users`.`user_type` AS `user_type`,`wkaras`.`files`.`id_file` AS `id_file`,`wkaras`.`files`.`path` AS `path`,`wkaras`.`files`.`id_lang` AS `id_lang` from (`wkaras`.`users` join `wkaras`.`files` on((`wkaras`.`users`.`id_user` = `wkaras`.`files`.`id_user`)))
mariadb-version=100116
