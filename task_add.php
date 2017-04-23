<html>
<?php 
require_once ("func.php");

require_role('parent');

$show_msg = isset($_GET['msg']) && $_GET['msg'] =='insert_ok';
$error = "";
if( isset($_POST['task_submit']) ){
	$created_at = trim($_POST['task_created_at']);
	$title = trim($_POST['task_title']);
	$content = trim($_POST['task_content']);
	$deadline = trim($_POST['task_deadline']);
	
	if( $created_at =="" ){
		$error = "日期不能留空<br/>";
	}
	if( $deadline =="" ){
		$error = "到期日期不能留空<br/>";
	}
	if( $title =="" ){
		$error = "標題不能留空<br/>";
	}
	if( $content =="" ){
		$error .= "內容不能留空<br/>";
	}
	if($error ==""){
		$dbh = my_pdo();
		$sth = $dbh->prepare(" INSERT INTO task (title,post,created_at,deadline) 	
								 VALUES(:title,:content,:created_at,:deadline) ");
		$sth->bindParam(":title", $title );
		$sth->bindParam(":content", $content );
		$sth->bindParam(":created_at", $created_at );
		$sth->bindParam(":deadline", $deadline );
		$rtn = $sth->execute();
		if($rtn){
			header("Location: task_add.php?msg=insert_ok");
			unset($_POST);	
		}else{
			var_dump($sth->errorInfo());
			$error = "DB error";
		}
	}
}

?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新增任務</title>
</head>

<body>

<div>
  <div class="content">
    <div class="main">
      <div class="words">
      <div style="padding:3px;"><a href="index.php">主頁</a> > 新增任務</div>
    </div>

    <div class="task_edit"> 
    
    <?php if($show_msg){ ?>
    	<div class="pass">Insert OK</div>
	<?php } ?>

	<?php if($error){ ?>
    	<div class="error"><?php echo $error ?></div>
    <?php } ?>
	<form action="task_add.php" method="post">
    	<div class="form_row">
			日期：<br/><input type="date" class="t" name="task_created_at" value="<?php P('task_created_at'); ?>"/>
		</div>
            <div class="form_row">
			到期日期：<br/><input type="date" class="t" name="task_deadline" value="<?php P('task_created_at'); ?>"/>
		</div>
		<div class="form_row">
			標題：<br/><input type="text" class="t" name="task_title" value="<?php P('task_title'); ?>"/>
		</div>
		<div class="form_row">
			內容：<br/><textarea name="task_content"><?php P('task_content'); ?>	</textarea>
		</div>
      
		<input type="submit" name="task_submit" value="Submit"/>
	</form>
  </div>

</div>
</div>

</body>
</html>