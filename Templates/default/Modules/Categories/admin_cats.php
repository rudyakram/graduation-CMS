<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
<?PHP
  for ($i=1;$i<=$child;$i++) $cats.='... ';
  $cats.='<img src=Templates/default/Images/folder.gif>';
  $cats.=$cat_name.'('.$cat_posts.')</td><td><a href="javascript:AddNewCat('.$cat_id.','.($child+1).')"><img border=0 title="'.$lang_cat['Add_sub_cat'].'" src=Templates/default/Images/subadd.bmp></a><a href="javascript:EditCat('.$cat_id.',\''.$cat_name.'\')"><img border=0 title="'.$lang_cat['Edit_cat'].'" src=Templates/default/Images/edit.bmp></a><a href="javascript:DeleteCat('.$cat_id.',\''.$cat_name.'\')"><img border=0 title="'.$lang_cat['Delete_cat'].'" src=Templates/default/Images/delete.bmp></a></td></tr>'."\n";
?>