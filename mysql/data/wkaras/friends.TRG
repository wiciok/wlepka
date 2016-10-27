TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `friends_before_id_user_2_insert` BEFORE INSERT ON `FRIENDS` FOR EACH ROW BEGIN\nIF (new.id_user_2 = id_user_1)\nTHEN SIGNAL SQLSTATE \'45000\' SET message_text = \'Nie mozna byc znajomym samego siebie\';\nEND IF;\n\nEND' 'CREATE DEFINER=`root`@`localhost` TRIGGER `friends_before_id_user_2_update` BEFORE UPDATE ON `FRIENDS` FOR EACH ROW BEGIN\nIF (new.id_user_2 = id_user_1)\nTHEN SIGNAL SQLSTATE \'45000\' SET message_text = \'Nie mozna byc znajomym samego siebie\';\nEND IF;\n\nEND'
sql_modes=524288 524288
definers='root@localhost' 'root@localhost'
client_cs_names='utf8mb4' 'utf8mb4'
connection_cl_names='utf8mb4_unicode_ci' 'utf8mb4_unicode_ci'
db_cl_names='utf8_unicode_ci' 'utf8_unicode_ci'
