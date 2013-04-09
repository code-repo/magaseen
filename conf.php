<?php
#Site Urls and Paths
define("SITE_URL", "http://localhost/magaseen/"); #LOCAL
define("SITE_PATH", "D:\\Work\\songs\\htdocs\\magaseen\\"); #LOCAL
define("FFMPEG_PATH", "C:\\xampp\\htdocs\\ffmpeg.exe");
define("GRAPHICS_URL", SITE_URL."graphics/main/");
define("GRAPHICS_PATH", SITE_PATH."graphics/main/");
define("ADMIN_GRAPHICS_URL", SITE_URL."graphics/admin/");
define("LIBRARY_PATH", SITE_PATH."_core/library/");
define("LIBRARY_URL", SITE_URL."_core/library/");
define("TEMPLATE_PATH", SITE_PATH."_core/templates/");
define("MODULE_PATH", SITE_PATH."_core/modules/");
define("CLASS_PATH", SITE_PATH."_core/classes/");
define("FCK_EDITOR_PATH", SITE_PATH."FCKeditor/");

#Smarty variables
define("SMARTY_DIR_TEMPLATES", SITE_PATH."_core/library/smarty/templates/");
define("SMARTY_DIR_TEMPLATES_C", SITE_PATH."_core/library/smarty/templates_c/");
define("SMARTY_DIR_CONF", SITE_PATH."_core/library/smarty/configs/");

#Database settings
define("DB_HOST", "localhost");
define("DB_DATABASE", "magaseen");
define("DB_USER_NAME", "root");
define("DB_PASSWORD", "");
define('DSN', "mysql://".DB_USER_NAME.":".DB_PASSWORD."@".DB_HOST."/".DB_DATABASE); 

#Define site titles
define("SITE_TITLE", "Magaseen");
define("SITE_TITLE_ADMIN", "Magaseen Administrator");

#Define limits
define("PAGE_SIZE", 20);

# Define email settings
define('MAIL_FROM_TEXT','CMS');
define('MAIL_FROM_EMAIL','testersps@gmail.com');
?>