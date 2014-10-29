<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
    <table border="2" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-size:9pt" bordercolor="#b1b1b1" width="100%"><tr><td>
    <table border="0" cellspacing="0" style="border-collapse: collapse; font-size:9pt" bordercolor="#b1b1b1" width="100%">
    <tr>
        <td width="100%" height=25 style="background-image:url('Templates/default/images/cellpic.gif'); background-repeat: repeat-x; border-right:0px solid">
        <b><?PHP echo $dl_title; ?></b>
        </td>
	</tr>
    <tr>
        <td width="100%" colspan=4 style="padding:5px; border-top:1px solid">
		<table border=0 width=100%>
		 <tr>
		  <td colspan=3>
          <?PHP echo $dl_desc; ?>
		  </td>
		 </tr>
		 <tr>
		  <td colspan=3>&nbsp;</td>
		 </tr> 
		 <tr>
		  <td width=50%>
		  <?PHP echo $lang_downloads['FileSize']; ?>: <?PHP echo $dl_size; ?> <?PHP echo $lang_downloads['Bytes']; ?>
		  </td>
		  <td width=50%>
		  <?PHP echo $lang_downloads['Downloads']; ?>: <?PHP echo $dl_downloads; ?>
		  </td>
		  <td nowrap>
		  <a href=index.php?Module=Downloads&Action=view&id=<?PHP echo $dl_id; ?>><?PHP echo $lang_downloads['Download']; ?></a>
		  </td>
		 </tr>
		 </table>
        </td>
    </tr>
    </table>
    </td></tr></table>