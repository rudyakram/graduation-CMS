<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Downloads module   
*   +--------------------------------------------
*/
@include_once ("../../Common/functions.php");
avoid_direct_access();// prevent direct access of the page

if (@$_SESSION['User_Level']/1<(get_module_perm('Downloads'))/1) //  1 is user and 10 is full admin, so no permission
{
   $msg_module=$lang['Not_Permission_Level_'.get_module_perm('Downloads')];
   include "./Modules/MSG/index.php";// show meesage no permission
}else
{
global $template, $lang, $language;
include_once "./Lang/$language/downloads.php";
include_once "./Common/db.php";


$action=@$_GET['Action'];
$id=@$_GET['id'];
$cat=@$_GET['cat'];
if (!isset($cat)) $cat=0;

if (@$isadmin)
{// if the user is admin create a path for redirecting the admin to admin CP and then to the module managment page
  $cpath.="--><a href=index.php?Module=Admin&submodule=Admin&action=mmodules>{$lang_admin['Manage_Modules']}</a>";
  $cpath.="--><a href=index.php?Module=Admin&submodule=Downloads>".$lang['Downloads']."</a>";

  $v=preg_split('/&/',$subvars);//Split string by a regular expression; here the regular expression is the action we take to make a change or update or delete the content
  for ($i=0;$i<count($v);$i++) {
   $t=preg_split('/=/',$v[$i]);
   $myvars[$t[0]]=$t[1];// Returns an array containing substrings of subject split along boundaries matched by pattern
  }

  include "./Templates/$template/Modules/Downloads/admin_header.php";

  switch (@$myvars['action'])
  {
  case 'NewFile':
  $cpath.="--><a href=index.php?Module=Admin&submodule=Downloads&action=NewFile>{$lang_downloads['New_File']}</a>";
    include "./Templates/$template/Modules/Downloads/admin_newfile.php";
    break;
  case 'AddFile':
    $err=AddFile();
    if (empty($err))
       ManageFiles(1,$lang_downloads['File_was_added'],'okmsg');
    else
    {
       $news_msg=$err;
       $show_msg=1;
       include "./Templates/$template/Modules/Downloads/admin_newfile.php";  
    }
    break;
  case 'EditFile':
    $res=EditFile(@$myvars['id']);
    if ($res!=0)
       include "./Templates/$template/Modules/Downloads/admin_editfile.php";
    else
       ManageFiles(1,$lang_downloads['Can_not_edit_file'],'badmsg');
    break;
  case 'UpdateFile':
    $t=UpdateFile(@$myvars['id']);
    if ($t!=0)
       ManageFiles(1,$lang_downloads['File_was_updated'],'okmsg');
    else
    {
       $news_msg=$lang_downloads['Can_not_update_file'];
       $show_msg=1;
       include "./Templates/$template/Modules/Downloads/admin_editfile.php";  
    }
    break;
  case 'DeleteFile':
    $t=DeleteFile(@$myvars['id']);
    if ($t==1)
       ManageFiles(1,$lang_downloads['File_was_deleted'],'okmsg');
    else
       ManageFiles(1,$lang_downloads['Can_not_delete_file'],'badmsg');
    break;
  case 'ManageFiles':
    $cpath.="--><a href=index.php?Module=Admin&submodule=Downloads&action=ManageFiles>{$lang_downloads['Manage_Files']}</a>";
    ManageFiles();
    break;
  default:
    echo "Downloads Module<BR>\n".
         "By Rudy Kaka<br>\n".
         "rudykaka@aol.com";
    break;
  }

  include "./Templates/$template/Modules/Downloads/admin_footer.php";
  
}else
{
  if (isset($action))
  {

    if ($action=='download')
    {
      if (isset($id)) Download($id);
      else ShowPreview($cat);
    }
    if ($action=='view')
    {
      if (isset($id)) FullShow($id);
      else ShowPreview($cat);
    }

	
  }
  else ShowPreview($cat);
}

}

///////////////////////////////////////////////////////////////////// function for deleting files

function DeleteFile($id)
{
  global $table_prefix;

  if (!is_numeric($id)) return false;
  
  $result=mysql_query("DELETE FROM `{$table_prefix}Downloads` WHERE `ID`=".$id);
  //close_db();
  return $result;
}

///////////////////////////////////////////////////////////////////// function adding new files

function AddFile()
{
  global $table_prefix;

  $file_title=addslashes($_POST['title']);
  $file_cat=addslashes($_POST['category']);
  $file_author=addslashes($_POST['author']);
  $file_desc=addslashes($_POST['desc']);
  $file_downloads=addslashes($_POST['downloads']);
  $file_permission=addslashes($_POST['permission']);
  $file_date=addslashes($_POST['date']);
  $file_name=basename($_FILES['file']['name']);

  $file_hash ="file-".substr(md5(date('Ymdhis').rand(100000,999999)),0,16);
  copy ($_FILES['file']['tmp_name'], "downloads/".$file_hash);
  $result=mysql_query("INSERT INTO `{$table_prefix}downloads` (`ID`,`Cat_ID`,`Title`,`Added_By`,`Description`,`Filename`,`Filename_on_disk`,`Date_Added`,`Downloads`,`Permission`) VALUES (NULL,'".$file_cat."','".$file_title."','".$file_author."','".$file_desc."','".$file_name."','".$file_hash."','".$file_date."','".$file_downloads."','".$file_permission."')");
  
  //close_db();
  return mysql_error();
}
//////////////////////////////////////////////////////////////////// function updating "editing" files

function UpdateFile($id)
{
  if (!is_numeric($id)) return 0;
  global $table_prefix,$file_id,$file_cat,$file_catname,$file_title,$file_author,$file_date,$file_downloads,$file_perm,$file_desc,$file_size;;

  $result=mysql_query("SELECT Filename_on_disk FROM {$table_prefix}downloads WHERE ID=".$id); 
  if (mysql_num_rows($result)>0)
  {
    $row = mysql_fetch_array($result);
    $file_hash=$row['Filename_on_disk'];
  }
  else
    return 0;  

  //open_select_db(); //connect to mysql and select db
  $file_title=addslashes($_POST['title']);
  $file_cat=addslashes($_POST['category']);
  $file_author=addslashes($_POST['author']);
  $file_desc=addslashes($_POST['desc']);
  $file_downloads=addslashes($_POST['downloads']);
  $file_permission=addslashes($_POST['permission']);
  $file_date=addslashes($_POST['date']);
  $file_name=basename($_FILES['file']['name']);
  
  copy ($_FILES['file']['tmp_name'], "downloads/".$file_hash);
  $result=mysql_query("UPDATE `{$table_prefix}downloads` set `Cat_ID`='".$file_cat."' ,`Title`='".$file_title."' ,`Added_By`='".$file_author."' ,`Description`='".$file_desc."' ,`Filename`='".$file_name."' ,`Date_Added`='".$file_date."' ,`Downloads`='".$file_downloads."' ,`Permission`='".$file_downloads."' WHERE ID=".$id);
  if (mysql_error()=='') 
    return 1;
  else
    return 0;  
}
//////////////////////////////////////////////////////////////////// function for downloading the file

function Download($id)
{
   global $table_prefix,$lang,$lang_downloads;

   if (!is_numeric($id)) 
   {
      $msg_module=$lang['Not_Found'];// file not found!
      include "./Modules/MSG/index.php";
	  return false;
   }

   //open_select_db(); //connect to mysql and select db
   $result=mysql_query("SELECT * FROM {$table_prefix}downloads WHERE ID=".$id); 
   
   if (mysql_num_rows($result)>0)
   {
      $row = mysql_fetch_array($result);
	  $filename=$row['Filename'];
	  $filepath='./Downloads/' .$row['Filename_on_disk'];
	  $perm=$row['Permission'];
	  $downloads=$row['Downloads'];
	  $downloads++;

	  if ($perm==0 || @$_SESSION['User_Level']>=$perm) //user has permission to view the post
	  {
        $result=mysql_query("UPDATE `{$table_prefix}downloads` SET `Downloads`=".$downloads." WHERE `ID`=".$id); 	  
		ob_end_clean(); //we exit after download so let first clean buffer
		Header ("Content-Type: application/octet-stream; name=" . str_replace(' ','%20',$filename));// the %20 means space (for example abc%20def, is equal to abc def, %20 is url encoded of character 32 "space")
		Header ("Content-Length: " . filesize($filepath)); 
		Header ("Content-Disposition: attachment; filename=" . str_replace(' ','%20',$filename)); //str_replace(' ','%20',$filename)
		readfile($filepath);
//        header("Location: $filename");
		exit;
	  }else //user doesn't have permission
	  {
        $msg_module=$lang_downloads['Not_Permission_Level_'.$perm];
        include "./Modules/MSG/index.php";
      }	  


      mysql_free_result($result);

	  
   }else //not found
   {
      $msg_module=$lang['Not_Found'];
      include "./Modules/MSG/index.php";
   }

   //close_db();
}


function ManageFiles($display_msg=0,$msg='',$msg_class='okmsg')
{
global $template, $lang, $lang_downloads, $myvars,$table_prefix;

$page_start=@$_GET['start'];
if (!isset($page_start) || !is_numeric($page_start)) $page_start=0;
$item_count=@$_GET['count'];
if (!isset($item_count) || !is_numeric($item_count)) $item_count=10;

//find total posts num.
$result=mysql_query("SELECT ID FROM {$table_prefix}downloads");
$total_files=mysql_num_rows($result);

//open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}downloads ORDER BY ID DESC LIMIT ".$page_start.','.$item_count);

include "./Templates/$template/Modules/Downloads/admin_mfiles_pre.php";

$counter=0;
if (mysql_num_rows($result)>0)
{
  while ($row = mysql_fetch_array($result))
  {
	$counter++;

    $file_id=$row['ID'];
	$file_cat=$row['Cat_ID'];
	$file_catname=getCatname($file_cat);
    $file_title=$row['Title'];
    $file_author=$row['Added_By'];
    $file_date=$row['Date_Added'];
    $file_downloads=$row['Downloads'];
    $file_permission=$row['Permission'];
    $file_desc=$row['Description'];
	$file_size=filesize('./Downloads/'.$row['Filename_on_disk']);
	
    include "./Templates/$template/Modules/Downloads/admin_mfiles_index.php";

    if ($counter<mysql_num_rows($result)) include "./Templates/$template/Modules/Downloads/admin_mfiles_seperator.php";
  }
}

include "./Templates/$template/Modules/Downloads/admin_mfiles_end.php";

mysql_free_result($result);
//close_db();
}

function ShowPreview($catid=0)
{
   global $template, $lang, $lang_downloads, $table_prefix;

   if (isset($_GET['page']) && is_numeric($_GET['page'])) $page=abs($_GET['page']); else $page=1;
   //open_select_db(); //connect to mysql and select db
   //find total posts number
   $sql="SELECT * FROM {$table_prefix}downloads";
   if ($catid!=0 && is_numeric($catid)) $sql.=" WHERE Cat_ID=".addslashes($catid);
   $sql.=" ORDER BY ID DESC";
   $result=mysql_query($sql);
   $total_posts=mysql_num_rows($result);
   mysql_free_result($result);
   $total_pages=intval($total_posts/10);
   if ($total_posts%10>0) $total_pages++;

   if ($page>$total_pages || !is_numeric($catid)) //page not found
   {
      $msg_module=$lang['Not_Found'];
      include "./Modules/MSG/index.php";
   }else
   {
      $sql="SELECT * FROM {$table_prefix}downloads";
      if ($catid!=0 && is_numeric($catid)) $sql.=" WHERE Cat_ID=".addslashes($catid);
	  $sql.=" ORDER BY ID DESC LIMIT ".(($page-1)*10).",".(10);
	  $result=mysql_query($sql);
      $counter=0;
      $page_posts_num=mysql_num_rows($result);
   
      include "./Templates/$template/Modules/Downloads/preview_header.php";
      while ($row = mysql_fetch_array($result))
      {
         $counter++;
         $dl_id=$row['ID'];
		 $dl_cat=$row['Cat_ID'];
		 $dl_catname=getCatname($dl_cat);
         $dl_title=$row['Title'];
         $dl_author=$row['Added_By'];
         $dl_date=$row['Date_Added'];
         $dl_downloads=$row['Downloads'];
         $dl_perm=$row['Permission'];
         $dl_desc=$row['Description'];
		 $dl_size=filesize('./Downloads/'.$row['Filename_on_disk']);

         include "./Templates/$template/Modules/Downloads/preview_index.php";
         if ($counter<$page_posts_num) include "./Templates/$template/Modules/Downloads/preview_seperator.php";
      }
      include "./Templates/$template/Modules/Downloads/preview_footer.php";

      mysql_free_result($result);
      //close_db();
   } 
}


function FullShow($id)
{
   global $template, $lang, $lang_downloads, $table_prefix;

   if (!is_numeric($id)) 
   {
      $msg_module=$lang['Not_Found'];
      include "./Modules/MSG/index.php";
	  return false;
   }

   //open_select_db(); //connect to mysql and select db
   $result=mysql_query("SELECT * FROM {$table_prefix}downloads WHERE ID=".$id); 
   
   if (mysql_num_rows($result)>0)
   {
      $row = mysql_fetch_array($result);

      $dl_id=$row['ID'];
	  $dl_cat=$row['Cat_ID'];
	  $dl_catname=getCatname($dl_cat);
      $dl_title=$row['Title'];
      $dl_author=$row['Added_By'];
      $dl_date=$row['Date_Added'];
      $dl_downloads=$row['Downloads'];
      $dl_perm=$row['Permission'];
      $dl_desc=$row['Description'];
	  $dl_size=filesize('./Downloads/'.$row['Filename_on_disk']);
      mysql_free_result($result);
	  
      include "./Templates/$template/Modules/Downloads/full.php";
   }else //not found
   {
      $msg_module=$lang['Not_Found'];
      include "./Modules/MSG/index.php";
   }

   //close_db();
}


function EditFile($id)
{
   global $template, $lang, $lang_downloads, $table_prefix,$file_id,$file_cat,$file_catname,$file_title,$file_author,$file_date,$file_downloads,$file_perm,$file_desc,$file_size;

   if (!is_numeric($id)) 
   {
      //$msg_module=$lang['Not_Found'];
      //include "./Modules/MSG/index.php";
	  return 0;
   }

   //open_select_db(); //connect to mysql and select db
   $result=mysql_query("SELECT * FROM {$table_prefix}downloads WHERE ID=".$id); 
   
   if (mysql_num_rows($result)>0)
   {
      $row = mysql_fetch_array($result);

      $file_id=$row['ID'];
	  $file_cat=$row['Cat_ID'];
	  $file_catname=getCatname($file_cat);
      $file_title=$row['Title'];
      $file_author=$row['Added_By'];
      $file_date=$row['Date_Added'];
      $file_downloads=$row['Downloads'];
      $file_perm=$row['Permission'];
      $file_desc=$row['Description'];
	  $file_size=filesize('./Downloads/'.$row['Filename_on_disk']);

      mysql_free_result($result);
	  return 1;
	  
//      include "./Templates/$template/Modules/Downloads/full.php";
   }else //not found
   {
	  return 0;
      $msg_module=$lang['Not_Found'];
      include "./Modules/MSG/index.php";
   }

   //close_db();
}

?>