<html>
<?php 
require_once("func.php");
$dbh = my_pdo();
$bid = $_GET['id'];;
$sth = $dbh->query("SELECT * FROM `task` WHERE id='$bid'");
$sth->execute();

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

		$target_path = $target_path . basename($_FILES['file']['name']); 
		echo  basename($_FILES['file']['tmp_name']);
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
		
		$sth = $dbh->prepare(" UPDATE task SET img=:img, status='1' WHERE id='$bid' ");
		$sth->bindParam(":img", $img );
		$rtn = $sth->execute();
		if($rtn){
			$pass = "成功上傳";
			unset($_POST);	
			header('Location: '.$_SERVER['REQUEST_URI']);
		}else{
			$error = "DB error";
			var_dump($sth->errorInfo());
		}
	}
}

if( isset($_POST['finish_submit']) ){

		$dbh = my_pdo();
		$sth1 = $dbh->prepare("UPDATE task SET status='2' WHERE id='$bid' ");
		$rtn1 = $sth1->execute();
		if($rtn1){
			$pass = "編輯成功";
			unset($_POST);	
			header('Location: '.$_SERVER['REQUEST_URI']);
		}else{
			$error = "DB error";
			var_dump($sth1->errorInfo());
		}
	
}
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>任務</title>
<link href="css/sceen.css" rel="stylesheet" type="text/css" />
<link href="css/screen_task_detail.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="detail">
	<?php while($row = $sth->fetch() ){
		$status = $row['status'];
		$taskimg = $row['img'];
	?>
  
  	<div class="header">
        <div class="title">
            <p>任務</p>
            <div class="nothing"></div>
            <a href="index.php">首頁</a>
            <?php if( has_role('parent') ): ?>
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
        <p class="time"><?php echo $row['created_at'] ?></p>
        <p class="title"><?php echo $row['title'] ?></p>
		<p class="money"><?php echo $row['money'] ?></p>
		<div align="center">
       		<img src="<?php echo $row['img'] ?>" width="600" height="auto" /><?php }?> <!--endwhile-->
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