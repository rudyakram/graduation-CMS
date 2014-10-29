<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
<font color=#a0800E><img src="Templates/default/Images/bullet_Li.gif"></font><a href="<?PHP echo "index.php?Module=News&Action=read&id=$post_id"; ?>" title="<?PHP echo $lang['Author:']." ".$post_author." - ".$post_date; ?>"><?PHP echo $post_title?></a>