<?php
require_once ("index.php");

if( has_session() ){
	session_destroy();
}

header('Location: index.php');
?>