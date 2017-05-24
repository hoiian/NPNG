<html>
<?php
require_once("func.php");
$dbh = my_pdo();
$grp = $_SESSION['group'];
$sth = $dbh->query("SELECT * FROM `member` WHERE group='$grp'");
//$sth->execute();
//$mygroup = $sth->fetch();
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>社群</title>
<link href="css/sceen.css" rel="stylesheet" type="text/css" />
<link href="css/screen_social.css" rel="stylesheet" type="text/css" />
</head>

<body>

  
	<div class="header">
        <div class="title">
            <p>急速家事</p>
            <div class="nothing"></div>
            <a href="profile.php" class="setting" ></a>
        </div>
        
        <ul>
            <li><a href="bank.php">存款</a></li>
            <li><a href="history.php">完成任務</a></li>
            <li style="border-bottom:#FFFF8C 3px solid">社群</li>
        </ul>
	</div>
    
    <div class="social">
    <?php echo $grp ?> .........................
    	<ul>
	    <?php do{ $mygroup = $sth->fetch(); if($mygroup){?>
        	<li>
            	<?php echo $row['name'] ?>
               
            </li>
    	<?php } } while($mygroup) ?> 
        </ul>
    </div>

</body>
</html>