<?php 
  $title="首页";
  include 'head.php';
?>
<?php 
  require_once('conn.php');
  $sql = "call show_products();";
  $query = mysql_query($sql);
  if($query&&mysql_num_rows($query)){
    while($row = mysql_fetch_assoc($query)){
      $data[] = $row;
    }
  }
?>
  <ol class="breadcrumb">
    <li><a>商品</a></li>
    <li><a>列表</a></li>
  </ol>
  
  <div class="row">

    <?php 
      if(!isset($data)) echo "<h3>暂无商品信息，请先添加</h3>";
      else{
        foreach ($data as $prod) {
          $prod['imgname'] = $prod['imgname']? $prod['imgname'] : 'no-image.png'; //是否有图片
    ?>

    <div class="col-sm-6 col-md-4">
      <div class="thumbnail">
        <img src="img/<?php echo $prod['imgname'] ?>" >
        <div class="caption">
           <p>商品名称： <small><?php echo $prod['pname'];?></small></p>
            <p>商品原价：<small><?php echo $prod['original_price'];?></small></p>
            <p>库存总量：<small><?php echo $prod['qoh'];?></small></p>
            <p>折扣率：<small><?php echo $prod['discnt_rate'];?></small></p>
            <p>折后价格：<small><?php echo $prod['original_price']*(1-$prod['discnt_rate']);?></small></p>
            <p>
               <a href="purchase.php?pid=<?php echo $prod['pid'];?>" class="btn btn-success" role="button">购买</a>   
               <a href="reportsale.php?pid=<?php echo $prod['pid'];?>" class="btn btn-info" role="button">销售情况</a>       
               <a href="del_product.php?pid=<?php echo $prod['pid'];?>" class="btn btn-danger" role="button" onclick="return show_confirm();">删除</a> 
            </p>
        </div>
      </div>
    </div>
    <?php }} ?>

  </div>  
<script type="text/javascript">
function show_confirm(){
  var r=confirm("确定删除该商品？（操作不可恢复）");
  if (r==true)
    return true;
  else
    return false;
}
</script>
<?php include 'footer.php'; ?>