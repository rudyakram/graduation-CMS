<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
<br>
<center>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-size:9pt" >
  <tr>
    <td width="50%" align=center valign="middle" >
	<form method="POST" action="index.php?Module=Search">
      <input type="text" name="q" size="15" value="">
	  <input type="submit" value="<?PHP echo $lang['Go'];?>" name="B1">
    </form>
    </td>
  </tr>
</table>
</center>