<?php
include_once(LIBRARY_PATH."adodb/adodb.inc.php");
global $dbCon;
$dbCon = NewADOConnection("mysql"); // A new connection
$dbCon->Connect(DB_HOST, DB_USER_NAME, DB_PASSWORD, DB_DATABASE, $forceNew = false);
mysql_set_charset("utf8");
?>