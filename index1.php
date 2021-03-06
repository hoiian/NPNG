<html>
<?php 
require_once ("func.php");

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="sceen.css" rel="stylesheet" type="text/css" />
<link href="bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="cover.css" rel="stylesheet">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>NPNG</title>
</head>

<body>
<div class="login">
<?php

$error = "";
$pass = "";
if( isset($_POST['login_submit']) ){
  /** set variables from post **/
  $userid = trim($_POST['userid']);
  $password = trim($_POST['password']);
 
  /* validation */
  if( $userid =="" ){
    $error .= "使用者名稱不能留空<br/>";
  }
  if( $password =="" ){
    $error .= "密碼不能留空<br/>";
  }
 
  $user = db_get_user($userid,$password);
  if( !$user ){
    $error .= "抱歉，使用者或密碼錯誤<br/>";
  }
  /* insert into db if no error */
  if(!$error && $user ){
    $_SESSION['role'] = $user['role'];
    $_SESSION['userid'] = $user['userid'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['matchuser'] = $user['matchuser'];
	$_SESSION['id'] = $user['id'];
	$_SESSION['profilepic'] = $user['profilepic'];
    $pass="成功登入，歡迎！";
  }
}
?>
 
<?php if( !has_session() ): ?>
    <?php if(!$pass){ ?>
    <?php if($error){ ?>
        <div class="error"><?php echo $error ?></div>
      <?php } ?>
    <form action="index.php" method="post">
      <div class="form_group">
        <label for="userid">帳號：(手機號碼)</label><br/>
        <input type="text" class="text" id="userid" name="userid" value="<?php P('userid'); ?>"/>
      </div>
      <div class="form_group">
        <label for="password">密碼：</label><br/>
        <input type="password" class="text" id="password" name="password" value="<?php P('password'); ?>"/>
      </div>
       
      <input type="submit" class="button" name="login_submit" value="Submit"/>
    
      <a href="reg_add.php"><input class="button" value="註冊"></a>
      </form>
      <?php } ?>
      <?php else: ?>
        <?php if($pass){ ?><div class="pass"> <?php echo $pass;?> </div><?php } ?>
 
  <div class="profile">
	<img src="<?php echo $_SESSION['profilepic'];?>" width="80" height="80" alt="profilepic">
Hello,
<?php echo $_SESSION['name'];
	if( $_SESSION['role'] == "child"){
		echo "小朋友<br/>";
	}
	if( $_SESSION['role'] == "parent"){
		echo "爸爸/媽媽<br/>";
	}
?>
	<a href="reg_edit.php?id=<?php echo $_SESSION['id'];?>" class="button" align="center">編輯</a>
	<a href="logout.php" class="button" align="center">登出</a>
</div>
     <?php if( has_role('child') ): ?>
    <!--   <a href="student_add.php?>" class="ed" >[任務]</a>-->
    <?php endif; ?>
    
    <div class="task">
	<?php include("task_list.php"); ?>
    </div>
 
  
<?php endif ;?>
</body>
</html>