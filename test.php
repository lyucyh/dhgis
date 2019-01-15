<?php 
$nextid = (int)$_POST['id']+1;
$preid = (int)$_POST['id']-1;
echo '<div><button onclick="test('.$nextid.','.$_POST["xy"].','.$_POST["date"].')"><</btton></div>';

echo '<div><table id="customers">  
<tr>  
<th>ID</th>  
<th>Date</th>  
<th>XY</th>  
</tr>  
  
<tr>  
<td>'.$_POST["id"].'</td>  
<td>'.$_POST["date"].'</td>  
<td>'.$_POST["xy"].'</td>  
</tr>  
  
</table></div>';


echo '<div><button onclick="test('.$nextid.','.$_POST["xy"].','.$_POST["date"].')">></btton></div>'; 

?>