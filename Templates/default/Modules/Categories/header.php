<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
		<center>
        <table border="0" cellpadding="5" cellspacing="0" style="border-collapse: collapse;" >
          <tr>
          
		  <td colspan=2 align=center>
<?PHP $module_names=mysql_query("SELECT DISTINCT Module FROM {$table_prefix}Categories");
 while ($row = mysql_fetch_array($module_names))
 {
//  $module_id=$row['ID'];
  echo '<a href=index.php?Module=Categories&CatModule='.$row['Module'].'>'.$lang[$row['Module']].'</a> ';
  }
  ?>
			</td>
          </tr>
          <tr>
            <td nowrap colspan=2 align=center>
			&nbsp;
            </td>
          </tr>		  
		</table>
        <table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111">
		<tr><td>