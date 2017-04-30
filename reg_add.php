<html>
<meta name="viewport" content="width=device-width; initial-scale=0.3; maximum-scale=0.3; user-scalable=0;">
<link href="css/screen_reg_add.css" rel="stylesheet" type="text/css" />
<?php
require_once ("func.php");
$error = "";
$pass = "";
if( isset($_POST['reg_submit']) ){
	/** set variables from post **/
	$userid = trim($_POST['userid']);
	$password = trim($_POST['password']);
	$password1 = trim($_POST['password1']);
	$role = trim($_POST['role']);
	$name = trim($_POST['name']);
	$matchuser = trim($_POST['matchuser']);
	/* validation */
	if( $userid =="" ){
		$error .= "帳號不能留空<br/>";
	}elseif( db_record_exists('users','userid',$userid) ){
		$error .= "帳號已有人使用<br/>";
	}elseif( strlen($userid)!=10 || !is_numeric($userid) ){
		$error .= "這不是正確的電話號碼喔<br/>";
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
	}elseif($password != $password1){
		$error .= "兩次密碼不一樣<br/>";
	}
	if( $role !="parent" && $role != "child" ){
		$error .= "身份不能留空<br/>";
	}
		if( $matchuser =="" ){
		$error .= "配對者不能留空<br/>";
	}elseif( !db_record_exists('users','userid',$matchuser) && $matchuser !="00" ){
		$error .= "沒有該配對者<br/>";
	}
		if( empty($_FILES['file']['name']) ){
		$profilepic = "Profilepic/default_icon.png";
	}else{
		/* insert into db if no error */
		$target_path = "Profilepic/";
		$target_path = $target_path . basename($_FILES['file']['name']);
//		echo  basename($_FILES['file']['tmp_name']);
		if( move_uploaded_file($_FILES['file']['tmp_name'], $target_path) ) {
		//    $pass = "file uploded";
			$profilepic = $target_path;
		} else{
		    $error .= "file move fail";
		}
	}
/*		 insert into db if no error */
	if($error ==""){
		$dbh = my_pdo();
		$sth = $dbh->prepare("INSERT INTO member(userid,password,name,role,matchuser,profilepic)
										 VALUES(:userid,:password,:name,:role,:matchuser,:profilepic) ");
		$sth->bindParam(":userid", $userid );
		$sth->bindParam(":password", $password );
		$sth->bindParam(":name", $name );
		$sth->bindParam(":role", $role );
		$sth->bindParam(":matchuser", $matchuser );
		$sth->bindParam(":profilepic", $profilepic );
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
    </div>
    <div class="passage">
		<div class="header">
    	<h1 class="title">急速家事新會員註冊</h1>
			<div class="return">
			<a href="index.php"><img src="img/arrow.png" alt="back" border="0"></a>
		 </div>
		</div>
    <div class="news_edit">
    <?php if($pass){ ?>
     	<div class="pass"><?php echo $pass ?></div>
    <?php } ?>

	<?php if($error){ ?>
    	<div class="error"><?php echo $error ?></div>
    <?php } ?>

	<form enctype="multipart/form-data" action="reg_add.php" method="post">
		<div class="form_row">
			<label for="userid">帳號：</label>
			<input type="text" id="userid" name="userid" value="<?php P('userid'); ?>" placeholder="手機號碼"/>
		</div>
		<div class="form_row">
			<label for="password">密碼：</label>
			<input type="password" id="password" name="password" value="<?php P('password'); ?>"/>
		</div>
        <div class="form_row">
			<label for="password1">確認密碼：</label>
			<input type="password" id="password1" name="password1" value="<?php P('password1'); ?>"/>
		</div>
		<div class="form_row">
			<label for="name">名字：</label>
			<input type="text" id="name" name="name" value="<?php P('name'); ?>"/>
		</div>

		<div class="form_row">
			<label for="matchuser">配對者帳號：</label>
			<input placeholder="對方還沒有帳號請先輸入00" type="text" id="matchuser" name="matchuser" value="<?php P('matchuser'); ?>"/>
		</div>

		<div class="form_row role">
			<label for="role">身份：</label> <br/>
            <input type="radio" name="role" id="parent" value="parent"
						<?php  if( isset($_POST['role']) && $_POST['role'] == "parent") echo "checked";?>>
						<label for="parent" style="font-size: 60px; display:inline;">父母</label>
                        
            <input type="radio" name="role" id="child" value="child" style="border-style:none;font-size:60px;"
            <?php  if( isset($_POST['role']) && $_POST['role'] == "child") echo "checked";?>>
						<label for="child" style="font-size: 60px; display:inline;">小孩</label>
		</div>

    <div class="form_row">
			<label for="profilepic">頭貼：</label>
      <input type="file" accept="image/*" capture="camera" id="file" name="file"/>
    </div>
	<div class="submit">
		<input type="submit" name="reg_submit" value="Submit"/>
	</div>
	</form>
  </div>
</div>
</div>
</div>


</body>
</html>