use forms;
set names utf8mb4;

ALTER DATABASE forms CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

alter table field default character set utf8mb4;
alter table field_type default character set utf8mb4;
alter table form default character set utf8mb4;
alter table pref default character set utf8mb4;
alter table registration default character set utf8mb4;
alter table registration_detail default character set utf8mb4;

ALTER TABLE field MODIFY name varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE field MODIFY label varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE field MODIFY field_type_id varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'text';
ALTER TABLE field MODIFY choices text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE field MODIFY status enum('show','hide') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'hide';

ALTER TABLE field_type MODIFY id varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE field_type MODIFY name varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

ALTER TABLE form MODIFY name varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE form MODIFY email varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL;
ALTER TABLE form MODIFY pc_form_template text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE form MODIFY pc_confirm_template text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE form MODIFY pc_thanx_template text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE form MODIFY mobile_form_template text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE form MODIFY mobile_confirm_template text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE form MODIFY mobile_thanx_template text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE form MODIFY smartphone_form_template text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE form MODIFY smartphone_confirm_template text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE form MODIFY smartphone_thanx_template text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE form MODIFY thanx_mail_template text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE form MODIFY status enum('show','hide') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'hide';

ALTER TABLE pref MODIFY name varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

ALTER TABLE registration MODIFY user_agent tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE registration MODIFY remote_host tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

ALTER TABLE registration_detail MODIFY answer text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
