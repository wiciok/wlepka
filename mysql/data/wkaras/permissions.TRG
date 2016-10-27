TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `permissions_before_id_user_insert` BEFORE INSERT ON `PERMISSIONS` FOR EACH ROW BEGIN\nIF (permission_name!=\'write_user\' OR permission_name!=\'read_user\')\nTHEN SIGNAL SQLSTATE \'45000\' SET message_text = \'Nie mozna przypisac id_usera do udostepniania - nieodpowiednie prawo dostepu\';\n\nEND IF;\n\nEND'
sql_modes=524288
definers='root@localhost'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_unicode_ci'
db_cl_names='utf8_unicode_ci'
