-- Apply once to the company schema supplied for this change.
-- Deploy together with the lowercase company application fields.
ALTER TABLE `company`
  CHANGE COLUMN `Name` `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  CHANGE COLUMN `Serv_id` `serv_id` int UNSIGNED NOT NULL,
  CHANGE COLUMN `Employee_Name` `employee_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  CHANGE COLUMN `Job_title` `job_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  CHANGE COLUMN `Phone` `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  CHANGE COLUMN `Floor` `floor` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  CHANGE COLUMN `Tax_card` `tax_card` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  CHANGE COLUMN `Commercial_Register` `commercial_register` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  CHANGE COLUMN `Company_activity` `company_activity` int NULL DEFAULT NULL,
  CHANGE COLUMN `Employee_Name_en` `employee_name_en` varchar(255) CHARACTER SET utf16 COLLATE utf16_general_ci NULL DEFAULT NULL,
  CHANGE COLUMN `Job_title_en` `job_title_en` varchar(255) CHARACTER SET utf16 COLLATE utf16_general_ci NULL DEFAULT NULL;
