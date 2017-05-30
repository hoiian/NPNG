<html>
<?php 
require_once("func.php");

$dbh = my_pdo();
$grp = $_SESSION['group'];
$sth = $dbh->query("SELECT * FROM  `member` WHERE  `group` LIKE  '$grp' AND  `role` LIKE  'child' ORDER BY  `member`.`score` DESC ");

$sth1 = $dbh->query("SELECT DISTINCT `group` 
FROM  `member` 
WHERE  `group` NOT LIKE  '$grp'");


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
	<div class="member">
    <a href="social_timeline.php?group=<?php echo $grp ?>">
    <?php echo $grp;?>群組</a>的小孩排行榜:
        <ul>
            <?php do{ $row = $sth->fetch(); if($row){?>
            <li>
                    <span class="title"><?php echo $row['name'] ?></span>
                    / 分數:<span class="score"><?php echo $row['score'] ?></span><br/>
            </li>
            <?php } } while($row) ?>   
          
          </ul>
     
      </div>
      
      <div class="other">
      其他群組:
          <ul>
            <?php do{ $row1 = $sth1->fetch(); if($row1){?>
             <a href="social_timeline.php?group=<?php echo $row1['group'] ?>">
            <li>
                    <span class="title"><?php echo $row1['group'] ?></span>
            </li>
            </a>
            <?php } } while($row1) ?>   
          
          </ul>
      </div>

</div>

</body>
</html>