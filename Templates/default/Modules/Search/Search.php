<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
<br>
<table border="1" cellpadding="3" cellspacing="0" style="border-collapse: collapse; font-size:9pt" bordercolor="#111111" width="95%">
  <tr>
    <td width="50%" valign="middle" style="padding-top:10; Padding-left:10; Padding-right:10">
	<form method="POST" action="index.php?Module=Search">
      <b><?PHP echo $lang_search['SearchQuery:'];?> </b><input type="text" name="q" size="20" value="<?PHP echo htmlspecialchars($query,3); ?>"><input type="submit" value="<?PHP echo $lang_search['Search'];?>" name="B1">
    </form>
    </td>
  </tr>
</table>
