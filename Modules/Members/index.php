<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Members module. display and allow user management to admin.   
*   +--------------------------------------------
*/
@include_once ("../../Common/functions.php");
avoid_direct_access();// prevent direct access of the page

if (@$_SESSION['User_Level']/1<(get_module_perm('Members'))/1) // determine permission only members can and admin can access this page
{
   $msg_module=$lang['Not_Permission_Level_'.get_module_perm('Members')];
   include "./Modules/MSG/index.php";
}else
{
global $template, $lang, $language;
$mem_msg="";

include "./Lang/$language/members.php";
include_once "./Common/db.php";


$action=@$_GET['Action'];

if (@$isadmin)
{// if the user is admin create a path for redirecting the admin to admin CP and then to the module managment page
  $cpath.="--><a href=index.php?Module=Admin&submodule=Admin&action=mmodules>{$lang_admin['Manage_Modules']}</a>";
  $cpath.="--><a href=index.php?Module=Admin&submodule=Members>".$lang['Members']."</a>";
  $v=preg_split('/&/',$subvars);//Split string by a regular expression; here the regular expression is the action we take to make a change or update or delete the content
  for ($i=0;$i<count($v);$i++) {
   $t=preg_split('/=/',$v[$i]);
   $myvars[$t[0]]=$t[1];// Returns an array containing substrings of subject split along boundaries matched by pattern
  }

  include "./Templates/$template/Modules/Members/admin_header.php";
  
  switch (@$myvars['action'])
  {
  case 'ManageUsers':
    $cpath.="--><a href=index.php?Module=Admin&submodule=Members&action=ManageUsers>{$lang_members['Manage_Users']}</a>";
    ManageUsers('admin');
	break;
  case 'DeleteUser':
    $t=DeleteUser(@$myvars['id']);
    if ($t==1)
       ManageUsers('admin',1,$lang_members['User_was_deleted'],'okmsg');
    else
       ManageUsers('admin',1,$lang_members['Can_not_delete_user'],'badmsg');
    break;
  case 'EditUser':
	EditUser(@$myvars['id']);
	break;
  case 'SaveUser':
    $user_sett=UserSetting(@$myvars['id']);
	$old_pass=$user_sett['Password'];
	if (@$_POST['Password']=='')
	 $pass=$old_pass;
	else
	 $pass=md5($_POST['Password']);
    $t=update_user(@$_POST['Username'],$pass,htmlspecialchars_decode(@$_POST['Email']),@$_POST['Group']);
    if ($t!=0)
       EditUser(@$myvars['id'],1,$lang['Setting_was_saved'],'okmsg');
    else
       EditUser(@$myvars['id'],1,$lang['Can_not_save_setting'],'badmsg');
    break;
  default:
    echo "Members Module <BR>\n".
         "By Rudy Kaka<br>\n".
         "rudykaka@aol.com";
    break;

  }
  
}else
{
  ManageUsers();
}
}

///////////////////////////////////////////////////////////////////// function for updating user profile

function update_user($username,$md5_password,$email,$group)
{
      global $table_prefix;
	  if (!is_numeric($group)) return false;
      open_select_db(); //connect to mysql and select db
      $result=mysql_query("UPDATE `{$table_prefix}users` SET `Password`='".addslashes($md5_password)."',`Email`='".addslashes($email)."', `Group`='".addslashes($group)."' WHERE `Username`='".addslashes($username)."'"); //default permission 1 (registered user)
      return $result;

      mysql_free_result($result);
      close_db();  
}

///////////////////////////////////////////////////////////////////// function for deleting a user

function DeleteUser($user_id)
{
  global $table_prefix;
  if (!is_numeric($user_id)) return false;
  open_select_db(); //connect to mysql and select db
  $result=mysql_query("DELETE FROM `{$table_prefix}users` WHERE `ID`=".addslashes($user_id));
  close_db();
  return $result;
}

/////////////////////////////////////////////////////////////////////

function ManageUsers($usersoradmin='users',$display_msg=0,$msg='',$msg_class='okmsg')
{
global $template, $lang, $lang_members, $main_loaded, $myvars,$table_prefix;

$page_start=@$_GET['start'];
if (!isset($page_start) || !is_numeric($page_start)) $page_start=0;
$item_count=@$_GET['count'];
if (!isset($item_count) || !is_numeric($item_count)) $item_count=10;

//find total members num.
$result=mysql_query("SELECT ID FROM {$table_prefix}users");
$total_users=mysql_num_rows($result);

open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}users ORDER BY Username ASC LIMIT ".$page_start.','.$item_count);

include "./Templates/$template/Modules/Members/{$usersoradmin}_pre.php";

$counter=0;
if (mysql_num_rows($result)>0)
{
  while ($row = mysql_fetch_array($result))
  {
    $counter++;
    $user_id=$row['ID'];
    $user_name=$row['Username'];
    $user_group=$row['Group'];
    $user_email=$row['Email'];	
    $user_register_date=$row['Register_Date'];

    include "./Templates/$template/Modules/Members/{$usersoradmin}_index.php";

    if ($counter<mysql_num_rows($result)) include "./Templates/$template/Modules/Members/{$usersoradmin}_seperator.php";
  }
}

include "./Templates/$template/Modules/Members/{$usersoradmin}_end.php";

mysql_free_result($result);
close_db();
}

///////////////////////////////////////////////////////////////////// function for editing user profile

function EditUser($uid,$display_msg=0,$msg='',$msg_class='okmsg')
{
global $template, $lang, $lang_members, $main_loaded, $myvars;

$row=UserSetting($uid);
if ($row['ID']==$uid)
 include "./Templates/$template/Modules/Members/admin_edituser.php";
else
 ManageUsers('admin',1,'User Not Found','badmsg');
}

///////////////////////////////////////////////////////////////////// function displaying user profile 

function UserSetting($uid)
{
global $table_prefix;
if (!is_numeric($uid)) return 0;
open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}users WHERE ID=".addslashes($uid));
$mrow = mysql_fetch_array($result);
if (mysql_num_rows($result)>0)
 return $mrow;
else
 return 0;

mysql_free_result($result);
close_db();  
}
?>