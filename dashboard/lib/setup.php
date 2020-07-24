<?php 
session_start();
error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE);
set_time_limit(100);
include ("LibDatabase.php");
include ("LibFunction.php");
include ("LibConvert.php");
include ("LibPaging.php");
include ("LibValidate.php");
include ("LibEmail.php");
include ("LibImage.php");
define("DB_NAME", "myezgo");
define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
vali_mustNoCache();
db_connect(DB_NAME, DB_HOST, DB_USERNAME, DB_PASSWORD); ?>