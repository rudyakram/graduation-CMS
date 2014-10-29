<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Administration module   
*   +--------------------------------------------
*/
@include_once ("../../Common/functions.php");
avoid_direct_access();
//session_start(); //a session have been started in main index
if (@$_SESSION['User_Level']<get_module_perm('Admin')) //10 is full admin
{
   $msg_module=$lang['Not_Permission_Level_'.get_module_perm('Admin')];
   include "./Modules/MSG/index.php";// show meesage no permission
}else //user is admin
{

ob_start(); //avoid sending utf header chars to browser
require "./Lang/$language/admin.php";
ob_end_clean();


global $template, $lang;// define the gloabl variables template and language
$subvars='';
$sub_module_out='';
$sub_module=@$_GET['submodule'];
$action=@$_GET['action'];// displays the action "changes" made
$isadmin=1;
$cpath="<a href=index.php?Module=Admin>{$lang['Admin_Panel']}</a>";// create path function to redirect authorized admin to the control panel

if ($sub_module!='')// if submodule was not empty i.e. exist
{
  if ($sub_module=='Admin' && $action=='') $action='global';// if module was not empty i.e. exist
  
  foreach ($_GET as $varname => $varvalue) {// displany the settings
    $subvars.= "$varname=$varvalue&";
  }
  $subvars=substr($subvars,0,strlen($subvars)-1);

  
  if (
     (strpos($sub_module,".")!=0 || strpos($sub_module,"\\")!=0 || strpos($sub_module,"/")!=0) || //avoid directory traversal
	 (!is_dir("./Modules/$sub_module")) || //check if module exist
	 ($sub_module=='Admin' && !is_file("./Modules/$sub_module/index_$action.php")) //check if action exist
     )
  {
   $msg_module=$lang['Not_Found'];// show a message "module not found" by calling MSG module
   $sub_module= "./Modules/MSG/index.php";// show a message "submodule not found" by calling MSG module
  }else
  {  
  //create sub module  
  if ($sub_module=='Admin'){
  $sub_module= "./Modules/$sub_module/index_$action.php";
   }else{  
   $sub_module= "./Modules/$sub_module/index.php";
  }
  }
  
  ob_start();// avoid sending header variables
  include $sub_module;
  $sub_module_out = ob_get_contents();
  ob_end_clean();
}

include "./Templates/$template/Modules/Admin/index.php";// include the admin cp template

}


?>