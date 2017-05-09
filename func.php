<?php
 
session_start(); 
 
function short_title($text,$len){
    return mb_substr( $text , 0,$len, 'UTF-8') . '...' ;
}
 
function my_pdo() {
    $conn = "mysql: host=luffy.ee.ncku.edu.tw:22;dbname=uidd2017_groupJ";
    $user="groupj";
    $pass="npngnpng";
    $dbh = new PDO($conn,$user,$pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) or die('Error connecting to mysql');
    return $dbh;  
}
 
function db_get_user($userid,$password){
    $dbh = my_pdo();
    $sql = "select * from member where userid = :userid and password = :password";
    $sth = $dbh->prepare($sql);
    $sth->bindParam('userid',$userid);
    $sth->bindParam('password',$password);
    $sth->execute();
    $result = $sth->fetch();
    return $result ? $result : false;
}
 
function P($key, $default=''){
    if( isset($_POST[$key]) ) {
         echo htmlspecialchars( $_POST[$key] ); 
    }else{
        echo htmlspecialchars( $default );
    }
}
 
function has_session(){
    return !empty($_SESSION['userid']);
}
 
function require_role($role){
    if( !isset($_SESSION['role']) && $_SESSION['role']!=$role){
        header("Location: index.php");
    }
}
 
function has_role($role){
    return isset($_SESSION['role']) && $_SESSION['role']==$role;
}
 
function db_record_exists($tbl,$field,$value){
    $dbh = my_pdo();
    $sql = "select * from member where {$field} = :{$field}";
    $sth = $dbh->prepare($sql);
    $sth->bindParam(":{$field}",$value);
    $sth->execute();
    $result = $sth->fetch();
    return $result ? true : false;
}

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function iconpath($type){
	switch($type){
	case a: $icon = "o_flower.png.png"; break;
	case b: $icon = "o_tree.png"; break;
	case c: $icon = "o_car_wash.png"; break;
	case d: $icon = "o_drink.png"; break;
	case e: $icon = "o_sofa.png"; break;
	case f: $icon = "o_paint.png"; break;
	case g: $icon = "o_tea.png"; break;
	case h: $icon = "o_cleardesk.png"; break;
	case i: $icon = "o_food.png"; break;
	case j: $icon = "o_restaurant.png"; break;
	case k: $icon = "o_carebaby.png"; break;
	case l: $icon = "o_bike.png"; break;
	}
	echo $icon;
}
?>