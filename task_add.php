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
    
      <div style="padding:3px;"><a href="index.php">主頁</a> > 新增任務</div>

    <div class="task_add"> 
    
    <?php if($show_msg){ ?>
    	<div class="pass">Insert OK</div>
	<?php } ?>

	<?php if($error){ ?>
    	<div class="error"><?php echo $error ?></div>
    <?php } ?>
    
	<form action="task_add.php" method="post">

        <section>
			獎勵：<br/><input type="number" class="money" name="money" pattern="\d*" value="<?php P('money'); ?>"/>
		</section>
        
        <div>
       <input id="text1" readonly="readonly" type="number" style="height:28px;width:98%;outline:none;border:1px solid #1AB6FF;padding-left:3px;"/> <br />
     	</div>
  
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
</body>
</html>
<script>
var input1 = document.getElementById('text1');
       input1.onclick = function(){
         new KeyBoard(input1);
       };

;(function(exports){
  var KeyBoard = function(input, options){
    var body = document.getElementsByTagName('body')[0];
    var DIV_ID = options && options.divId || '__w_l_h_v_c_z_e_r_o_divid';
    
    if(document.getElementById(DIV_ID)){
      body.removeChild(document.getElementById(DIV_ID));
    }
    
    this.input = input;
    this.el = document.createElement('div');
    
    var self = this;
    var zIndex = options && options.zIndex || 1000;
    var width = options && options.width || '100%';
    var height = options && options.height || '193px';
    var fontSize = options && options.fontSize || '15px';
    var backgroundColor = options && options.backgroundColor || '#fff';
    var TABLE_ID = options && options.table_id || 'table_0909099';
    var mobile = typeof orientation !== 'undefined';
    
    this.el.id = DIV_ID;
    this.el.style.position = 'absolute';
    this.el.style.left = 0;
    this.el.style.right = 0;
    this.el.style.bottom = 0;
    this.el.style.zIndex = zIndex;
    this.el.style.width = width;
    this.el.style.height = height;
    this.el.style.backgroundColor = backgroundColor;
    
    //样式
    var cssStr = '<style type="text/css">';
    cssStr += '#' + TABLE_ID + '{text-align:center;width:100%;height:160px;border-top:1px solid #CECDCE;background-color:#FFF;}';
    cssStr += '#' + TABLE_ID + ' td{width:33%;border:1px solid #ddd;border-right:0;border-top:0;}';
    if(!mobile){
      cssStr += '#' + TABLE_ID + ' td:hover{background-color:#1FB9FF;color:#FFF;}';
    }
    cssStr += '</style>';
    
    //Button
    var btnStr = '<div style="width:60px;height:28px;background-color:#1FB9FF;';
    btnStr += 'float:right;margin-right:5px;text-align:center;color:#fff;';
    btnStr += 'line-height:28px;border-radius:3px;margin-bottom:5px;cursor:pointer;">完成</div>';
    
    //table
    var tableStr = '<table id="' + TABLE_ID + '" border="0" cellspacing="0" cellpadding="0">';
      tableStr += '<tr><td>1</td><td>2</td><td>3</td></tr>';
      tableStr += '<tr><td>4</td><td>5</td><td>6</td></tr>';
      tableStr += '<tr><td>7</td><td>8</td><td>9</td></tr>';
      tableStr += '<tr><td style="background-color:#D3D9DF;">.</td><td>0</td>';
      tableStr += '<td style="background-color:#D3D9DF;">删除</td></tr>';
      tableStr += '</table>';
    this.el.innerHTML = cssStr + btnStr + tableStr;
    
    function addEvent(e){
      var ev = e || window.event;
      var clickEl = ev.element || ev.target;
      var value = clickEl.textContent || clickEl.innerText;
      if(clickEl.tagName.toLocaleLowerCase() === 'td' && value !== "删除"){
        if(self.input){
          self.input.value += value;
        }
      }else if(clickEl.tagName.toLocaleLowerCase() === 'div' && value === "完成"){
        body.removeChild(self.el);
      }else if(clickEl.tagName.toLocaleLowerCase() === 'td' && value === "删除"){
        var num = self.input.value;
        if(num){
          var newNum = num.substr(0, num.length - 1);
          self.input.value = newNum;
        }
      }
    }
    
    if(mobile){
      this.el.ontouchstart = addEvent;
    }else{
      this.el.onclick = addEvent;
    }
    body.appendChild(this.el);
  }
  
  exports.KeyBoard = KeyBoard;

})(window);
</script>