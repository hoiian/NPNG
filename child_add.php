<html xmlns="http://www.w3.org/1999/xhtml">
<link href="sceen.css" rel="stylesheet" type="text/css" />
<?php 
require_once ("func.php");
require_role('child');
$child = $_SESSION['userid'];

$dbh = my_pdo();
$sth = $dbh->prepare("SELECT * FROM `task` WHERE `child` = :child");
$sth->bindParam(":child", $child );
$sth->execute();

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
		
		$sth1 = $dbh->prepare("INSERT INTO task(child,img) 	
								 VALUES(:child,:img) ");
		$sth1->bindParam(":img", $img );
		$sth1->bindParam(":child", $child );
		$rtn = $sth1->execute();
		if($rtn){
			$pass = "成功上傳";
			unset($_POST);	
			header('Location: child_add.php');	
		}else{
			$error = "DB error";
			var_dump($sth1->errorInfo());
		}
	}
}
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上傳照片</title>
<link href="/sceen.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div>
  <div class="content">
 
    <div class="words">
      <div style="padding:3px;"><a href="index.php">主頁</a> > 上傳照片</div>
    </div>
    <div class="passage" style=" width:910px; float:left; height:700px" >
    <?php if ( has_session() ): ?>
	使用者：<?php echo $_SESSION['userid']; ?>
	身份：<?php echo $_SESSION['role']; ?>
	<?php endif ?>

    <div class="news_edit"> 
    
	 <div class="homework">
  <?php while($row = $sth->fetch()) {?>
 
		 <ul>
       <li>
       			<div class="file">file:
                <a href="<?php echo $row['img'] ?>"><?php echo $row['img'] ?></a>
                </div>
                
                <div class="score">
                <?php if($row['finish']){ ?>
                <em>已完成</em>
                 <?php }else{?>
                 <em>未審核</em>
				 <?php } ?>
                </div>
		</li>
        </ul>
        
    <?php } ?>
    
    
      <?php if($pass){ ?>
    	<div class="pass"><?php echo $pass ?></div>
    <?php } ?>
	<?php if($error){ ?>
    	<div class="error"><?php echo $error ?></div>
    <?php } ?>
	<form enctype="multipart/form-data" action="child_add.php" method="post">
		<div class="form_row">
			檔案
            <input type="file" accept="image/*" capture="camera" id="file" name="file"/>
		</div>
		<input type="submit" name="taskphoto_submit" value="上傳"/>
	</form>
    </div>


</div>
</div>
</div>
</div>

</body>
</html>