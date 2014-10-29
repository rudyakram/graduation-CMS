<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     News module. Shows news and allow admins to manage news.   
*   +--------------------------------------------
*/
@include_once ("../../Common/functions.php");
avoid_direct_access();// prevent direct access of the page

if (@$_SESSION['User_Level']/1<(get_module_perm('News'))/1)// 1 is user and 10 is full admin, so no permission
{
   $msg_module=$lang['Not_Permission_Level_'.get_module_perm('News')];
   include "./Modules/MSG/index.php";
}else
{

include_once "./Common/db.php";
ob_start(); //avoid sending utf header chars to browser
require "./Lang/$language/news.php";// include the translation file for this module
ob_end_clean();

global $post_id,$post_title,$post_author,$post_date,$post_pre,$post_full,$post_permission,$post_views,$max_posts;

//load module setting
//open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}module_settings WHERE Module='News' AND Setting='Max_Post_in_Preview'");
$row = mysql_fetch_array($result);
$max_posts=$row['Value'];
mysql_free_result($result);
//close_db();


$action=@$_GET['Action'];
$id=@$_GET['id'];
$cat=@$_GET['cat'];
if (!isset($cat)) $cat=0;


if (@$isadmin)
{// if the user is admin create a path for redirecting the admin to admin CP and then to the module managment page
  $cpath.="--><a href=index.php?Module=Admin&submodule=Admin&action=mmodules>{$lang_admin['Manage_Modules']}</a>";
  $cpath.="--><a href=index.php?Module=Admin&submodule=News>".$lang['News']."</a>";

  $v=preg_split('/&/',$subvars);//Split string by a regular expression; here the regular expression is the action we take to make a change or update or delete the content
  for ($i=0;$i<count($v);$i++) {
   $t=preg_split('/=/',$v[$i]);
   $myvars[$t[0]]=$t[1];// Returns an array containing substrings of subject split along boundaries matched by pattern
  }

  include "./Templates/$template/Modules/News/admin_header.php";

  switch (@$myvars['action'])
  {
  case 'NewPost':
  $cpath.="--><a href=index.php?Module=Admin&submodule=News&action=NewPost>{$lang_news['New_Post']}</a>";
  unset($post_id); unset($post_title); unset($post_author); unset($post_date); unset($post_pre); unset($post_full); unset($post_permission); unset($post_views);
    include "./Templates/$template/Modules/News/admin_newpost.php";
    break;
  case 'AddPost':
    $t=AddPost();
    if ($t==1)
       ManagePosts(1,$lang_news['Post_was_added'],'okmsg');
    else
    {
       $news_msg=$lang_news['Can_not_add_post'];
       $show_msg=1;
       include "./Templates/$template/Modules/News/admin_newpost.php";  
    }
    break;
  case 'EditPost':
    $t=EditPost(@$myvars['id']);
    if ($t==1)
       include "./Templates/$template/Modules/News/admin_editpost.php";
    else
       ManagePosts(1,$lang_news['Can_not_edit_post'],'badmsg');
    break;
  case 'UpdatePost':
    $t=UpdatePost(@$myvars['id']);
    if ($t!=0)
       ManagePosts(1,$lang_news['Post_was_updated'],'okmsg');
    else
    {
       $news_msg=$lang_news['Can_not_update_post'];
       $show_msg=1;
       include "./Templates/$template/Modules/News/admin_editpost.php";  
    }
    break;
  case 'DeletePost':
    $t=DeletePost(@$myvars['id']);
    if ($t==1)
       ManagePosts(1,$lang_news['Post_was_deleted'],'okmsg');
    else
       ManagePosts(1,$lang_news['Can_not_delete_post'],'badmsg');
    break;
  case 'ManagePosts':
    $cpath.="--><a href=index.php?Module=Admin&submodule=News&action=ManagePosts>{$lang_news['Manage_Posts']}</a>";
    ManagePosts();
    break;
  case 'Settings':
    $cpath.="--><a href=index.php?Module=Admin&submodule=News&action=Settings>{$lang_news['Settings']}</a>";
    ShowSettings();
    break;
  case 'SaveSettings':
    $t=SaveSettings();
    if ($t==1)
       ShowSettings(1,$lang['Setting_was_saved'],'okmsg');
    else
       ShowSettings(1,$lang['Can_not_save_setting'],'badmsg');
    break;
  default:
    echo "News Module<BR>\n".
         "By Rudy Kaka<br>\n".
         "rudykaka@aol.com";
    break;
  }

  include "./Templates/$template/Modules/News/admin_footer.php";

}else
{
  if (isset($action))
  {

    if ($action=='read')
    {
      if (isset($id)) FullShow($id);
      else ShowPreview($cat);
    }

  }
  else ShowPreview($cat);
}
}
/////////////////////////////////////////////////////////////////////////// function for adding the preview part of the post

function ShowPreview($catid=0)
{
   global $template, $lang, $lang_news, $main_loaded,$max_posts,$table_prefix,$subCatsQuery;

   if (isset($_GET['page']) && is_numeric($_GET['page'])) $page=abs($_GET['page']); else $page=1;
   //open_select_db(); //connect to mysql and select db
   //find total posts number
   $sql="SELECT * FROM {$table_prefix}news";
   if ($catid!=0 && is_numeric($catid)) 
   {
     $subCatsQuery='Cat_ID='.intval($catid).' or ';
     Creat_Sub_Cats_Query(intval($catid),'News');
     $sql.=" WHERE ".$subCatsQuery."false";
   }	 
   $sql.=" ORDER BY Post_ID DESC";
   $result=mysql_query($sql);
   $total_posts=mysql_num_rows($result);
   mysql_free_result($result);
   $total_pages=intval($total_posts/$max_posts);
   if ($total_posts%$max_posts>0) $total_pages++;
   
   if ($page>$total_pages || !is_numeric($catid)) //page not found
   {
      $msg_module=$lang['Not_Found'];
      include "./Modules/MSG/index.php";
   }else
   {
      $sql="SELECT * FROM {$table_prefix}news";
      if ($catid!=0 && is_numeric($catid))
	  {
        $subCatsQuery='Cat_ID='.intval($catid).' or ';
	    Creat_Sub_Cats_Query(intval($catid),'News');
	    $sql.=" WHERE ".$subCatsQuery.'false';
	  }	
	  $sql.=" ORDER BY Post_ID DESC LIMIT ".(($page-1)*$max_posts).",".($max_posts);
	  $result=mysql_query($sql);
      $counter=0;
      $page_posts_num=mysql_num_rows($result);
   
      include "./Templates/$template/Modules/News/preview_header.php";
      while ($row = mysql_fetch_array($result))
      {
         $counter++;
         $post_id=$row['Post_ID'];
		 $post_cat=$row['Cat_ID'];
		 $post_catname=getCatname($post_cat);
         $post_title=$row['Post_Title'];
         $post_author=$row['Post_Author'];
         $post_date=$row['Post_Date'];
         $post_pre=$row['Post_Pre'];
         $post_views=$row['Post_Views'];

         include "./Templates/$template/Modules/News/preview_index.php";
         if ($counter<$page_posts_num) include "./Templates/$template/Modules/News/preview_seperator.php";
      }
      include "./Templates/$template/Modules/News/preview_footer.php";

      mysql_free_result($result);
      //close_db();
   } 
}

///////////////////////////////////////////////////////////////////// function for adding the details of the post

function FullShow($id)
{
   global $template, $lang, $lang_news, $main_loaded,$table_prefix;

   if (!is_numeric($id))    
   {
      $msg_module=$lang['Not_Found'];
      include "./Modules/MSG/index.php";
	  return false;
   }

   //open_select_db(); //connect to mysql and select db
   $result=mysql_query("SELECT * FROM {$table_prefix}news WHERE Post_ID=".$id); 
   
   if (mysql_num_rows($result)>0)
   {
      $row = mysql_fetch_array($result);

      $post_id=$row['Post_ID'];
	  $post_cat=$row['Cat_ID'];	  
      $post_title=$row['Post_Title'];
      $post_author=$row['Post_Author'];
      $post_date=$row['Post_Date'];
      $post_pre=$row['Post_Pre'];
      $post_continue=$row['Post_Full'];
      $post_views=$row['Post_Views']+1;
	  $post_permission=$row['Post_Permission'];
      mysql_free_result($result);
	  
	  if ($post_permission==0 || @$_SESSION['User_Level']>=$post_permission) //user has permission to view the post
	  {
        $result=mysql_query("Update {$table_prefix}news SET Post_Views=".$post_views." WHERE Post_ID=".$id); 
        include "./Templates/$template/Modules/News/full.php";
	  }else //user doesn't have permission
	  {
        $msg_module=$lang_news['Not_Permission_Level_'.$post_permission];
        include "./Modules/MSG/index.php";
      }	  
   }else //not found
   {
      $msg_module=$lang['Not_Found'];
      include "./Modules/MSG/index.php";
   }

   //close_db();
}

///////////////////////////////////////////////////////////////////// function for adding new post

function AddPost()
{
//  global $post_id,$post_title,$post_author,$post_date,$post_pre,$post_full,$post_permission,$post_views;
  global $table_prefix;
  //open_select_db(); //connect to mysql and select db
  $post_title=addslashes(htmlspecialchars($_POST['title'],0));
  $post_cat=addslashes(htmlspecialchars($_POST['category'],0));
  $post_author=addslashes(htmlspecialchars($_POST['author'],0));
  $post_date=addslashes(htmlspecialchars($_POST['date'],0));
  $post_pre=$_POST['FCKeditor1'];
  $post_full=$_POST['FCKeditor2'];
  $post_views=addslashes(htmlspecialchars($_POST['views'],0));
  $post_permission=addslashes(htmlspecialchars($_POST['permission'],0));

  $result=mysql_query("INSERT INTO `{$table_prefix}news` (`Post_ID`,`Cat_ID`,`Post_Title`,`Post_Author`,`Post_Date`,`Post_Views`,`Post_Pre`,`Post_Full`,`Post_Permission`) VALUES (NULL,".$post_cat.",'".$post_title."','".$post_author."','".$post_date."',".$post_views.",'".$post_pre."','".$post_full."',".$post_permission.")");
  //close_db();
  return $result;
}

///////////////////////////////////////////////////////////////////// function for deleting news posts

function DeletePost($post_id)
{
  global $table_prefix;

  if (!is_numeric($post_id)) return false;
  
  //open_select_db(); //connect to mysql and select db
  $result=mysql_query("DELETE FROM `{$table_prefix}News` WHERE `Post_ID`=".$post_id);
  //close_db();
  return $result;
}

///////////////////////////////////////////////////////////////////// function for deleting news posts

function EditPost($postid)
{
global $post_id,$post_cat,$post_title,$post_author,$post_date,$post_pre,$post_full,$post_permission,$post_views,$table_prefix;

if (!is_numeric($postid)) return 0;

//open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}news WHERE Post_ID=".$postid);

$num_rows=mysql_num_rows($result);
if ($num_rows>0)
{
  $row = mysql_fetch_array($result);
  $post_id=$row['Post_ID'];
  $post_cat=$row['Cat_ID'];
  $post_title=$row['Post_Title'];
  $post_author=$row['Post_Author'];
  $post_date=$row['Post_Date'];
  $post_pre=$row['Post_Pre'];
  $post_full=$row['Post_Full'];
  $post_permission=$row['Post_Permission'];
  $post_views=$row['Post_Views'];
}

mysql_free_result($result);
//close_db();
if ($num_rows>0)
   return 1;
else
   return 0;
}

///////////////////////////////////////////////////////////////////// function for updating the posts

function UpdatePost($postid)
{
  global $post_id,$post_cat,$post_title,$post_author,$post_date,$post_pre,$post_full,$post_permission,$post_views,$table_prefix; //when errors occur we need these variables to be global for displaying in edit
 
  if (!is_numeric($postid)) return 0;

  $post_id=$postid;
  $post_title=$_POST['title'];
  $post_cat=$_POST['category'];
  $post_author=$_POST['author'];
  $post_date=$_POST['date'];
  $post_pre=$_POST['FCKeditor1'];
  $post_full=$_POST['FCKeditor2'];
  $post_views=$_POST['views'];
  $post_permission=$_POST['permission'];

  //open_select_db(); //connect to mysql and select db
  $result=mysql_query("UPDATE `{$table_prefix}news` SET Post_Title='".$post_title."', Cat_ID='".$post_cat."', Post_Author='".$post_author."', Post_Date='".$post_date."', Post_Pre='".$post_pre."', Post_Full='".$post_full."', Post_Views=".$post_views.", Post_Permission=".$post_permission." WHERE Post_ID=".$postid);
  //close_db();
  return $result;
}

///////////////////////////////////////////////////////////////////// function for managing numbrer of news posts in pages

function ManagePosts($display_msg=0,$msg='',$msg_class='okmsg')
{
global $template, $lang, $lang_news, $main_loaded, $myvars,$table_prefix;

$page_start=@$_GET['start'];
if (!isset($page_start) || !is_numeric($page_start)) $page_start=0;
$item_count=@$_GET['count'];
if (!isset($item_count) || !is_numeric($item_count)) $item_count=10;// 10 news posts per page

//find total posts num.
$result=mysql_query("SELECT Post_ID FROM {$table_prefix}news");
$total_posts=mysql_num_rows($result);

//open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}news ORDER BY Post_ID DESC LIMIT ".$page_start.','.$item_count);

include "./Templates/$template/Modules/News/admin_mposts_pre.php";

$counter=0;
if (mysql_num_rows($result)>0)
{
  while ($row = mysql_fetch_array($result))
  {
    $counter++;
    $post_id=$row['Post_ID'];
    $post_cat=$row['Cat_ID'];
    $post_catname=getCatname($post_cat);
    $post_title=$row['Post_Title'];
    $post_author=$row['Post_Author'];
    $post_date=$row['Post_Date'];
    $post_permission=$row['Post_Permission'];
    $post_views=$row['Post_Views'];

    include "./Templates/$template/Modules/News/admin_mposts_index.php";

    if ($counter<mysql_num_rows($result)) include "./Templates/$template/Modules/News/admin_mposts_seperator.php";
  }
}

include "./Templates/$template/Modules/News/admin_mposts_end.php";

mysql_free_result($result);
//close_db();
}

///////////////////////////////////////////////////////////////////// function for diplaying the news editing settings

function ShowSettings($display_msg=0,$msg='',$msg_class='okmsg')
{
  global $template, $lang, $lang_news, $main_loaded, $myvars,$max_posts;
  include "./Templates/$template/Modules/News/admin_settings.php";
}

///////////////////////////////////////////////////////////////////// function for saving the chnages

function SaveSettings()
{
  global $max_posts,$table_prefix;

  if (!is_numeric($_POST['maxpp'])) return false;
  
  //open_select_db(); //connect to mysql and select db
  $max_posts=$_POST['maxpp'];
  $result=mysql_query("UPDATE `{$table_prefix}module_settings` SET Value='".$max_posts."' WHERE Module='News' AND Setting='Max_Post_in_Preview'");
  //close_db();
  return $result;
}

///////////////////////////////////////////////////////////////////// function for showing the news post date
function zonedate($layout, $countryzone, $daylightsaving)
{
if ($daylightsaving){
$daylight_saving = date('I');
if ($daylight_saving){$zone=3600*($countryzone+1);}
}
else {
   if ($countryzone>>0){$zone=3600*$countryzone;}
       else {$zone=0;}
}
$date=gmdate($layout, time() + $zone);
return $date;
}

?>