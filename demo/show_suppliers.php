<?php 
	$title="供应商信息";
	include 'head.php';
?>
<table class="table table-condensed">
   <div>
  
   <thead>
   <div class="page-header">
   <h2>Suppliers</h2>
   </div>
    </div>
      <tr>
         <th>供应商编号</th><th>供应商姓名</th><th>所在城市</th><th>手机号码</th>
      </tr>
   </thead>
   <?php 
      error_reporting(0);
      require_once('conn.php');
      $query = "select sid,sname,city,telephone_no from suppliers";  
      $res = mysql_query($query, $conn) or die(mysql_error());
      $row = mysql_num_rows($res);    //如果查询成功这里返回真否则为假,列数目
      if($row)
      {
      for($i=0;$i<$row;$i++)            //这里用一个FOR 语句查询显示多条结果
      { 
      $dbrow=mysql_fetch_array($res);
      $sid=$dbrow['sid']; 
      $sname=$dbrow['sname']; 
      $city=$dbrow['city'];  
      $telephone_no=$dbrow['telephone_no']; 
      echo"<tr>
      <td>".$sid."</td>
      <td>".$sname."</td>
      <td>".$city."</td>
      <td>".$telephone_no."</td>

      </tr>";
}
}
?>
  
</table>
<?php include 'footer.php'; ?>