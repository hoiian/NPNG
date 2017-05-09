<html>
<?php 
require_once("func.php");
require_role('parent');
require_role('child');
$dbh = my_pdo();
$sth = $dbh->prepare(" SELECT * FROM member WHERE id=:id ");
$sth->bindParam(":id", $_SESSION['id'] );
$sth->execute();
$member = $sth->fetch();

$matuid = $_SESSION['matchuser'];
$sth1 = $dbh->query("SELECT * FROM `member` WHERE userid='$matuid'");
$sth1->execute();
$match = $sth1->fetch();



$error = "";
$pass = "";
if( isset($_POST['edit_submit']) ){
	/** set variables from post **/
	$userid = trim($_POST['userid']);
	$password = trim($_POST['password']);
//	$password1 = trim($_POST['password1']);
	$role = trim($_POST['role']);
	$name = trim($_POST['name']);
	$matchuser = trim($_POST['matchuser']);

	/* validation */
	if( $userid =="" ){
		$error .= "帳號不能留空<br/>";
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
	}elseif( !db_record_exists('users','userid',$matchuser) && $matchuser !="00" ){
		$error .= "沒有該配對者<br/>";
	}
	
/*		 insert into db if no error */
	if($error ==""){
		$dbh = my_pdo();
		$sth = $dbh->prepare(" UPDATE member SET userid=:userid, password=:password,name=:name,role=:role,matchuser=:matchuser
								WHERE id=:id ");
		$sth->bindParam(":userid", $userid );
		$sth->bindParam(":password", $password );
		$sth->bindParam(":name", $name );
		$sth->bindParam(":role", $role );
		$sth->bindParam(":matchuser", $matchuser );
		$sth->bindParam(":id", $member['id'] );
		$rtn = $sth->execute();
		if($rtn){
			$pass = "編輯成功";
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
<title>會員設定</title>
<link href="css/sceen.css" rel="stylesheet" type="text/css" />
<link href="css/screen_profile.css" rel="stylesheet" type="text/css" />
<?php if( has_role('child') ): ?>
<link href="css/child.css" rel="stylesheet" type="text/css" />
<?php endif; ?>
</head>

<body>
<div class="afterlogin">

	<div class="header">
        <div class="title">
            <p>會員設定</p>
            <a href="index.php" class="home"></a>
            <a href="#" class="edit"></a>
            <a href="logout.php" class="logout"></a>
        </div>
	</div>
       
        <div class="profile">
        	<div class="bg">
                <div class="icon"><img src="<?php echo $_SESSION['profilepic'];?>" alt="profilepic"></div>
                <span> <?php echo $_SESSION['name'];?></span>
            </div>

            <div class="profile_form">
            <form enctype="multipart/form-data" action="profile.php" method="post">
		<div class="form_row">
			<label for="userid">帳號：</label>
			<input type="text" id="userid" name="userid" value="<?php P('userid',$member['userid']); ?>" placeholder="手機號碼"/>
		</div>
		<div class="form_row">
			<label for="password">密碼：</label>
			<input type="password" id="password" name="password" value="<?php P('password'); ?>"/>
		</div>

		<div class="form_row">
			<label for="name">名字：</label>
			<input type="text" id="name" name="name" value="<?php P('name',$member['name']); ?>"/>
		</div>

		<div class="form_row">
			<label for="matchuser">配對者帳號：</label>
			<input placeholder="對方還沒有帳號請先輸入00" type="text" id="matchuser" name="matchuser" value="<?php P('matchuser',$member['matchuser']); ?>"/>
		</div>

       <div class="form_row role">
			<label for="role">身份：</label> <br/>
            <input type="radio" name="role" id="parent" value="parent"
						<?php  if( $member['role'] == "parent") echo "checked";?>>
                       
						<label for="parent" style="display:inline;">父母</label>
                        
            <input type="radio" name="role" id="child" value="child"
            <?php  if( $member['role'] == "child") echo "checked";?>>
						<label for="child" style="display:inline;">小孩</label>
		</div>

    <div class="form_row">
			<label for="profilepic">頭貼：</label>
      <input type="file" accept="image/*" capture="camera" id="file" name="file"/>
    </div>
	<div class="submit">
		<input type="submit" name="edit_submit" value="確認送出"/>
	</div>
	</form>
            </div>
		</div>


</div> <!--afterlogin-->

</body>
</html>