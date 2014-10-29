<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Registration module, Allows users to create(signup) thier own accounts.   
*   +--------------------------------------------
*/
@include_once ("../../Common/functions.php");
avoid_direct_access();// prevent direct access of the page

if (@$_SESSION['User_Level']/1<(get_module_perm('Register'))/1) // 1 is user and 10 is full admin, so no permission
{
   $msg_module=$lang['Not_Permission_Level_'.get_module_perm('Register')];
   include "./Modules/MSG/index.php";// no permission message
}else
{

global $template, $lang, $language;
include "./Lang/$language/register.php";// include translation file for this module
include_once "./Common/db.php";

//load module setting
//open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}module_settings WHERE Module='Register' AND Setting='allow_registration'");
$row = mysql_fetch_array($result);
$allow_reg=$row['Value'];
mysql_free_result($result);
//close_db();


if (@$isadmin)
{// if the user is admin create a path for redirecting the admin to admin CP and then to the module managment page
 $cpath.="--><a href=index.php?Module=Admin&submodule=Admin&action=mmodules>{$lang_admin['Manage_Modules']}</a>";
 $cpath.="--><a href=index.php?Module=Admin&submodule=Register>".$lang['Register']."</a>";

 $v=preg_split('/&/',$subvars);//Split string by a regular expression; here the regular expression is the action we take to make a change or update or delete the content
  for ($i=0;$i<count($v);$i++) {
   $t=preg_split('/=/',$v[$i]);
   $myvars[$t[0]]=$t[1];// Returns an array containing substrings of subject split along boundaries matched by pattern
  }

  switch (@$myvars['action'])
  {
  case 'SaveSettings':  
   $t=SaveSettings();
   if ($t==1)
      ShowSettings(1,$lang['Setting_was_saved'],'okmsg');// settings were saved
   else
      ShowSettings(1,$lang['Can_not_save_setting'],'badmsg');// settings not saved!
   break;
  default:
   ShowSettings();
   break;
  }

 
}else
{

$reg_msg="";


$action=@$_GET['Action'];


//if ($action=='GenSecCode')
//{
//   header("Location: Common/ImageVer.php?svar=Reg_SecCode");
//   exit();
//}

//check if user has logged before
if (@$_SESSION['LoggedIn'])
{
  //header('Location: index.php');
  redirect("index.php");
  exit();
}

if ($allow_reg==1)// if registration is enabled by admin, allow users to register, i.e. show registration form
{
 if ($action=='Register')
 {
   $username=@$_POST['Username'];//post user name to db
   $email=@$_POST['email'];//post email to db
   $password=md5(@$_POST['Password']);//post password to db
   $seccode_usr=@$_POST['Seccode'];//post secuirty code
   if ((!eregi('^[a-zA-Z0-9_]+$', $username)) || (strlen(@$_POST['Password'])<6) || (!preg_match("/^[a-zA-Z0-9\._-]+@+[A-Za-z0-9\._-]+\.+[A-Za-z]{2,4}$/", $email)) || ($seccode_usr!=@$_SESSION['Reg_SecCode']))
   {
      if (!eregi('^[a-zA-Z0-9_]+$', $username)) $reg_msg=$lang_register['wrong_username'];// validating the user
	  if (strlen(@$_POST['Password'])<6) $reg_msg.='<br>'.$lang_register['password_short'];// validating password
	  if (!preg_match("/^[a-zA-Z0-9\._-]+@+[A-Za-z0-9\._-]+\.+[A-Za-z]{2,4}$/", $email)) $reg_msg.='<br>'.$lang_register['wrong_email'];// validating email
	  if ($seccode_usr!=@$_SESSION['Reg_SecCode'] || @$_SESSION['Reg_SecCode']=='') $reg_msg.='<br>'. $lang_register['wrong_sec_code'];// validating secuirty code
   }
   else
   { // if user exist
      if (user_exist($username)==0)
      {
	     $usr=add_user($username,$password,$email);
	     if ($usr['ID']>0)
		 {
           $_SESSION['LoggedIn']=true;
           $_SESSION['Username']=$usr['Username'];
           $_SESSION['Password']=$password;
           $_SESSION['User_Level']=$usr['Group']; //default permission
           $_SESSION['User_ID']=$usr['ID'];
		   $_SESSION['User_Email']=$usr['Email'];
           //header('Location: index.php');
		   redirect("index.php");
           exit();
		 }else //user was not added
         {
           $reg_msg=$lang_register['cant_add_user']; // user was not added because already exist
		 }
      }else
      {
         $reg_msg="'$username'".$lang_register['username_exist']; // repeated username
      }	 
   }
 }
 include "./Templates/$template/Modules/Register/index.php";// including the template page for this module
}else
{
 $msg_module=$lang_register['Registration_Disabled'];// sjow message registration disabled by admin
 include "./Modules/MSG/index.php";
}



}
}

/////////////////////////////////////////////////////////////////////

function add_user($username,$md5_password,$email)
{
      global $table_prefix;
      open_select_db(); //connect to mysql and select db
      $result=@mysql_query("INSERT INTO `{$table_prefix}users` (`ID`,`Username`,`Password`,`Email`,`Register_Date`,`Group`) VALUES (NULL,'".$username."','".$md5_password."','".$email."','".date('Y/m/d H:i:s')."',1)"); //default permission 1 (registered user)
      @mysql_free_result($result);
      $result=@mysql_query("SELECT * FROM {$table_prefix}users WHERE lcase(Username)='".strtolower($username)."'");
      $row = mysql_fetch_array($result);

      if (mysql_num_rows($result)>0)
      {
         return $row;
      }else
      {
         return 0;
      }

      mysql_free_result($result);
      //close_db();  
}

/////////////////////////////////////////////////////////////////////

function user_exist($user)
{
      global $table_prefix;
      open_select_db(); //connect to mysql and select db
      $result=mysql_query("SELECT ID FROM {$table_prefix}users WHERE lcase(Username)='".strtolower($user)."'");
      $row = mysql_fetch_array($result);

      if (mysql_num_rows($result)>0)
      {
         return $row['ID'];
      }else
      {
         return 0;
      }

      mysql_free_result($result);
      //close_db();
}

/////////////////////////////////////////////////////////////////////

function ShowSettings($display_msg=0,$msg='',$msg_class='okmsg')
{
  global $template, $lang, $lang_register, $main_loaded, $myvars,$allow_reg;
  include "./Templates/$template/Modules/Register/admin_settings.php";
}

/////////////////////////////////////////////////////////////////////

function SaveSettings()
{
  global $allow_reg,$table_prefix;
  open_select_db(); //connect to mysql and select db
  $allow_reg=@$_POST['allow_reg'];
  if ($allow_reg!=1) $allow_reg=0;
  $result=mysql_query("UPDATE `{$table_prefix}module_settings` SET Value='".$allow_reg."' WHERE Module='Register' AND Setting='allow_registration'");
  //close_db();
  return $result;
}

?>