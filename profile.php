<html>
<?php 
require_once("func.php");
require_role('parent');
require_role('child');
$dbh = my_pdo();
//$sth = $dbh->prepare(" SELECT * FROM member WHERE id=:id ");
//$sth->bindParam(":id", $_SESSION['id'] );
//$sth->execute();
//$member = $sth->fetch();

$matuid = $_SESSION['matchuser'];
$sth1 = $dbh->query("SELECT * FROM `member` WHERE userid='$matuid'");
$sth1->execute();
$match = $sth1->fetch();
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>任務</title>
<link href="css/sceen.css" rel="stylesheet" type="text/css" />
<?php if( has_role('child') ): ?>
<link href="css/child.css" rel="stylesheet" type="text/css" />
<?php endif; ?>
</head>

<body>
<div class="afterlogin">

	<div class="header">
        <div class="title">
            <p>設定</p>
            <a href="index.php">首頁</a>
        </div>
	</div>
       
        <div class="profile" style="margin-top:20%;">
			<img src="<?php echo $_SESSION['profilepic'];?>" width="80" height="auto" alt="profilepic">
            Hello,
            <?php echo $_SESSION['name'];
                if( $_SESSION['role'] == "child"){
                    echo "小朋友<br/>";
                }
                if( $_SESSION['role'] == "parent"){
                    echo "爸爸/媽媽<br/>";
                }
				
				if( $match == "00") echo "你還沒配對喔";
				else echo "配對者是".$match['name'];
				
            ?>
            
            <img src="<?php echo $match['profilepic'];?>" width="80" height="auto" alt="profilepic_matchuser">
            
            <a href="reg_edit.php?id=<?php echo $_SESSION['id'];?>" class="button" align="center">編輯</a>
            <a href="logout.php" class="button" align="center">登出</a>
		</div>


</div> <!--afterlogin-->

</body>
</html>