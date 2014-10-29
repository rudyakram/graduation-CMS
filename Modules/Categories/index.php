<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Categories module.   
*   +--------------------------------------------
*/
@include_once ("../../Common/functions.php");
avoid_direct_access();// prevent direct access of the page


if (@$_SESSION['User_Level']/1<(get_module_perm('Categories'))/1) // 1 is user and 10 is fulladmin, so no permission
{
   $msg_module=$lang['Not_Permission_Level_'.get_module_perm('Categories')];
   include "./Modules/MSG/index.php";// show message no permission
}else// user is admin....continue
{
global $template, $lang, $language;
include_once "./Lang/$language/categories.php";
include_once "./Common/db.php";


if (@$isadmin)
{
 $cpath.="--><a href=index.php?Module=Admin&submodule=Admin&action=mmodules>{$lang_admin['Manage_Modules']}</a>";
 $cpath.="--><a href=index.php?Module=Admin&submodule=Categories>".$lang['Categories']."</a>";

 $v=preg_split('/&/',$subvars);//Split string by a regular expression; here the regular expression is the action we take to make a change or update or delete the content
  for ($i=0;$i<count($v);$i++) {
   $t=preg_split('/=/',$v[$i]);
   $myvars[$t[0]]=$t[1];// Returns an array containing substrings of subject split along boundaries matched by pattern
  }

  $them_pre='admin_';

  switch (@$myvars['action'])
  {
  case 'addnewcat':  
   $t=AddCategory($myvars['name'],$myvars['parent'],$myvars['child'],$myvars['CatModule']);
   if ($t==1)
      ShowCategories(1,$lang['Setting_was_saved'],'okmsg');
   else
      ShowCategories(1,$lang['Can_not_save_setting'],'badmsg');
   break;
  case 'editcat':  
   $t=EditCat($myvars['catid'],$myvars['newname']);
   if ($t==1)
      ShowCategories(1,$lang['Setting_was_saved'],'okmsg');
   else
      ShowCategories(1,$lang['Can_not_save_setting'],'badmsg');
   break;
  case 'deletecat':  
   $t=DeleteCat($myvars['catid']);
   if ($t==1)
      ShowCategories(1,$lang['Setting_was_saved'],'okmsg');
   else
      ShowCategories(1,$lang['Can_not_save_setting'],'badmsg');
   break;
  default:
   ShowCategories();
   break;
  }
  
}else    ShowCategories();


}

///////////////////////////////////////////////////////////////////// function for displaying category

function ShowCategories($display_msg=0,$msg='',$msg_class='okmsg')
{
  global $template, $lang, $lang_cat, $main_loaded, $myvars,$them_pre,$table_prefix,$home_module;
  $catmodule=addslashes(@$_GET['CatModule']);
  if ($catmodule=='') $catmodule=$home_module;

  include "./Templates/$template/Modules/Categories/".$them_pre."header.php";
  echo Categories($catmodule);
  include "./Templates/$template/Modules/Categories/".$them_pre."footer.php";
}


///////////////////////////////////////////////////////////////////// function for defining category

function Categories($catmodule)
{
global $template,$them_pre;
open_select_db(); //connect to mysql and select db
$cats=Find_Sub_Cats(0,$catmodule);


 ob_start();
  include "./Templates/$template/Modules/Categories/".$them_pre."seperator.php";
  $seplen = ob_get_length();
 ob_end_clean();
 
  $cats=substr($cats,0,strlen($cats)-$seplen);
//close_db();
return $cats;
}

///////////////////////////////////////////////////////////////////// function for finding categroy

function Find_Sub_Cats($parent,$catmodule)
{
global $table_prefix,$template,$lang,$lang_cat,$them_pre;
 $childs=mysql_query("SELECT * FROM {$table_prefix}categories WHERE Parent=$parent AND Module='".addslashes($catmodule)."'");
 $cats='';
 ob_start();
  include "./Templates/$template/Modules/Categories/".$them_pre."seperator.php";
  $sep = ob_get_contents();
 ob_end_clean();
 
 while ($row = mysql_fetch_array($childs))
 {
  $cat_id=$row['ID'];
  $cat_name=$row['Name'];
  $child=$row['Child'];
  $cat_posts=PostNumsByCat($cat_id,$catmodule);
  
  include "./Templates/$template/Modules/Categories/".$them_pre."cats.php";
  $cats.=$sep;

  $cats.=Find_Sub_Cats($cat_id,$catmodule);
 }

return $cats;
} 

///////////////////////////////////////////////////////////////////// function for adding new category


function AddCategory($catname,$parent,$child,$catmodule)
{
 global $table_prefix;
 if (!is_numeric($parent) || !is_numeric($child)) return false;
 open_select_db(); //connect to mysql and select db
 $result=mysql_query("INSERT INTO `{$table_prefix}categories` (`ID`,`Module`,`Name`,`Child`,`Parent`) VALUES (NULL,'".addslashes($catmodule)."','".addslashes($catname)."',".$child.",".$parent.")");
 //close_db();
 return $result;
}

///////////////////////////////////////////////////////////////////// function for editing category

function EditCat($catid,$newcatname)
{
 global $table_prefix;
 if (!is_numeric($catid)) return false; 
 open_select_db(); //connect to mysql and select db
 $result=mysql_query("Update `{$table_prefix}categories` SET Name='".addslashes($newcatname)."' WHERE ID=".$catid); 
 //close_db();
 return $result;
}

///////////////////////////////////////////////////////////////////// function for deleting category

function DeleteCat($catid)
{
 global $table_prefix,$subCats;
 if (!is_numeric($catid)) return false; 
 open_select_db(); //connect to mysql and select db
 $subCats=array($catid);
 Creat_Sub_Cats_Array($catid);
 foreach ($subCats as $subcatid)
   $result=mysql_query("DELETE FROM `{$table_prefix}categories` WHERE `ID`=".$subcatid); 
 //close_db();
 return $result;
}


?>