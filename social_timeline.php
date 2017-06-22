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
            <p><?php echo $grp;?>家急速任務</p>
            <a href="profile.php" class="setting"></a>
            <a href="social.php" class="home"></a>
        </div>
        
      <!--  <ul>
            <li><a href="bank.php">存款</a></li>
            <li><a href="history.php">完成任務</a></li>
            <li style="border-bottom:#FFFF8C 3px solid">社群</li>
        </ul>-->
	</div>
    
<div class="social">
	<div class="timeline">
        <ul>
            <?php do{ $row = $sth->fetch(); if($row){?>
            <li>
            
                    <img src="<?php echo $row['img'];?>" alt="taskphoto" width="100%" height="auto"/><br/>

             <div class="whiteBar">       
<!--                    家長帳號:<span class="parent"><?php //echo $row['parent'] ?></span><br/>
                    小孩帳號:<span class="child"><?php //echo $row['child'] ?></span><br/>-->
                    <?php 
					$parentid = $row['parent'];
					$childid = $row['child'];
					
					$sth1 = $dbh->query("SELECT * FROM  `member` WHERE  `userid` LIKE  '$parentid'");
					$sth1->execute();
					$parent = $sth1->fetch();
					
					$sth2 = $dbh->query("SELECT * FROM  `member` WHERE  `userid` LIKE  '$childid'");
					$sth2->execute();
					$child = $sth2->fetch();
					?>
                     <img src="<?php echo $parent['profilepic'];?>" alt="parenticon" width="80px" height="80px"/>
                     <img src="<?php echo $child['profilepic'];?>" alt="childicon" width="80px" height="80px"/>
                    <p class="child"><?php echo $row['title'] ?></p> 
                    
                                                            <!-- LikeBtn.com BEGIN -->
                    <div class="like">
						<span class="likebtn-wrapper" data-theme="custom" data-btn_size="50" data-f_size="40" data-icon_size="50" data-bg_c="rgba(250,250,250,0)" data-brdr_c="rgba(198,198,198,0)" data-i18n_like="讚" data-identifier="item_1"></span>
                    </div>


            </div>
            </li>
            <?php } } while($row) ?>   
          
          </ul>
     
      </div>

</div>

</body>
</html>

<script>(function(d,e,s){if(d.getElementById("likebtn_wjs"))return;a=d.createElement(e);m=d.getElementsByTagName(e)[0];a.async=1;a.id="likebtn_wjs";a.src=s;m.parentNode.insertBefore(a, m)})(document,"script","//w.likebtn.com/js/w/widget.js");</script>