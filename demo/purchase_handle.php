<?php 
  $title="订单处理";
  include 'head.php';
?>

<?php 
  require_once('conn.php');
  $cid = $_POST['cid'];
  $eid = $_POST['eid'];
  $pid = $_POST['pid'];
  $qty = $_POST['qty'];
  
  $errors = [];
  if(empty($qty)) $errors[] = "请输入购买数目！";
  else{
      //先判断购买数目是否高于库存
      $sql1 = "select qoh from products where pid = $pid";
      // $sql1 = "call get_product_qty($pid)";
      $query1 = mysql_query($sql1) or die(mysql_error());
      if($query1 && mysql_num_rows($query1)){
        $qoh_e = mysql_fetch_assoc($query1);
        $qoh = $qoh_e['qoh'];
        if($qoh<=$qty){
            $errors[] = "库存量少于购买数量！请重新输入";
        }else{
            $sql = "call add_purchase($cid,$eid,$pid,$qty);";
            $query = mysql_query($sql) or die(mysql_error());
            if(gettype($query) == 'resource'){
                $back = true; //有返回值，即库存进行了翻倍操作
                if($query&&mysql_num_rows($query)){
                  while($row = mysql_fetch_assoc($query)){
                    $data[] = $row;
                  }
                }
                $old_qoh = $data[0]['old_qoh'];
                $increased = $data[0]['old_plus_sold'];
                //if(isset($data)) var_dump($data);
            }else if(gettype($query) == 'boolean'){
              $back = false;  //没有返回值，即库存没有翻倍操作
            }
        }
      }
  }
  
?>
  <ol class="breadcrumb">
    <li><a>订单</a></li>
    <li><a>处理结果</a></li>
  </ol>

  <div class="row-fluid">

		<div class="col-md-9">
      <?php 
        if(!empty($errors)){
          echo '<div class="alert alert-danger" role="alert">购买失败！</div>';
          foreach ($errors as $error) {
            echo '<p class="text-danger">'.$error.'</p>';   
          }
        }
        else{
          echo '<div class="alert alert-success" role="alert">购买成功！</div>';
          if($back){
            echo '<p class="text-info">交易后库存剩余量低于下限值，进行了库存翻倍操作</p>';
            echo '<p class="text-info">原有库存：'.$old_qoh.'</p>';
            echo '<p class="text-info">库存增加数目：'.$increased.'</p>';
          }
        }
       ?>
    <a href="index.php" >[ 返回首页 ]</a>
		</div>
		<div class="col-md-3">
			
		</div>
	</div>

<?php include 'footer.php'; ?>
