<?php 
	$title="交易信息";
	include 'head.php';
?>

<table class="table table-condensed">
   <div>
  
   <thead>
     <div class="page-header">
   <h2>Purchases</h2>
   </div>
    </div>
      <tr>
         <th>商品交易编号</th><th>客户编号</th><th>员工编号</th><th>供应商编号</th><th>购买商品数量</th><th>交易时间</th><th>商品总价</th>
      </tr>
   </thead>
   <?php 
error_reporting(0);
require_once('conn.php');

$query = "call show_purchases()";   //调用存储过程
$res = mysql_query($query) or die(mysql_error());
$row = mysql_num_rows($res);    //如果查询成功这里返回真否则为假,列数目
if($row)
{
for($i=0;$i<$row;$i++)            //这里用一个FOR 语句查询显示多条结果
{ 
$dbrow=mysql_fetch_array($res);
$purid=$dbrow['purid']; 
$cid=$dbrow['cid']; 
$eid=$dbrow['eid'];  
$pid=$dbrow['pid'];
$qty=$dbrow['qty'];
$ptime=$dbrow['ptime'];
$total_price=$dbrow['total_price'];  
echo"<tr>
<td>".$purid."</td>
<td>".$cid."</td>
<td>".$eid."</td>
<td>".$pid."</td>
<td>".$qty."</td>
<td>".$ptime."</td>
<td>".$total_price."</td>
</tr>";
}
}
?>
  
</table>
<?php include 'footer.php'; ?>