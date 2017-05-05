<html>
<?php 
require_once("func.php");
$dbh = my_pdo();
$bid = $_GET['id'];
$sth = $dbh->query("SELECT * FROM `task` WHERE id='$bid'");
$sth->execute();
$row = $sth->fetch();

$status = $row['status'];
$taskimg = $row['img'];
function changedimg(){
	return (strcmp($taskimg,"Taskphoto/incomplete.png") == 0) ? 0 : 1;
}

$error = "";
$pass = "";
if( isset($_POST['taskphoto_submit']) ){
	if( empty($_FILES['file']['name']) ){
		$error = "Select a file";
	}else{		
		/* insert into db if no error */
		$target_path = "Taskphoto/";
		
		$info = pathinfo($_FILES['file']['name']);
		$i = 0;
		do {
			$image_name = $info['filename'] . ($i ? "_($i)" : "") . "." . $info['extension'];
			$i++;
			$target_path = "Taskphoto/" . $image_name;
		} while(file_exists($target_path));
//		$target_path = $target_path . basename($_FILES['file']['name']); 
//		echo  basename($_FILES['file']['tmp_name']);
		if( move_uploaded_file($_FILES['file']['tmp_name'], $target_path) ) {
		    $pass = "file uploded";
		} else{
		    $error .= "file move fail";
		}
	}
	
	if($error ==""){
		$dbh = my_pdo();
		$child = $_SESSION['userid'];
		$img = $target_path;
		
		$sth2 = $dbh->prepare(" UPDATE task SET img=:img, status='1' WHERE id='$bid' ");
		$sth2->bindParam(":img", $img );
		$rtn = $sth2->execute();
		if($rtn){
			$pass = "成功上傳";
			unset($_POST);	
			header('Location: '.$_SERVER['REQUEST_URI']);
		}else{
			$error = "DB error";
			var_dump($sth2->errorInfo());
		}
	}
}

if( isset($_POST['finish_submit']) ){

		$dbh = my_pdo();
		$sth1 = $dbh->prepare("UPDATE task SET status='2' WHERE id='$bid' ");
		$rtn1 = $sth1->execute();
		// - money
		$uid = $_SESSION['id'];
		$_SESSION['savemoney'] = $_SESSION['savemoney'] - $row['money'];
		$sth3 = $dbh->prepare(" UPDATE member SET savemoney=:savemoney WHERE id='$uid' ");
		$sth3->bindParam(":savemoney", $_SESSION['savemoney'] );
		$rtn3 = $sth3->execute();
		//get the kids info and add money to kid's account
		$matuid = $_SESSION['matchuser'];
		$sth4 = $dbh->query("SELECT * FROM `member` WHERE userid='$matuid'");
		$sth4->execute();
		$match = $sth4->fetch();
		$mid = $match['id'];
		$mmoney = $match['savemoney'] + $row['money'];
		$sth5 = $dbh->prepare(" UPDATE member SET savemoney=:savemoney WHERE id='$mid' ");
		$sth5->bindParam(":savemoney",$mmoney );
		$rtn5 = $sth5->execute();
		
		if($rtn1 && $rtn3 && $rtn5){
			$pass = "付款成功";
			unset($_POST);	
			header('Location: '.$_SERVER['REQUEST_URI']);
		}else{
			$error = "DB error";
			var_dump($sth1->errorInfo());
			var_dump($sth3->errorInfo());
			var_dump($sth5->errorInfo());
		}

}
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>任務</title>
<link href="css/sceen.css" rel="stylesheet" type="text/css" />
<link href="css/screen_task_detail.css" rel="stylesheet" type="text/css" />
<?php if( has_role('child') ): ?>
<link href="css/child.css" rel="stylesheet" type="text/css" />
<?php endif; ?>
</head>

<body>

<div class="detail">
  
  	<div class="header">
        <div class="title">
            <p>任務</p>
            <div class="nothing"></div>
            <a href="index.php">首頁</a>
            <?php if( has_role('parent') && $status!=2): ?>
            <a href="task_edit.php?id=<?php echo $row['id'];?>" >編輯</a>
            <a onClick="return confirm('確認刪除？');" href="task_delete.php?id=<?php echo $row['id'];?>">刪除</a>
            <?php endif; ?>
        </div>
     </div>
     
     
    <div class="info">    
        <?php if ( has_session() ): ?>
	使用者：<?php echo $_SESSION['name']; ?>
	身份：<?php echo $_SESSION['role']; ?>
	<?php endif ?>
        <p class="time"><?php echo $row['last_active'] ?></p>
        <p class="title"><?php echo $row['title'] ?></p>
		<p class="money"><?php echo $row['money'] ?></p>
		<div align="center">
       		<img src="<?php echo $row['img'] ?>" width="600" height="auto" />
		</div>
        
                    <?php if( has_role('child') ): ?>
                    <!--<p><a href="child_add.php">上傳照片</a></p>-->
                       <?php if($pass){ ?>
                        <div class="pass"><?php echo $pass ?></div>
                    <?php } ?>
                    <?php if($error){ ?>
                        <div class="error"><?php echo $error ?></div>
                    <?php } ?>
                    
                    <form enctype="multipart/form-data" action="task_detail.php?id=<?php echo $bid ?>" method="post">
                        <input type="file" accept="image/*" capture="camera" id="file" name="file"/>
                        <input type="submit" name="taskphoto_submit" value="上傳"/>
                    </form>
                    
      </div>
   
                  <div class="btn_bottom" <?php if( $status != 1 ): ?>style="background:#9B9B9B;"<?php endif; ?>>
                      <div class="nothing"></div>
                      <span>
                      <?php if( $status ==1 ): ?><a href="bank.php"><?php endif; ?>
                      <?php
					  switch($status){
						  case 0: echo "未完成"; break;
						  case 1: echo "待審核"; break;
						  case 2: echo "已完成"; break;
					  }
                      ?>
                      <?php if( $status ==1 ): ?></a><?php endif; ?>
                      </span>
                  </div>
                  
                  <?php endif; ?> <!--if child-->
                  
                  
                  <?php if( has_role('parent') ): ?>
                  <form action="task_detail.php?id=<?php echo $bid ?>" method="post">
                  <input type="submit" name="finish_submit" value="付款"/>
                  
                  <div class="btn_bottom" <?php if( $status != 1 ): ?>style="background:#9B9B9B;"<?php endif; ?>>
                      <div class="nothing"></div>
                      <span>
                      <?php if( $status ==1 ): ?><a href="bank.php"><?php endif; ?>
						  <?php
                          switch($status){
                              case 0: echo "付款"; break;
                              case 1: echo "付款"; break;
                              case 2: echo "已付款"; break;
                          }
                          ?>
                      <?php if( $status ==1 ): ?></a><?php endif; ?>
                      </span>
                    </div>
                    </form>
                  <?php endif; ?> <!--if parent-->
                  
      <div style="clear:both"></div>
</div>


</body>
</html>