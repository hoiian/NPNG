<html>
<?php 
require_once("func.php");

$dbh = my_pdo();
$grp = $_SESSION['group'];
$sth = $dbh->query("SELECT * FROM  `member` WHERE  `group` LIKE  '$grp' AND  `role` LIKE  'child' ORDER BY  `member`.`score` DESC ");

$sth1 = $dbh->query("SELECT DISTINCT `group` 
FROM  `member` 
WHERE  `group` NOT LIKE  '$grp'");

$sth4 = $dbh->query("SELECT * FROM  `task` WHERE  `group` LIKE  '$rgrp' AND `status` =2 LIMIT 1");
$sth4->execute();
$row4 = $sth4->fetch();

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

	<a href="social_timeline.php?group=<?php echo $grp ?>">
	<div class="childrank">

        <ul>
            <?php do{ $row = $sth->fetch(); if($row){?>
            <li>
               
                         <?php //echo $row4['img'];?>
            		<img src="<?php echo $row['profilepic'];?>"  width="80px" height="auto" alt="profilepic">
                    <!--<span class="title"><?php echo $row['name'] ?></span>/-->
                    <span class="score">  <?php echo $row['score'] ?>分</span><br/>
            </li>
            <?php } } while($row) ?>   
          
          </ul>
      </div>
      </a>
      
      <div class="other">
          <ul>
            <?php 
			do{ $row1 = $sth1->fetch(); 
			if($row1){
				$i=1;
			?>
             <a href="social_timeline.php?group=<?php echo $row1['group'] ?>">
            <li>
                            <?php 
							$othergrp = $row1['group'];
							$sth3 = $dbh->query("SELECT * FROM  `task` WHERE  `group` LIKE  '$othergrp' AND `status` =2 order by id desc LIMIT 1");
							$sth3->execute();
							$row3 = $sth3->fetch();
							?>
                            
                            <img src="<?php echo $row3['img'];?>" height="100%" width="100%" alt="taskphoto">
							<!-- add picture here
                            <div class="otherdiv"></div> -->
                            <div class="bar">
                            	<div class="nothing"></div>
                               <img src="img/group_<?php echo $i; $i++;?>.png"width="80px" height="80px" alt"profilepic">
                                <span class="title"><?php echo $othergrp ?></span>
                            </div>
							
            </li>
            </a>
            <?php } } while($row1) ?>

          </ul>
      </div>


</div>

</body>
</html>