<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
          </table>
          </center>
<p align=center>
<?php $p_start=$page_start-$item_count; 
if ($p_start<0) $p_start=0;
if ($page_start>0) echo "<a href=index.php?Module=Admin&submodule=Downloads&action=ManageFiles&start=".($p_start)."&count=".$item_count.">".$lang['Previous_Page']."</a>"; ?> <?php if ($page_start+$item_count<$total_files) echo "<a href=index.php?Module=Admin&submodule=Downloads&action=ManageFiles&start=".($page_start+$item_count)."&count=".$item_count.">".$lang['Next_Page']."</a>"; ?>
</p>