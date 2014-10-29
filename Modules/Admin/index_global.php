<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Administration global settings.   
*   +--------------------------------------------
*/

@include_once ("../../Common/functions.php");
avoid_direct_access();
$v=preg_split('/&/',$subvars);//Split string by a regular expression; here the regular expression is the action we take to make a change or update or delete the content
for ($i=0;$i<count($v);$i++) {
 $t=preg_split('/=/',$v[$i]);
 $myvars[$t[0]]=$t[1];// Returns an array containing substrings of subject split along boundaries matched by pattern
}

if (@$myvars['do']=='save') // if settings were ok save them
{
 $show_msg=1;
 $t=saveGlobal();
 if ($t==1)
 { 
  $set_msg=$lang['Setting_was_saved'];// show message that settings were saved
  $msg_class='okmsg';
 } 
 else
 {
  $set_msg=$lang['Can_not_save_setting'];// show message settings were not saved
  $msg_class='badmsg';
 } 
}

include "./Templates/$template/Modules/Admin/index_global.php";

$cpath.="--><a href=index.php?Module=Admin&submodule=Admin&action=mmodules>{$lang_admin['Manage_Modules']}</a>";
//$cpath.="--><a href=index.php?Module=Admin&submodule=Admin&action=global>{$lang_admin['Global']}</a>";
$cpath.="--><a href=index.php?Module=Admin&submodule=Admin&action=global>".$lang['Admin']."</a>";

function saveGlobal()// define function for website settings
{
  global $site_title,$site_caption,$template,$language,$home_module,$copyright,$table_prefix;

  $site_title=htmlspecialchars($_POST['sitetitle']);
  $site_caption=htmlspecialchars($_POST['sitecaption']);
  $template=$_POST['defaulttemplate'];
  $language=$_POST['defaultlanguage'];
  $home_module=$_POST['homemodule'];
  $copyright=htmlspecialchars($_POST['copyright']);

  include_once "./Common/db.php";
  open_select_db(); //connect to mysql and select db
  $result=mysql_query("UPDATE `{$table_prefix}general` SET `Site_Title`='".addslashes($_POST['sitetitle'])."', `Site_Caption`='".addslashes($_POST['sitecaption'])."', `Default_Template`='".addslashes($template)."', `Default_Language`='".addslashes($language)."', `Home_Module`='".addslashes($home_module)."', `Copyright`='".addslashes($_POST['copyright'])."'");
  $template=ThemePath($template);
  $language=LangPath($language);
  close_db();
  return $result;
}

?>