<?php 
  $title="销售详情";
  include 'head.php';
?>

<?php 
  require_once('conn.php');
  $id = isset($_GET['pid'])? $_GET['pid'] : 0;
  $sql = "call report_monthly_sale($id);";
  $query = mysql_query($sql) or die(mysql_error());
  if($query&&mysql_num_rows($query)){
    while($row = mysql_fetch_assoc($query)){
      $data[] = $row;
    }
    $pname = $data[0]['pname'];
    $imgname = $data[0]['imgname'];
    $imgname = $imgname? $imgname : 'no-image.png'; //是否有图片
  }
  
  $pname = isset($pname)? $pname : '';
  $imgname = isset($imgname)? $imgname : 'no-image.png';
?>
  <ol class="breadcrumb">
    <li>商品</li>
    <li>月销售情况</li>
    <li><a><?php echo $pname; ?></a></li>
  </ol>

  <div class="row-fluid">
    <div class="col-md-2">
      <ul class="nav nav-pills nav-stacked">
        <h4>
          操作选择
        </h4>
				<li>
					<a href="reportsale.php?pid=<?php echo $id; ?>">月度报表</a>
				</li>
				<li>
					<a href="purchase.php?pid=<?php echo $id; ?>">选择购买</a>
				</li>
				
				<li class="divider">
				</li>
				
			</ul>
		</div>
  <br />

		<div class="col-md-7">
           	<legend>商品销售详情</legend> 
			<table class="table table-bordered">			
   			<tbody>
            	<tr>
         			<th>月份</th><th>年份</th><th>销售总量</th><th>销售总额</th><th>平均价格</th>
      			</tr>

				<?php 
				  if(!isset($data)) echo "<h3>暂无记录</h3>";
				  else{
				    foreach ($data as $report) {
				?>
				<tr>
					<th><?php echo $report['month']; ?></th>
					<th><?php echo $report['year']; ?></th>
					<th><?php echo $report['total_qty']; ?></th>
					<th><?php echo $report['total_dollar']; ?></th>
					<th><?php echo $report['avg_price']; ?></th>
				</tr>
				<?php }}	//循环结束 ?>
           	</tbody>
        	</table>
		</div>
		<div class="col-md-3">
			<img src="img/<?php echo $imgname; ?>" alt="140x140" width="232" height="230" class="img-polaroid" />
		</div>
	</div>


<?php include 'footer.php'; ?>
