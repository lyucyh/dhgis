<?php 

if($_POST["id"] =="2013-12-18"){
    echo '<table class="gridtable">  
<tr>  
    <th>Info Header 1</th><th>Info Header 2</th><th>Info Header 3</th>  
</tr>  
<tr>  
    <td>Text 1A</td><td>Text 1B</td><td>Text 1C</td>  
</tr>  
<tr>  
    <td>Text 2A</td><td>Text 2B</td><td>Text 2C</td>  
</tr>  
</table>';
}else 
{
    echo '<table id="customers">  
<tr>  
<th>Company</th>  
<th>Contact</th>  
<th>Country</th>  
</tr>  
  
<tr>  
<td>Apple</td>  
<td>Steven Jobs</td>  
<td>USA</td>  
</tr>  
  
<tr class="alt">  
<td>Baidu</td>  
<td>Li YanHong</td>  
<td>China</td>  
</tr>  
  
<tr>  
<td>Google</td>  
<td>Larry Page</td>  
<td>USA</td>  
</tr>  
  
<tr class="alt">  
<td>Lenovo</td>  
<td>Liu Chuanzhi</td>  
<td>China</td>  
</tr>  
  
<tr>  
<td>Microsoft</td>  
<td>Bill Gates</td>  
<td>USA</td>  
</tr>  
  
<tr class="alt">  
<td>Nokia</td>  
<td>Stephen Elop</td>  
<td>Finland</td>  
</tr>  
  
  
</table>  ';
}
?>