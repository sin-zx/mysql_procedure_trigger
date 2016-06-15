<?php 
	$title="商品信息";
	include 'head.php';
?>
<table class="table table-condensed">
   <div>
  
   <thead>
    <div class="page-header">
   <h2>Products</h2>
   </div>
    </div>
      <tr>
         <th>商品编号</th><th>商品名称</th><th>库存总量</th><th>临界值</th><th>商品原价</th><th>商品折扣率</th><th>供应商编号</th>
      </tr>
   </thead>
   <?php 
error_reporting(0);
require_once("conn.php");
$query = "select pid,pname,qoh,qoh_threshold,original_price,discnt_rate,sid from products";  
$res = mysql_query($query, $conn) or die(mysql_error());
$row = mysql_num_rows($res);    //如果查询成功这里返回真否则为假,列数目
if($row)
{
for($i=0;$i<$row;$i++)            //这里用一个FOR 语句查询显示多条结果
{ 
$dbrow=mysql_fetch_array($res);
$pid=$dbrow['pid']; 
$pname=$dbrow['pname']; 
$qoh=$dbrow['qoh']; 
$qoh_threshold=$dbrow['qoh_threshold'];  
$original_price=$dbrow['original_price']; 
$discnt_rate=$dbrow['discnt_rate'];
$sid=$dbrow['sid'];
 
echo"<tr>
<td>".$pid."</td>
<td>".$pname."</td>
<td>".$qoh."</td>
<td>".$qoh_threshold."</td>
<td>".$original_price."</td>
<td>".$discnt_rate."</td>
<td>".$sid."</td>
</tr>";
}
}
?>
  
</table>
<?php include 'footer.php'; ?>