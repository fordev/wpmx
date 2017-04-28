<?php
include_once('../../../wp-load.php');
//call the "class.php" file
require_once 'class.php';
//instantiate DB class
$export = new DB();
//call function
$export->downloadCsv();
?>
