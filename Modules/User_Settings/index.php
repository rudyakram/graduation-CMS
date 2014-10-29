<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     User settings module. Allow users to edit their options.   
*   +--------------------------------------------
*/

@include_once ("../../Common/functions.php");
avoid_direct_access();// prevent direct access of the page

if (@$_SESSION['User_Level']/1<(get_module_perm('User_Settings'))/1) // 1 is user and 10 is full admin, so no permission
{
   $msg_module=$lang['Not_Permission_Level_'.get_module_perm('User_Settings')];
   include "./Modules/MSG/index.php";// show message user not permitted
}else
{
global $template, $lang, $language;
$set_msg="";

include "./Lang/$language/user_settings.php";// include the tralnslation file for this module
include_once "./Common/db.php";


$action=@$_GET['Action'];

if (@$isadmin)
{// if the user is admin create a path for redirecting the admin to admin CP and then to the module managment page
 $cpath.="--><a href=index.php?Module=Admin&submodule=Admin&action=mmodules>{$lang_admin['Manage_Modules']}</a>";
 $cpath.="--><a href=index.php?Module=Admin&submodule=User_Settings>".$lang['User_Settings']."</a>";
 echo "User Setting Module by Rudy Kaka<br>";
 echo "Nothing to administrate.";
}else
{
if ($action=='SaveSettings')// difine the actions for chnaging password, email address...etc
{
   $email=@$_POST['email'];
   $password_old=md5(@$_POST['Password_old']);
   $password_new=md5(@$_POST['Password_new']);
   if ($password_old==md5("") || $password_new==md5(""))// post the new password as MD5 hash
   {
    $password_old=$_SESSION['Password'];
	$password_new=$_SESSION['Password'];
   }

   
   if (($password_old!=$_SESSION['Password']) || (strlen(@$_POST['Password_new'])<6 && @$_POST['Password_new']!='') || (!preg_match("/^[a-zA-Z0-9\._-]+@+[A-Za-z0-9\._-]+\.+[A-Za-z]{2,4}$/", $email)))// validate the password must at least 6 chars
   {
      $msg_class="badmsg";
	  $show_msg=1;
      if ($password_old!=$_SESSION['Password']) $set_msg= $lang_user_settings['wrong_old_pass']; 
      if (strlen(@$_POST['Password_new'])<6 && @$_POST['Password_new']!='') $set_msg.='<br>'.$lang_user_settings['password_short'];
	  if (!preg_match("/^[a-zA-Z0-9\._-]+@+[A-Za-z0-9\._-]+\.+[A-Za-z]{2,4}$/", $email)) $set_msg.='<br>'.$lang_user_settings['wrong_email'];
   }
   else
   {
	 if ($email=="") $email=$_SESSION['User_Email'];
     $usr=update_user($_SESSION['Username'],$password_new,$email);
     if ($usr['ID']>0)
	 {
       $_SESSION['LoggedIn']=true;
       $_SESSION['Username']=$usr['Username'];
       $_SESSION['Password']=$password_new;
	   $_SESSION['User_Email']=$email;
       $_SESSION['User_Level']=$usr['Group']; //default permission
       $_SESSION['User_ID']=$usr['ID'];
       $set_msg= $lang['Setting_was_saved']; 
       $msg_class="okmsg";
	   $show_msg=1;

	 }else //setting was not changed
     {
          $set_msg=$lang['Can_not_save_setting']; 
          $msg_class="badmsg";
	      $show_msg=1;
	 }
   }

}

include "./Templates/$template/Modules/User_Settings/index.php";// include user setting module template page
}
}

///////////////////////////////////////////////////////////////////// function for updating user profile

function update_user($username,$md5_password,$email)
{
      global $table_prefix;
      open_select_db(); //connect to mysql and select db
      $result=mysql_query("UPDATE `{$table_prefix}users` SET `Password`='".$md5_password."',`Email`='".addslashes($email)."' WHERE `Username`='".addslashes($username)."'"); //default permission 1 (registered user)

      $result=mysql_query("SELECT * FROM {$table_prefix}users WHERE lcase(Username)='".addslashes(strtolower($username))."'");
      $row = mysql_fetch_array($result);

      if (mysql_num_rows($result)>0)
      {
         return $row;
      }else
      {
         return 0;
      }

      mysql_free_result($result);
      close_db();  
}
?>