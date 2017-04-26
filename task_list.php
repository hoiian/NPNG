<html>
<?php 
require_once("func.php");
$dbh = my_pdo();

$sth = $dbh->query("select * from `task` order by id desc");
$page = $_GET['page'];
$sum = 0; 
for ($i=1; $i<=(3*$page-3); $i++) { $row = $sth->fetch(); }
$how = $dbh->query("select * from task");
$h = $how->fetch();

while ($h) { $sum = $sum + 1; $h = $how->fetch(); }
$before = $_GET['page'] - 1;
$after = $_GET['page'] + 1;
if ($sum % 3 > 0 ) { $sum = floor($sum / 3) + 1; } else { $sum = floor($sum / 3);}

?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>任務</title>
<link href="sceen.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="afterlogin">
        <?php if($pass){ ?><div class="pass"> <?php echo $pass;?> </div><?php } ?>
        
        <div class="profile">
			<img src="<?php echo $_SESSION['profilepic'];?>" width="80" height="80" alt="profilepic">
            Hello,
            <?php echo $_SESSION['name'];
                if( $_SESSION['role'] == child){
                    echo "小朋友<br/>";
                }
                if( $_SESSION['role'] == parent){
                    echo "爸爸/媽媽<br/>";
                }
            ?>
            <a href="reg_edit.php?id=<?php echo $_SESSION['id'];?>" class="button" align="center">編輯</a>
            <a href="logout.php" class="button" align="center">登出</a>
		</div>
        
		<?php if( has_role('child') ): ?>
  		  <!--   <a href="student_add.php?>" class="ed" >[任務]</a>-->
		<?php endif; ?>

        <div class="task">
            <span class="title">任務</span>

			<?php if( has_role('parent') ): ?>
                <a href="task_add.php" class="ed" >[新增任務]</a>
            <?php endif; ?>
	
        <div class="tasklist">
        <ul>
            <?php 
            for ($i=1;$i<=3;$i++) { $row = $sth->fetch(); if ($row) { ?>
            <li>
                <a href="#" class="n">
                    <span class="title"><?php echo $row['title'] ?></span><br/>
                    <span class="summary"><?php echo $row['post'] ?></span> <br/>
                    <span class="start"><?php echo $row['created_at'] ?></span>
                    <span class="deadline">到<?php echo $row['deadline'] ?></span><br/>
                    <span>
                    <?php 	
                            $remain = (strtotime($row['deadline'])-strtotime(date("Y-m-d")))/86400;
                            if($remain <0 ){
                                echo "已經過了".-$remain."天";
                            }elseif($remain == 0){
                                echo "今天到期!";
                            }else echo "還剩下".$remain."天";
                    ?>
                    </span><br/>
                    <span>獎勵:<?php echo $row['money'];?>元</span>
                    
                
                                
                    <?php if( has_role('parent') ): ?>
                           <a href="task_edit.php?id=<?php echo $row['id'];?>" class="ed" >Edit</a> |
                           <a onClick="return confirm('確認刪除？');" href="task_delete.php?id=<?php echo $row['id'];?>" class="ed"> Delete</a>
                    <?php endif; ?>
                    
                     <?php if( has_role('child') ): ?>
                    <span><a href="child_add.php">上傳照片</a></span>
                    <?php endif; ?>
                </a>
            </li>
            <?php } } ?>   
          </ul>
      
    	  <div class="page">
            頁次:<?php echo $_GET['page']."/". $sum ;?>　|
            
            <?php if ($_GET['page'] != 1){?>
            <a href="task_list.php?page=1"> <?php } ?>最前頁</a>　
            
            <?php if ($before >= 1){?>
            <a href="task_list.php?page=<?php echo $before; ?>" > <?php } ?> 上一頁　</a>
            
            <?php for ($i=1;$i<=$sum;$i++) { ?> 
            <?php if ($i != $_GET['page'] ) { ?>
            <a href="task_list.php?page=<?php echo $i; ?>"> <?php } ?> <?php echo $i; ?>　</a> <?php } ?> 
            
            <?php if ($after <= $sum){?> 
            <a href="task_list.php?page=<?php echo $after; ?>" > <?php } ?> 下一頁　</a>
            
            <?php if ($_GET['page'] != $sum){?>
            <a href="task_list.php?page=<?php echo $sum;?>"> <?php } ?>最後頁</a>
        </div>
        
        </div>

		</div> <!--task-->
</div> <!--afterlogin-->

</body>
</html>