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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
    <?php echo $grp;?>群組的小孩排行榜:
        <ul>
            <?php do{ $row = $sth->fetch(); if($row){?>
            <li>
            		<img src="<?php echo $row['profilepic'];?>"  width="80px" height="auto" alt="profilepic">
                    <span class="title"><?php echo $row['name'] ?></span>
                    /<span class="score"><?php echo $row['score'] ?>分</span><br/>
            </li>
            <?php } } while($row) ?>

          </ul>
      </div>
      </a>
      <div class="other">
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
<script>
	var color = ["#b8f1ed","#b8f1cc","#d9b8f1"];
  $(".social .other ul li").css("background-color",color[1]);
</script>
</body>
</html>
