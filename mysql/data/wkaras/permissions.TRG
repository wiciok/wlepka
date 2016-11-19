TYPE=TRIGGERS
triggers='CREATE DEFINER=`wkaras`@`localhost` TRIGGER `permissions_before_id_user_insert` BEFORE INSERT ON `permissions` FOR EACH ROW BEGIN\nIF (permission_name!=\'write_user\' OR permission_name!=\'read_user\')\nTHEN SIGNAL SQLSTATE \'45000\' SET message_text = \'Nie mozna przypisac id_usera do udostepniania - nieodpowiednie prawo dostepu\';\n\nEND IF;\n\nEND'
sql_modes=1342177280
definers='wkaras@localhost'
client_cs_names='utf8'
connection_cl_names='utf8_general_ci'
db_cl_names='utf8_unicode_ci'
