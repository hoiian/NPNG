<html>
<?php 
require_once("func.php");
require_role('parent');
require_role('child');
$dbh = my_pdo();
$sth = $dbh->query("SELECT * FROM  `task` WHERE  `status` !=2 order by id desc");

$sth1 = $dbh->prepare(" SELECT * FROM member WHERE id=:id ");
$sth1->bindParam(":id", $_SESSION['id'] );
$sth1->execute();
$member = $sth1->fetch();
$savemoney = $member['savemoney'];
$percentage = (1 - ($savemoney/2000))*100;

?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>急速家事</title>
<link rel="icon" href="img/icon.ico" />
<link href="css/sceen.css" rel="stylesheet" type="text/css" />
<link href="css/screen_bank.css" rel="stylesheet" type="text/css" />
<?php if( has_role('child') ): ?>
<link href="css/child.css" rel="stylesheet" type="text/css" />
<?php endif; ?>
</head>

<body>
<div class="bank">
	<div class="header">
        <div class="title">
            <p>急速家事</p>
            <div class="nothing"></div>
            <a href="profile.php" class="setting" ></a>
        </div>
        
        <ul>
            <li style="border-bottom:#FFFF8C 3px solid">存款</li>
            <li><a href="history.php">完成任務</a></li>
        </ul>
	</div>
        
	<a href="logout.php" class="button" align="center">登出</a>
    
	    <div class="save">
        <div class="nothing"></div>
        <span class="tit">目前存款：</span>
        <span class="num">$<?php echo $savemoney; ?>.00</span>
        </div>
        
        <div class="tasklist">
        <div class="tit"><div class="nothing"></div>未完成任務</div>
        <ul>
            <?php 
           do{ $row = $sth->fetch(); if($row){?>
            <a href="task_detail.php?id=<?php echo $row['id'] ?>">
            <li>
                	<img src="img/<?php iconpath($row['type']);?>" alt="taskicon"/>
                    <?php if ($row['status']==1):?>
                    <span style="color:#FFF;">待審核</span>
                    <?php endif; ?>
                    <span class="money">
                        <div class="nothing"></div>
                        $<?php echo $row['money'];?>
                    </span>
            </li>
            </a>
            <?php }} while($row) ?>   
          </ul>
        </div>

        <div class="bar">
        	<div class="full">
            	<div class="perc" style="height:<?=$percentage?>%;"></div>
            </div>
        </div>

		</div> <!--task-->
      
      
      <div class="new_task btn_bottom" <?php if( has_role('child') ): ?>style="background:#9B9B9B;"<?php endif; ?>>
          <div class="nothing"></div>
          <span>
          <?php if( has_role('parent') ): ?><a href="task_add.php"><?php endif; ?>
          新任務
          <?php if( has_role('parent') ): ?></a><?php endif; ?>
          </span>
      </div>

</body>
</html>