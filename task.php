<html>
<?php 
require_once ("func.php");

$dbh = my_pdo();
$sth = $dbh->query("SELECT * FROM `task` LIMIT 0 , 3");
$sth->execute();
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="sceen.css" rel="stylesheet" type="text/css" />
<title>任務</title>
</head>

<body>

 <div class="newslist">
      <ul>
        <?php 
        while($row = $sth->fetch() ){?>
         <li>
        <span class="title"><?php echo $row['title'] ?></span>
       <p><?php echo $row['post'] ?></p>
        </li>
        <?php }?>   
      </ul>
      </div>

</body>
</html>