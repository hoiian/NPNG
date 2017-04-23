<html>
<?php 
require_once("func.php");
require_role('parent');

$dbh = my_pdo();
$sth = $dbh->prepare(" SELECT * FROM task WHERE id=:id ");
$sth->bindParam(":id", $_GET['id'] );
$sth->execute();
$task = $sth->fetch();

$error = "";
$pass = "";
if( isset($_POST['task_submit']) ){
	$created_at = trim($_POST['task_created_at']);
	$title = trim($_POST['task_title']);
	$content = trim($_POST['task_content']);
	$deadline = trim($_POST['task_deadline']);
	
	if( $created_at =="" ){
		$error = "日期不能留空<br/>";
	}
	if( $title =="" ){
		$error = "標題不能留空<br/>";
	}
	if( $content =="" ){
		$error .= "內容不能留空<br/>";
	}
	if($error ==""){
		
		$sth = $dbh->prepare(" UPDATE task SET title=:title, post=:content,deadline=:deadline,created_at=:created_at
								WHERE id=:id ");
		$sth->bindParam(":title", $title );
		$sth->bindParam(":content", $content );
		$sth->bindParam(":id", $task['id'] );
		$sth->bindParam(":deadline", $deadline );
		$sth->bindParam(":created_at", $created_at );
		
		$rtn = $sth->execute();
		if($rtn){
			$pass = "OK";	
		}else{
			var_dump($sth->errorInfo());
			$error = "DB error";
		}
	}
}

?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>編輯任務</title>
</head>

<body>

<div >
  <div class="content">
        <div class="words">
      <div style="padding:3px;"><a href="index.php">主頁</a> > 編輯任務</div>
    </div>

    <div class="task_edit"> 
      <?php if($pass){ ?>
    	<div class="pass"><?php echo $pass ?></div>
    <?php } ?>
	<?php if($error){ ?>
    	<div class="error"><?php echo $error ?></div>
    <?php } ?>
	<form action="task_edit.php?id=<?php echo $task['id']?>" method="post">
    	<div class="form_row">
			日期：<br/><input type="date" class="t" name="task_created_at" value="<?php P('task_created_at', $task['created_at']); ?>"/>
		</div>
        
          <div class="form_row">
			到期日期：<br/><input type="date" class="t" name="task_deadline" value="<?php P('task_created_at', $task['deadline']); ?>"/>
		</div>
        
		<div class="form_row">
			標題：<br/><input type="text" class="t" name="task_title" value="<?php P('task_title', $task['title']); ?>"/>
		</div>
		<div class="form_row">
			內容：<br/><textarea name="task_content"><?php P( 'task_content', $task['post']) ; ?>	</textarea>
		</div>

		<input type="submit" name="task_submit" value="Submit"/>
	</form>

</div>
</div>
</div>

</body>
</html>