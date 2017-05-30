<html>
<?php 
require_once("func.php");
$grp = $_GET['group'];
$dbh = my_pdo();
//$grp = $_SESSION['group'];
$sth = $dbh->query("SELECT * FROM  `task` WHERE  `group` LIKE  '$grp' AND `status` =2 order by id desc");

?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>社群</title>
<link href="css/sceen.css" rel="stylesheet" type="text/css" />
<link href="css/screen_social.css" rel="stylesheet" type="text/css" />
<?php if( has_role('child') ): ?>
<link href="css/child.css" rel="stylesheet" type="text/css" />
<?php endif; ?>
</head>

<body>


	<div class="header">
        <div class="title">
            <p>急速家事</p>
            <a href="profile.php" class="setting"></a>
        </div>
        
        <ul>
            <li><a href="bank.php">存款</a></li>
            <li><a href="history.php">完成任務</a></li>
            <li style="border-bottom:#FFFF8C 3px solid">社群</li>
        </ul>
	</div>
    
<div class="social">
	<div class="timeline">
    
    <?php echo $grp;?>群組的完成的任務有:
        <ul>
            <?php do{ $row = $sth->fetch(); if($row){?>
            <li>
                    <img src="<?php echo $row['img'];?>" alt="taskphoto" width="100%" height="auto"/><br/>
                    家長帳號:<span class="parent"><?php echo $row['parent'] ?></span><br/>
                    小孩帳號:<span class="child"><?php echo $row['child'] ?></span><br/>
                    任務名稱:<span class="child"><?php echo $row['title'] ?></span><br/>
            </li>
            <?php } } while($row) ?>   
          
          </ul>
     
      </div>

</div>

</body>
</html>