<?php
$error = "";
$pass = "";
$login_error = "";
if( isset($_POST['login_submit']) ){
	/** set variables from post **/
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	/* validation */
	if( $username == ""):
	    $login_error = " "; 
	endif;
	
	if( $password == ""):
	    $login_error = " "; 
	endif;	
	
	$user = db_get_user($username,$password);
	if(!$login_error){
	if( !$user ){
		$login_error = "使用者或密碼不符合";
	}
	}
	/* insert into db if no error */
	if($login_error =="" && $user ){		
		$dbh = my_pdo();
		$sth = $dbh->prepare('UPDATE `users` SET `last_sctivity` = now() WHERE userid = :userid');
		$sth->bindParam(":userid", $user['userid']);
		$sth->execute();
		$_SESSION['username'] = $user['username'];
		$_SESSION['useremail'] = $user['email'];
		$_SESSION['uid'] = $user['userid'];
		$_SESSION['ucover'] = $user['cover_photo'];
		$_SESSION['uphoto'] = $user['photo'];
		header('Location: ' . $_SERVER['HTTP_REFERER']);	
	}
}

function check_validation($ans){
  return $_SESSION['ans'] == $ans;
}


function set_validation($a,$b){
  $o = rand(0,1);
  if($o==0){
    $operator = "+";
    $_SESSION['ans']=$a+$b;
  }
  if($o==1){
    $operator = "*";
    $_SESSION['ans']=$a*$b;
  }
  return $operator;
}

if( isset($_POST['reg_submit']) ){
	/** set variables from post **/
	$reg_username = trim($_POST['reg_username']);
	$reg_password = trim($_POST['reg_password']);
	$tel = trim($_POST['tel']);
	$email = trim($_POST['email']);
	$code = $_POST['code'];

	/* validation */
	if( $reg_username =="" ){
		$error .= " ";
	}elseif( $reg_username == "admin" or $reg_username == "teacher" or $reg_username == "student" ){
		$error .= "<li>使用者名稱不能使用</li>";
	}elseif( db_record_exists('users','username',$reg_username) ){
		$error .= "<li>使用者名稱已有人使用</li>";
	}
	if( $email =="" ){
		$error .= " ";
	}elseif( db_record_exists('users','email',$email) ){
		$error .= "<li>電郵已有人使用</li>";
	}else if( strpos($email,"@") === false ){
		$error .= "<li>不正確的電郵</li>";
	}
	
	if( $reg_password =="" ){
		$error .= " ";
	}
	if( $tel =="" ){
		$error .= " ";
	}
	
	if( !(is_numeric($tel)) || strlen($tel) <= 7){
		$error .= "<li>不正確的電話</li>";
	}
	

	  if( check_validation( $code) ){
     $error .= "";
  }else{
     $error .= "<li>驗証碼錯誤</li>";
  }
	/* insert into db if no error */
	if($error ==""){
		$dbh = my_pdo();
		$photo = "users/photos/icons/none.png";
		$cover_photo = "users/photos/cover/nonecover.png";
		$sth = $dbh->prepare("INSERT INTO users(username,password,tel,email,photo,cover_photo) 	
								 VALUES(:username,:password,:tel,:email,:photo,:cover_photo) ");
		$sth->bindParam(":username", $reg_username );
		$sth->bindParam(":password", $reg_password );
		$sth->bindParam(":tel", $tel );
		$sth->bindParam(":email", $email );
		$sth->bindParam(":photo", $photo);
		$sth->bindParam(":cover_photo", $cover_photo);
		$rtn = $sth->execute();
		if($rtn){
			  $user = db_get_user($reg_username,$reg_password);			  
			  $_SESSION['username'] = $user['username'];
			  $_SESSION['useremail'] = $user['email'];
			  $_SESSION['uid'] = $user['userid'];
			  $_SESSION['uphoto'] = $user['photo'];	
			  header('Location:index.php');			  		  
		}else{
			$error = "DB error";
			var_dump($sth->errorInfo());
		}
	}
}
$a = rand(0,9);
$b = rand(0,9);
$operator = set_validation($a,$b);
?>
<body class="">
<div class="gridContainer clearfix">
  <div id="headerbgshow"></div>
  <div id="header">

  	  <div class="login_content">
      <?php if ( !has_session() ){?>
    <div class="login_page">

    <div style="clear:both;" ></div>
    	<h1>登入</h1>

		<form action="login.php" method="post">
				<p>
                <label for="username2"><i class="icon-user"></i></label>
				<input type="text"  placeholder="帳號" id="username2" name="username" value="<?php P('username'); ?>" <?php if( isset($username) && $username =="" ): ?> style="border:2px #E95431 solid;" <?php endif; ?>/>
                </p>
				<p>
                <label for="password2"><i class="icon-key"></i></label>
				<input type="password" placeholder="密碼" id="password2" name="password" value="<?php P('password'); ?>" <?php if( isset($password) && $password =="" ): ?> style="border:2px #E95431 solid;" <?php endif; ?>/>
                </p>
                <p style="color:#FF6248; font-weight:bold;"><?php if($login_error): ?><?php echo "*請修改錯誤處".$login_error; ?><?php endif; ?></p>
                <p><input class="login_sub" type="submit" name="login_submit" value="登入"/></p>
		</form>
     
    </div>
    
    <div class="reg_page">

    <div style="clear:both;"></div>
	<form action=" login.php" method="post">
          <h1>註冊</h1>
          <p>
			<label for="reg_username"><i class="icon-user"></i></label>
			<input type="text" placeholder="帳號" id="reg_username" name="reg_username" value="<?php P('reg_username'); ?>" <?php if( isset($reg_username) && $reg_username =="" ): ?> style="border:2px #E95431 solid;" <?php endif; ?>/>
          </p>
          
          <p>  
			<label for="reg_password"><i class="icon-key"></i></label>
			<input type="password" placeholder="密碼" id="reg_password" name="reg_password" value="<?php P('reg_password'); ?>" <?php if( isset($reg_password) && $reg_password =="" ): ?> style="border:2px #E95431 solid;" <?php endif; ?>/>
          </p>
          
          <p> 
			<label for="email"><i class="icon-envelope"></i></label>
			<input type="text" placeholder="電郵" id="email" name="email" value="<?php P('email'); ?>" <?php if( isset($email) && $email =="" ): ?> style="border:2px #E95431 solid;" <?php endif; ?>/>
          </p>
          
          <p>
			<label for="tel"><i class="icon-phone"></i></label>
			<input type="text" placeholder="電話" id="tel" name="tel" value="<?php P('tel'); ?>" <?php if( isset($tel) && $tel =="" ): ?> style="border:2px #E95431 solid;" <?php endif; ?>/>
          </p>

          <p>
			<label for="code"></label>
            <input type="text" placeholder="驗證碼： <?php echo $a ?> <?php echo $operator ?> <?php echo $b ?> 等於？" name="code" id="code" value=""/>
          </p>
          
           <p style="">
           <?php if($error): ?>
           <ul class="login_page_error">
		   <?php echo $error; ?>
           </ul> 
           <div style="clear:both;"></div><?php endif; ?>
           </p>

          
		<input class="login_sub" type="submit"  name="reg_submit" value="註冊"/>
	</form>
    </div>   
 <?php } ?>      
</div>
</div>

  </div>   
  </div>
  

</div>
</body>
</html>
