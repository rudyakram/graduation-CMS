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
		<table border=0>
		 <tr>
		  <td>
		  <?PHP echo $lang_downloads['Description']; ?>:
		  </td>
		  <td>
          <?PHP echo $dl_desc; ?>
		  </td>
		 </tr>
		 <tr>
		  <td>
		  <?PHP echo $lang_downloads['Date']; ?>:
		  </td>
		  <td>
          <?PHP echo $dl_date; ?>
		  </td>
		 </tr>
		 <tr>
		  <td>
		  <?PHP echo $lang_downloads['Added_By']; ?>:
		  </td>
		  <td>
          <?PHP echo $dl_author; ?>
		  </td>
		 </tr>
		 <tr>
		  <td>
		  <?PHP echo $lang_downloads['Category']; ?>:
		  </td>
		  <td>
          <a href=index.php?Module=Downloads&cat=<?PHP echo $dl_cat; ?>><?PHP echo $dl_catname; ?></a>
		  </td>
		 </tr>
		 <tr>
		  <td>
		  <?PHP echo $lang_downloads['FileSize']; ?>:
		  </td>
		  <td>
          <?PHP echo $dl_size; ?> <?PHP echo $lang_downloads['Bytes']; ?>
		  </td>
		 </tr>
		 <tr>
		  <td>
		  <?PHP echo $lang_downloads['Downloads']; ?>:
		  </td>
		  <td>
          <?PHP echo $dl_downloads; ?>
		  </td>
		 </tr>
		 <tr>
		  <td colspan=2>
		  <a href=index.php?Module=Downloads&Action=download&id=<?PHP echo $dl_id; ?>><img src=Templates/default/images/go-down.png border=0 align=center> <b><?PHP echo $lang_downloads['Download']; ?></b></a>
		  </td>
		 </tr>
		 </table>
        </td>
    </tr>
    </table>
    </td></tr></table>