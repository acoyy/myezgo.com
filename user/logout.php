<?php

require("lib/setup.php"); 

session_unset();
session_destroy();

header("location:../");

?>