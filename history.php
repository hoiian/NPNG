<html>
<?php 
require_once("func.php");

$dbh = my_pdo();
$sth = $dbh->query("SELECT * FROM  `task` WHERE  `status` =2 order by id desc");

?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>歷史記錄</title>
<link href="css/sceen.css" rel="stylesheet" type="text/css" />
<link href="css/screen_history.css" rel="stylesheet" type="text/css" />
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
            <li><a href="bank.php">存款 </a></li>
            <li style="border-bottom:#FFFF8C 3px solid">完成任務</li>
            <li><a href="social.php">社群</a></li>
        </ul>
	</div>
    
<div class="history">
        <div class="tasklist">
        <ul>
            <?php do{ $row = $sth->fetch(); if($row){?>
            <a href="task_detail.php?id=<?php echo $row['id'] ?>">
            <li>
					<img src="img/<?php iconpath($row['type']);?>" alt="taskicon"/><br/>
                    
                    <span class="title"><?php echo $row['title'] ?></span><br/>
                    <span class="money"><?php echo $row['money'] ?>元</span> <br/>
                    <span class="time"><?php echo date("Y-m-d h:i A",strtotime($row['last_active'])) ?></span>
                    
            </li>
            <?php } } while($row) ?>   
            </a>
          </ul>
     
        </div>

</div>

</body>
</html>