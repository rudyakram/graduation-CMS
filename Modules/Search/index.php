<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Search module. Searches through news.   
*   +--------------------------------------------
*/
@include_once ("../../Common/functions.php");
avoid_direct_access();

if (@$_SESSION['User_Level']/1<(get_module_perm('Search'))/1) // 1 is user and 10 is full admin, so no permission
{
   $msg_module=$lang['Not_Permission_Level_'.get_module_perm('Search')];
   include "./Modules/MSG/index.php";
}else
{

include "./Lang/$language/search.php";
include_once "./Common/db.php";
ob_start(); //avoid sending utf header chars to browser
require "./Lang/$language/news.php";
ob_end_clean();

global $post_id,$post_title,$post_author,$post_date,$post_pre,$post_full,$post_permission,$post_views,$max_posts;

//load module setting
//open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}module_settings WHERE Module='News' AND Setting='Max_Post_in_Preview'");//quuery the modules table and select news module
$row = mysql_fetch_array($result);
$max_posts=$row['Value'];
mysql_free_result($result);
//close_db();


$action=@$_GET['Action'];
$query=@$_GET['q'];
if ($query=='') $query=@$_POST['q'];

if (@$isadmin)
{// if the user is admin create a path for redirecting the admin to admin CP and then to the module managment page
 $cpath.="--><a href=index.php?Module=Admin&submodule=Admin&action=mmodules>{$lang_admin['Manage_Modules']}</a>";
 $cpath.="--><a href=index.php?Module=Admin&submodule=Search>".$lang['Search']."</a>";
 echo "Search Module by Rudy Kaka<br>";
 echo "Nothing to administrate.";
}else
{
      include "./Templates/$template/Modules/Search/Search.php";
      if (isset($query)) Search($query);
}
}

/////////////////////////////////////////////////////////////////////

function Search($str)
{
   global $template, $lang, $lang_news, $lang_search, $main_loaded,$max_posts,$table_prefix;

   if (isset($_GET['page']) && is_numeric($_GET['page'])) $page=abs($_GET['page']); else $page=1;
   open_select_db(); //connect to mysql and select db
   //find total posts number from news table
   $result=mysql_query("SELECT * FROM {$table_prefix}news WHERE Post_Title LIKE '%".addslashes($str)."%' OR Post_Pre LIKE '%".addslashes($str)."%' OR Post_Full LIKE '%".addslashes($str)."%' ORDER BY Post_ID DESC");
   $total_posts=mysql_num_rows($result);
   mysql_free_result($result);
   $total_pages=intval($total_posts/$max_posts);
   if ($total_posts%$max_posts>0) $total_pages++;
   
   if ($page>$total_pages && $total_pages>0) //page not found
   {
      $msg_module=$lang['Not_Found'];
      include "./Modules/MSG/index.php";
   }else
   {
      $result=mysql_query("SELECT * FROM {$table_prefix}news WHERE Post_Title LIKE '%".addslashes($str)."%' OR Post_Pre LIKE '%".addslashes($str)."%' OR Post_Full LIKE '%".addslashes($str)."%' ORDER BY Post_ID DESC LIMIT ".(($page-1)*$max_posts).",".($max_posts));
      $counter=0;
      $page_posts_num=mysql_num_rows($result);
	  
	  if (mysql_num_rows($result)==0)
	  {
        $msg_module=$lang['Not_Found'];// no results found!
        include "./Modules/MSG/index.php";
	  }else
      include "./Templates/$template/Modules/Search/results_header.php";
   
      while ($row = mysql_fetch_array($result))
      {
         $counter++;
         $post_id=$row['Post_ID'];
         $post_title=$row['Post_Title'];
         $post_author=$row['Post_Author'];
         $post_date=$row['Post_Date'];
         $post_pre=$row['Post_Pre'];
         $post_views=$row['Post_Views'];

         include "./Templates/$template/Modules/Search/results_index.php";// include search result template page
         if ($counter<$page_posts_num) include "./Templates/$template/Modules/Search/results_seperator.php";
      }
      include "./Templates/$template/Modules/Search/results_footer.php";

      mysql_free_result($result);
      close_db();
   } 
}

?>