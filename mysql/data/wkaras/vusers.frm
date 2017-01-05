TYPE=VIEW
query=select `wkaras`.`users`.`id_user` AS `id_user`,`wkaras`.`users`.`login` AS `login`,`wkaras`.`users`.`name` AS `name`,`wkaras`.`users`.`surname` AS `surname`,`wkaras`.`users`.`birth_date` AS `birth_date`,`wkaras`.`users`.`user_type` AS `user_type`,`wkaras`.`users`.`city` AS `city`,`wkaras`.`countries`.`name` AS `country_name` from (`wkaras`.`users` left join `wkaras`.`countries` on((`wkaras`.`users`.`id_country` = `wkaras`.`countries`.`id_country`)))
md5=914d21973abe80654cb64bf008c7f182
updatable=0
algorithm=0
definer_user=wkaras
definer_host=localhost
suid=1
with_check_option=0
timestamp=2017-01-05 14:44:06
create-version=2
source=select users.id_user,`users`.`login` AS `login`,`users`.`name` AS `name`,`users`.`surname` AS `surname`,`users`.`birth_date` AS `birth_date`,`users`.`user_type` AS `user_type`,`users`.`city` AS `city`,`countries`.`name` AS `country_name` from (`users` left join `countries` on((`users`.`id_country` = `countries`.`id_country`)))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `wkaras`.`users`.`id_user` AS `id_user`,`wkaras`.`users`.`login` AS `login`,`wkaras`.`users`.`name` AS `name`,`wkaras`.`users`.`surname` AS `surname`,`wkaras`.`users`.`birth_date` AS `birth_date`,`wkaras`.`users`.`user_type` AS `user_type`,`wkaras`.`users`.`city` AS `city`,`wkaras`.`countries`.`name` AS `country_name` from (`wkaras`.`users` left join `wkaras`.`countries` on((`wkaras`.`users`.`id_country` = `wkaras`.`countries`.`id_country`)))
mariadb-version=100116
