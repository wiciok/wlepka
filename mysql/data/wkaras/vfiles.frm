TYPE=VIEW
query=select `wkaras`.`files`.`id_file` AS `id_file`,`wkaras`.`files`.`name` AS `name`,`wkaras`.`files`.`path` AS `path`,`wkaras`.`users`.`login` AS `login`,`wkaras`.`languages`.`name` AS `langname`,`wkaras`.`files`.`timestmp` AS `timestmp`,(select count(0) from `wkaras`.`shares` where (`wkaras`.`shares`.`id_file` = `wkaras`.`files`.`id_file`)) AS `shares_num` from ((`wkaras`.`files` left join `wkaras`.`users` on((`wkaras`.`files`.`id_user` = `wkaras`.`users`.`id_user`))) left join `wkaras`.`languages` on((`wkaras`.`files`.`id_lang` = `wkaras`.`languages`.`id_lang`)))
md5=e496602d333eaaa207eec46c2194b25f
updatable=0
algorithm=0
definer_user=wkaras
definer_host=localhost
suid=2
with_check_option=0
timestamp=2017-01-05 14:41:52
create-version=2
source=select files.id_file, files.name as \'name\', path, login,languages.name as \'langname\', timestmp, (select count(*) from shares where id_file=files.id_file) as shares_num from files left join users on files.id_user=users.id_user left join languages on files.id_lang=languages.id_lang
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `wkaras`.`files`.`id_file` AS `id_file`,`wkaras`.`files`.`name` AS `name`,`wkaras`.`files`.`path` AS `path`,`wkaras`.`users`.`login` AS `login`,`wkaras`.`languages`.`name` AS `langname`,`wkaras`.`files`.`timestmp` AS `timestmp`,(select count(0) from `wkaras`.`shares` where (`wkaras`.`shares`.`id_file` = `wkaras`.`files`.`id_file`)) AS `shares_num` from ((`wkaras`.`files` left join `wkaras`.`users` on((`wkaras`.`files`.`id_user` = `wkaras`.`users`.`id_user`))) left join `wkaras`.`languages` on((`wkaras`.`files`.`id_lang` = `wkaras`.`languages`.`id_lang`)))
mariadb-version=100116
