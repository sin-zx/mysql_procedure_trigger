<?php 
	$title="添加商品交易信息";
	include 'head.php';
?>
<?php 
  require_once('conn.php');
  $pid = $_GET['pid'];
  $sql2 = "select * from customers";
  $query2 = mysql_query($sql2) or die(mysql_error());
  if($query2 && @mysql_num_rows($query2)){
    while($row = mysql_fetch_assoc($query2)){
      $customers[] = $row;
    }
  }

  $sql3 = "select * from employees";
  $query3 = mysql_query($sql3) or die(mysql_error());
  if($query3&&mysql_num_rows($query3)){
    while($row = mysql_fetch_assoc($query3)){
      $employees[] = $row;
    }
  }
  $sql1 = "call find_product($pid);";
  $query1 = mysql_query($sql1) or die(mysql_error());
  if($query1&&mysql_num_rows($query1)){
  	while($row = mysql_fetch_assoc($query1)){
      $products[] = $row;
    }
	$product = $products[0];
    $pname = $product['pname'];
    $imgname = $product['imgname'];
    $imgname = $imgname? $imgname : 'no-image.png'; //是否有图片
  }
?>

	<ol class="breadcrumb">
		<li>商品</li>
		<li>购买</li>
		<li><a><?php echo $pname; ?></a></li>
	</ol>
	<div class="row-fluid">
		<div class="col-md-2">
			<ul class="nav nav-pills  nav-stacked">
				<h4>
		          操作选择
		        </h4>
				<li>
					<a href="reportsale.php?pid=<?php echo $pid; ?>">月度报表</a>
				</li>
				<li>
					<a href="purchase.php?pid=<?php echo $pid; ?>">选择购买</a>
				</li>
				<li class="divider">
				</li>
				
			</ul>
		</div>

		<div class="col-md-7">
			<legend>购买清单</legend> 
			<h3>商品名称： <?php echo $pname; ?></h3>
			<h3>原价： <?php echo $product['original_price']; ?></h3>
			<h3>折扣： <?php echo $product['discnt_rate']; ?></h3>
			<h3>库存： <?php echo $product['qoh']; ?></h3>
			
			<form id="form1" class="form-inline"  method="post" action="purchase_handle.php">               
			  <input type="hidden" name="pid" value=<?php echo $pid; ?>>  
              <div class="form-group">     
					<label>操作员工(employee):</label>
					<?php 
					  if(!isset($employees)) echo "<h3>暂无员工，请先添加</h3>";
					  else{
					  	echo '<select name="eid" class="form-control">';
					    foreach ($employees as $employee) {
					?>
					
				        <option value="<?php echo $employee['eid']; ?>"><?php echo $employee['eid'].'.'.$employee['ename']; ?></option>
				    <?php 
				    	
				    	}
				    	echo "</select>";
					} 

				    ?>
			      	
			  </div>
			  <br>	
			  <div class="form-group">     
					<label>顾客(customer):</label>
					<?php 
					  if(!isset($customers)) echo "<h3>暂无顾客，请先添加</h3>";
					  else{
					  	echo '<select name="cid" class="form-control">';
					    foreach ($customers as $customer) {
					?>
					
				        <option value="<?php echo $customer['cid']; ?>"><?php echo $customer['cid'].'.'.$customer['cname']; ?></option>
				    <?php 
				    	
				    	}
				    	echo "</select>";
					} 

				    ?>
			  </div>
			  <div class="form-group">
				<label>购买数量</label>
				<input type="text" class="form-control" id="qty" name="qty" onkeyup="CountMoney(this.value,<?php echo $product['original_price'] * (1-$product['discnt_rate']); ?>)"/>
   			  </div>

			<h3>一共需付款：<span id="totalprice">0</span> 元</h3>	<!--实时显示总价格-->
	        <br>
	        <button class="btn btn-primary" id="submit1">提交</button>
			
		 </form>
		</div>
		<div class="col-md-3">
			<img src="img/<?php echo $imgname; ?>" alt="140x140" width="232" height="230" class="img-polaroid" />
		</div>
	</div>
<script type="text/javascript"> 
    function CountMoney(qty,price){	//计算总付款价格，并实时动态地显示到页面中去
        var total = qty * price;
        document.getElementById("totalprice").innerHTML = total;
    }
</script>

<?php include 'footer.php'; ?>
