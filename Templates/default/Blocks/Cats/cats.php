<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
<?PHP
  for ($i=1;$i<=$child;$i++) $cats.='... ';
  $cats.='<img src=Templates/default/Images/folder.gif>';
  $cats.='<a href=index.php?Module='.$catmodule.'&cat='.$cat_id.'>'.$cat_name.'('.$cat_posts.")</a>\n";
?>