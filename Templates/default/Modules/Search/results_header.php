<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
<table border="1" cellpadding="3" cellspacing="0" style="border-collapse: collapse; font-size:9pt; border-top:0 none" bordercolor="#111111" width="95%">
  <tr>
    <td width="50%"><?PHP echo $lang_search['SearchResults:'];?> 
<?PHP if (((($page-1)*$max_posts)+$max_posts)>$total_posts) $to_p=$total_posts; else $to_p=((($page-1)*$max_posts)+$max_posts); ?>
<?PHP echo $lang['Page'] . ' ' . $page. ' '. $lang['of'] . ' '. $total_pages.' - '.$lang['displaying'].' '.(($page-1)*$max_posts+1).'-'.$to_p.' '.$lang['of'].' '.$total_posts; ?><?PHP if ($page<$total_pages) echo " - <a href=index.php?Module=News&page=".($page+1).">".$lang_news['Previous_Page']."</a>"; ?><?PHP if ($page>1) echo " - <a href=index.php?Module=News&page=".($page-1).">".$lang_news['Next_Page']."</a>"; ?>
	</td>
  </tr>
</table><br>
