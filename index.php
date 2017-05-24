<html>
<?php
require_once ("func.php");
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1; user-scalable=0;">
<link href="css/sceen.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<title>急速家事</title>
<link rel="icon" href="img/icon.ico" />
</head>

<body>
<?php
$error = "";
$pass = "";
if( isset($_POST['login_submit']) ){
  /** set variables from post **/
  $userid = trim($_POST['userid']);
  $password = trim($_POST['password']);

  /* validation */
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
	$_SESSION['savemoney'] = $user['savemoney'];
	$_SESSION['group'] = $user['group'];
	$_SESSION['score'] = $user['score'];
    $pass="成功登入，歡迎！";
  }
}
?>

<?php if( !has_session() ): ?>
	<div class="login">
        <div>
            <div class="logo"><img name="logo" src="img/img_signup_appicon.png" height="180px" width="180px" alt="logo"></div>
            <img name="invalid_name" src="img/invalid_name.png" alt="title name">
        </div>
    
		<?php if(!$pass){ ?>
        <?php if($error){ ?>
            <div class="error"><?php echo $error ?></div>
        <?php } ?>
        
		<form action="index.php" method="post">
              <div class="form_group">
                <input type="text" class="text" id="userid" name="userid" value="<?php P('userid');?>" placeholder="帳號"  <?php if( isset($userid) && $userid =="" ): ?> style="border:2px #fba415 solid;" <?php endif; ?>/>
              </div>
              
              <div class="form_group">
                <input type="password" class="text" id="password" name="password" placeholder="密碼"  <?php if( isset($password) && $password =="" ): ?> style="border:2px #fba415 solid;" <?php endif; ?>/>
              </div>
        
              <input type="submit" class="btn btn-primary" name="login_submit" value="登入"/>
        
              <a href="reg_add.php"><input type="button"  class="button" value="註冊" ></a>
		</form>
     </div>
      <?php } ?>
      
      <!------------------登入後跳到task_list----------------------->
      <?php else: 
	  		header('Location: bank.php');
	  ?>
      
   
<?php endif ;?>

</body>
</html>
