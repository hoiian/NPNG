<html xmlns="http://www.w3.org/1999/xhtml">
<link href="sceen.css" rel="stylesheet" type="text/css" />
<?php 
require_once ("func.php");
$error = "";
$pass = "";
if( isset($_POST['reg_submit']) ){
	/** set variables from post **/
	$userid = trim($_POST['userid']);
	$password = trim($_POST['password']);
	$role = trim($_POST['role']);
	$name = trim($_POST['name']);
	$matchuser = trim($_POST['matchuser']);

	/* validation */
	if( $userid =="" ){
		$error .= "帳號不能留空<br/>";
	}elseif( db_record_exists('users','userid',$userid) ){
		$error .= "帳號已有人使用<br/>";
	}elseif( strlen($userid)!=10 || !is_numeric($userid) ){
		$error .= "這不是電話號碼喔<br/>";
	}elseif( !startsWith($userid, '09') ){
		$error .= "這不是09開頭的電話號碼喔<br/>";
	}
	
	if( $name =="" ){
		$error .= "名字不能留空<br/>";
	}
	
	if( $password =="" ){
		$error .= "密碼不能留空<br/>";
	}elseif(strlen($password) <8){
		$error .= "密碼長度至少為8<br/>";	
	}


	if( $role !="parent" && $role != "child" ){
		$error .= "身份不能留空<br/>";
	}
	
		if( $matchuser =="" ){
		$error .= "配對者不能留空<br/>";
	}elseif( !db_record_exists('users','userid',$matchuser) || $matchuser !="00" ){
		$error .= "沒有該配對者<br/>";
	}
	
/*		 insert into db if no error */
	if($error ==""){
		$dbh = my_pdo();
		$sth = $dbh->prepare("INSERT INTO member(userid,password,name,role,matchuser) 	
								 VALUES(:userid,:password,:name,:role,:matchuser) ");
		$sth->bindParam(":userid", $userid );
		$sth->bindParam(":password", $password );
		$sth->bindParam(":name", $name );
		$sth->bindParam(":role", $role );
		$sth->bindParam(":matchuser", $matchuser );
		$rtn = $sth->execute();
		if($rtn){
			$pass = "註冊成功";
			unset($_POST);	
		}else{
			$error = "DB error";
			var_dump($sth->errorInfo());
		}
	}
}

?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>註冊</title>

</head>

<body>


<div>
  <div class="content">

    <div class="words">
      <div style="padding:3px;"><a href="index.php">主頁</a> > 註冊</div>
    </div>
    <div class="passage" style=" width:910px; float:left; height:700px" >
    <span class="title">註冊</span>
    <div class="news_edit"> 
    <?php if($pass){ ?>
     	<div class="pass"><?php echo $pass ?></div>	 
    <?php } ?>
    
	<?php if($error){ ?>
    	<div class="error"><?php echo $error ?></div>
    <?php } ?>
    
	<form action="reg_add.php" method="post">
		<div class="form_row">
			<label for="userid">帳號：(手機號碼)</label>
			<input type="text" id="userid" name="userid" value="<?php P('userid'); ?>"/>
		</div>
		<div class="form_row">
			<label for="password">密碼：</label>
			<input type="password" id="password" name="password" value="<?php P('password'); ?>"/>
		</div>
		<div class="form_row">
			<label for="email">名字：</label>
			<input type="text" id="name" name="name" value="<?php P('name'); ?>"/>
		</div>
	<div class="form_row">
			<label for="tel">配對者帳號：(對方還沒有帳號請先輸入00)</label>
			<input type="text" id="matchuser" name="matchuser" value="<?php P('matchuser'); ?>"/>
		</div>
		<div class="form_row">
			<label for="role">身份：</label>
			<select name="role" id="role">
				<option value=""<?php if(isset($_POST['role'])&& $_POST['role']=='') echo ' selected';?>>--請選擇身份--</option>
				<option value="parent"<?php if(isset($_POST['role']) && $_POST['role']=='parent') echo ' selected';?>>父母</option>
				<option value="child"<?php if(isset($_POST['role']) && $_POST['role']=='child') echo ' selected';?>>小孩</option>
			</select>
		</div>
		<input type="submit" name="reg_submit" value="Submit"/>
	</form>
  </div>
</div>
</div>
</div>


</body>
</html>