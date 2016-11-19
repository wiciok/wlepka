TYPE=TRIGGERS
triggers='CREATE DEFINER=`wkaras`@`localhost` TRIGGER `friends_before_id_user_2_update` BEFORE UPDATE ON `friends` FOR EACH ROW BEGIN\nIF (new.id_user_2 = id_user_1)\nTHEN SIGNAL SQLSTATE \'45000\' SET message_text = \'Nie mozna byc znajomym samego siebie\';\nEND IF;\n\nEND'
sql_modes=1342177280
definers='wkaras@localhost'
client_cs_names='utf8'
connection_cl_names='utf8_general_ci'
db_cl_names='utf8_unicode_ci'
