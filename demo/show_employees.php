<?php 
	$title="员工信息";
	include 'head.php';
?>
<table class="table table-condensed">
   <div>
  
   <thead>
     <div class="page-header">
   <h2>Employees</h2>
   </div>
        </div>
      <tr>
         <th>员工编号</th><th>员工姓名</th><th>所在城市</th>
      </tr>
   </thead>
   <?php 
error_reporting(0);
require_once('conn.php');
$query = "call show_employees();";  
$res = mysql_query($query, $conn) or die(mysql_error());
$row = mysql_num_rows($res);    //如果查询成功这里返回真否则为假,列数目
if($row)
{
for($i=0;$i<$row;$i++)            //这里用一个FOR 语句查询显示多条结果
{ 
$dbrow=mysql_fetch_array($res);
$eid=$dbrow['eid']; $ename=$dbrow['ename']; $city=$dbrow['city'];  
echo"<tr>
<td>".$eid."</td><td>".$ename."</td><td>".$city."</td>
</tr>";
}
}
?>
  
</table>
<?php include 'footer.php'; ?>