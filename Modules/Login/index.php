<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Login module   
*   +--------------------------------------------
*/

@include_once ("../../Common/functions.php");
avoid_direct_access();// prevent direct access of the page

if (@$_SESSION['User_Level']/1<(get_module_perm('Login'))/1) //  1 is user and 10 is full admin, so no permission
{
   $msg_module=$lang['Not_Permission_Level_'.get_module_perm('Login')];
   include "./Modules/MSG/index.php";
}else
{
global $template, $lang, $language;
include_once "./Lang/$language/login.php";// include the language translation file for this module
include_once "./Common/db.php";


//load module setting
//open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}module_settings WHERE Module='Login' AND Setting='UseSecurityCode'");
$row = mysql_fetch_array($result);
$use_sec_code=$row['Value'];
mysql_free_result($result);
//close_db();


if (@$isadmin)// if the user is admin create a path for redirecting the admin to admin CP and then to the module managment page
{
 $cpath.="--><a href=index.php?Module=Admin&submodule=Admin&action=mmodules>{$lang_admin['Manage_Modules']}</a>";
 $cpath.="--><a href=index.php?Module=Admin&submodule=Login>".$lang['Login']."</a>";

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
      ShowSettings(1,$lang['Setting_was_saved'],'okmsg');
   else
      ShowSettings(1,$lang['Can_not_save_setting'],'badmsg');
   break;
  default:
   ShowSettings();
   break;
  }
  
}else
{

$login_msg="";



$action=@$_GET['Action'];


//if ($action=='GenSecCode')
//{
//   header("Location: Common/ImageVer.php?svar=SecCode");
//   exit();
//}
if ($action=='Logout')
{
   //header('Location: index.php');
   redirect("index.php");
   $_SESSION['LoggedIn']=0;
   $_SESSION['Username']="";
   $_SESSION['Password']="";
   $_SESSION['User_Level']="";
   $_SESSION['User_ID']="";
   $_SESSION['User_Email']="";
   exit();
}   

//check if user has logged before
if (@$_SESSION['LoggedIn'])
{
   if (checkuser(@$_SESSION['Username'],@$_SESSION['Password']))
   {
      //header('Location: index.php');
	  redirect("index.php");
      exit();
   }
}


if ($action=='Login')
{
   $username=strtolower(@$_POST['Username']);
   $password=md5(@$_POST['Password']);
   $seccode_usr=@$_POST['Seccode'];

   if (($use_sec_code==1) && ($seccode_usr!=@$_SESSION['SecCode'] || @$_SESSION['SecCode']==''))
   {
      $login_msg= $lang_login['wrong_sec_code']; // "Wrong Security Code."
   }else
   {
      $usr=checkuser($username,$password);
      if ($usr['ID']>0)
      {
         $_SESSION['LoggedIn']=true;
         $_SESSION['Username']=$usr['Username'];
         $_SESSION['Password']=$password;
         $_SESSION['User_Level']=$usr['Group'];
         $_SESSION['User_ID']=$usr['ID'];
		 $_SESSION['User_Email']=$usr['Email'];
         //header('Location: index.php');
		 redirect("index.php");
         exit();
      }else
      {
         $login_msg= $lang_login['wrong_usr_pass']; // "Wrong Username and/or Password."
      }
   }
}



include "./Templates/$template/Modules/Login/index.php";

}
}

///////////////////////////////////////////////////////////////////// function for checking the user existance

function checkuser($user,$pass)
{
	  global $table_prefix;
      open_select_db(); //connect to mysql and select db
      $result=mysql_query("SELECT * FROM {$table_prefix}users WHERE lcase(Username)='".addslashes(strtolower($user))."' and Password='".addslashes($pass)."'");
      $row = mysql_fetch_array($result);

      if (mysql_num_rows($result)>0 && (strtolower($user)==strtolower($row['Username']) && $pass==$row['Password']))
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

function ShowSettings($display_msg=0,$msg='',$msg_class='okmsg')
{
  global $template, $lang, $lang_login, $main_loaded, $myvars,$use_sec_code;
  include "./Templates/$template/Modules/Login/admin_settings.php";
}

///////////////////////////////////////////////////////////////////// function for saving the settings

function SaveSettings()
{
  global $use_sec_code,$table_prefix;
  open_select_db(); //connect to mysql and select db
  $use_sec_code=@$_POST['use_sec_code'];
  if ($use_sec_code!=1) $use_sec_code=0;
  $result=mysql_query("UPDATE `{$table_prefix}module_settings` SET Value='".$use_sec_code."' WHERE Module='Login' AND Setting='UseSecurityCode'");
  //close_db();
  return $result;
}


?>