<?php
session_start();
require('dbconnect.php');
$id = $_REQUEST['id'];
$del = $db->prepare('DELETE FROM masters WHERE id=?');
$del->execute(array($id));

header('Location: admin.php');
exit();
?>