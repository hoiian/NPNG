<html>
<?php 
require_once ("func.php");

require_role('parent');

$show_msg = isset($_GET['msg']) && $_GET['msg'] =='insert_ok';
$error = "";
if( isset($_POST['task_submit']) ){
	$money = trim($_POST['money']);
	$type = trim($_POST['type']);
	$title = "";
	
	switch($type){
	case a: $title = "澆花"; break;
	case b: $title = "整理花圃"; break;
	case c: $title = "洗車"; break;
	case d: $title = "買飲料"; break;
	case e: $title = "整理房間"; break;
	case f: $title = "刷油漆"; break;
	case g: $title = "倒茶"; break;
	case h: $title = "整理桌面"; break;
	case i: $title = "買食物"; break;
	case j: $title = "整理餐廳"; break;
	case k: $title = "照顧寶寶"; break;
	case l: $title = "運動"; break;
	
	}

	if( $money =="" ){
		$error .= "獎勵不能留空<br/>";
	}
	
	if($error ==""){
		$dbh = my_pdo();
		$sth = $dbh->prepare(" INSERT INTO task (money,type,title) 	
								 VALUES(:money,:type,:title)");
		$sth->bindParam(":money", $money );
		$sth->bindParam(":type", $type );
		$sth->bindParam(":title", $title );
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
<link href="css/screen_task_add.css" rel="stylesheet" type="text/css" />

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

        <section>
			獎勵：<br/><input type="text" class="money" name="money" value="<?php P('money'); ?>"/>
		</section>
  
        <section class="tasktype">
		<input type="radio" name="type" id="a" value="a">
        <label class="a" for="a">澆花</label>
        
		<input type="radio" name="type" id="b" value="b">
        <label class="b" for="b">整理花圃</label>
        
		<input type="radio" name="type" id="c" value="c">
        <label class="c" for="c">洗車</label>

		<input type="radio" name="type" id="d" value="d">
        <label class="d" for="d">買飲料</label>
        <!----------------------->
		<input type="radio" name="type" id="e" value="e">
        <label class="e" for="e">整理房間</label>
        
		<input type="radio" name="type" id="f" value="f">
        <label class="f" for="f">刷油漆</label>
        
		<input type="radio" name="type" id="g" value="g">
        <label class="g" for="g">倒茶</label>
        
		<input type="radio" name="type" id="h" value="h">
        <label class="h" for="h">整理桌面</label>
        
		<input type="radio" name="type" id="i" value="i">
        <label class="i" for="i">買食物</label>
        
		<input type="radio" name="type" id="j" value="j">
        <label class="j" for="j">整理餐廳</label>
        
		<input type="radio" name="type" id="k" value="k">
        <label class="k" for="k">照顧寶寶</label>
        
		<input type="radio" name="type" id="l" value="l">
        <label class="l" for="l">運動</label>

		</section>
      
		<input type="submit" name="task_submit" value="Submit"/>
	</form>
  </div>

</div>
</div>

</body>
</html>