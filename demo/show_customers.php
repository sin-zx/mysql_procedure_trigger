<?php 
	$title="客户信息";
	include 'head.php';
?>
  
<table class="table table-condensed">
   <div>
  
   <thead>
   <div class="page-header">
   <h2>Customers</h2>
   </div>
    </div>
      <tr>
         <th>客户编号</th><th>客户姓名</th><th>所在城市</th><th>访问次数</th><th>上次访问时间</th>
      </tr>
   </thead>
   <?php 
error_reporting(0);
require_once('conn.php');
$query = "select cid,cname,city,visits_made,last_visit_time from customers";  
$res = mysql_query($query, $conn) or die(mysql_error());
$row = mysql_num_rows($res);    //如果查询成功这里返回真否则为假,列数目
if($row)
{
for($i=0;$i<$row;$i++)            //这里用一个FOR 语句查询显示多条结果
{ 
$dbrow=mysql_fetch_array($res);
$cid=$dbrow['cid']; 
$cname=$dbrow['cname']; 
$city=$dbrow['city'];  
$visits_time=$dbrow['visits_made']; 
$last_visit_time=$dbrow['last_visit_time'];  
echo"<tr>
<td>".$cid."</td>
<td>".$cname."</td>
<td>".$city."</td>
<td>".$visits_time."</td>
<td>".$last_visit_time."</td>
</tr>";
}
}
?>
  
</table>
<?php include 'footer.php'; ?>