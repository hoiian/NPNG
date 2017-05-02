<html>
<?php 
require_once("func.php");
$dbh = my_pdo();
$sth = $dbh->query("select * from `task` order by id desc");

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

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>存款</title>
<link rel="icon" href="img/icon.ico" />
<link href="css/sceen.css" rel="stylesheet" type="text/css" />
<link href="css/screen_bank.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="bank">
	<div class="header">
        <div class="title">
            <p>存款</p>
            <div class="nothing"></div>
            <a href="#"><img src=img/ic_settings.png></a>
        </div>
        
        <ul>
            <li style="border-bottom:#FFFF8C 3px solid">存款</li>
            <li><a href="history.php">歷史任務</a></li>
        </ul>
	</div>
        
	<a href="logout.php" class="button" align="center">登出</a>
        <div class="tasklist">
        
        <div class="tit"><div class="nothing"></div>目前任務</div>
        <ul>
            <?php 
           do{ $row = $sth->fetch(); if($row){?>
            <li>
                
                	<img src="img/<?php iconpath($row['type']);?>" alt="taskicon"/>
                    <span class="money">
                        <div class="nothing"></div>
                        $<?php echo $row['money'];?>
                    </span>
                    
                     <?php if( has_role('child') ): ?>
                    <span><a href="child_add.php">上傳照片</a></span>
                    <?php endif; ?>
                
            </li>
            <?php }} while($row) ?>   
          </ul>
        </div>
        
        <div class="bar">
        </div>

		</div> <!--task-->
      
      
      <div class="new_task" <?php if( has_role('child') ): ?>style="background:#9B9B9B;"<?php endif; ?>>
          <div class="nothing"></div>
          <span><a href="task_add.php">新任務</a></span>
      </div>
</div>

</body>
</html>