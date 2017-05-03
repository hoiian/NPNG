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
<title>歷史記錄</title>
<link href="css/sceen.css" rel="stylesheet" type="text/css" />
<link href="css/screen_history.css" rel="stylesheet" type="text/css" />
</head>

<body>


	<div class="header">
        <div class="title">
            <p>歷史任務</p>
            <a href="#" class="right"><img src=img/ic_settings.png></a>
        </div>
        
        <ul>
            <li><a href="bank.php">存款 </a></li>
            <li style="border-bottom:#FFFF8C 3px solid">歷史任務</li>
        </ul>
	</div>
    
<div class="history">
        <div class="tasklist">
        <ul>
            <?php 
			
            do{ $row = $sth->fetch(); if($row){?>
            <li>
					<img src="img/<?php iconpath($row['type']);?>" alt="taskicon"/><br/>
                    
                    <span class="title"><?php echo $row['title'] ?></span><br/>
                    <span class="money"><?php echo $row['money'] ?>元</span> <br/>
                    <span class="time"><?php echo date("Y-m-d h:i A",strtotime($row['created_at'])) ?></span>

                    
                    <?php if( has_role('parent') ): ?>
                           <a href="task_edit.php?id=<?php echo $row['id'];?>" class="ed" >Edit</a> |
                           <a onClick="return confirm('確認刪除？');" href="task_delete.php?id=<?php echo $row['id'];?>" class="ed"> Delete</a>
                    <?php endif; ?>
                    
                     <?php if( has_role('child') ): ?>
                    <span><a href="child_add.php">上傳照片</a></span>
                    <?php endif; ?>
                    
            </li>
            <?php } } while($row) ?>   
          </ul>
     
        </div>

</div>

</body>
</html>