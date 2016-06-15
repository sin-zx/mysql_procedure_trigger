<?php 
	$title="添加商品信息";
	include 'head.php';
?>
<?php 
  require_once('conn.php');
  //读取数据库中的供应商列表以供选择
  $sql = "select * from suppliers";
  $query = mysql_query($sql) or die(mysql_error());
  if($query && @mysql_num_rows($query)){
    while($row = mysql_fetch_assoc($query)){
      $suppliers[] = $row;
    }
  }
 ?>
<h3 class="text-center">添加商品</h3>
<form action="add_product_handle.php" method="post" class="form-horizontal" role="form">
    <div class="form-group">
    <label class="col-sm-2 control-label">商品名称</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="pname">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">库存总量</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="qoh">
    </div>
  </div>
 <div class="form-group">
    <label class="col-sm-2 control-label">库存临界值</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="qoh_threshold" placeholder="当库存低于该值时会进行相应的处理">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">商品原价</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="original_price">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">商品折扣率</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="discnt_rate">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">商品图片名称</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="imgname" placeholder="添加图片需要在此输入图片名后再手动把图片放于img/目录下，若不加图片则留空">
    </div>
    <p class="text-danger">注：添加图片需要在此输入图片名后再手动把图片放于img/目录下，若不加图片则留空</p>
  </div>
  
  <div class="form-group">
    <label class="col-sm-2 control-label">供应商</label>
    <div class="col-sm-10">
      <?php 
          if(!isset($suppliers)){
            echo "<h3>暂无供应商数据，请先添加</h3>";
            echo 'input type="hidden" name="sid">'; //留空
          }else{
              echo '<select name="sid" class="form-control">';
              foreach ($suppliers as $supplier) {
          ?>
          <option value="<?php echo $supplier['sid']; ?>"><?php echo $supplier['sid'].'.'.$supplier['sname']; ?></option>
                
          <?php 
            }
            echo "</select>";
            } 
          ?>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-success">确定</button>
      <a href="index.php" class="btn btn-warning">取消</a>
    </div>
  </div>
</form>

<?php include 'footer.php'; ?>
