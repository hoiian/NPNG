<?php

require_once('func.php');

require_role('parent');

$dbh = my_pdo();

$sth = $dbh->prepare('DELETE FROM task WHERE id=:id');
$sth->bindParam(':id',$_GET['id']);
$rtn = $sth->execute();

if($rtn){
	header('Location: index.php');
}else{
	die('DB ERROR');
}
?>