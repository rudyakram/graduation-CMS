<?php
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Main index   
*   +--------------------------------------------
*/

include "./Common/config.php";// include db configuration file
if (!isset($db_host) || !isset($db_user) || !isset($db_pass) || !isset($db_name))// if db settings defined correctly...prompt for installation
{ // if not installed redirect to install page
 header("Location: install.php");
 exit;
} 

define('MAIN_LOADED',true); //for perverting modules to run directly

include './Common/page_gen_time.php';// include page time generation file
$pagegen = new page_gen();
$pagegen->round_to = 7;
$pagegen->start();

require "./Common/db.php"; // require the db connection file
open_select_db();

include './Common/functions.php';// include the functions file.....so that we can call any function we want
unregister_globals('_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES'); // this function unset any variable that has been set by user for security reason like remote file inclusion in template

header("Cache-Control: no-cache");// prevent browser cache


//open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}general");
$row = mysql_fetch_array($result);
$site_title=$row['Site_Title']; 
$site_caption=$row['Site_Caption']; 
$template_id=$row['Default_Template']; 
$template=ThemePath($template_id);
$language_id=$row['Default_Language'];
$language=strtolower(LangPath($language_id));
$home_module=$row['Home_Module'];
$copyright=$row['Copyright'];
mysql_free_result($result);
//close_db();

require "./Lang/$language/index.php";// must include langugae file

$module=@$_GET['Module'];// get required modules

if (!isset($module)) $module=$home_module;

//open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}modules WHERE Name='".addslashes($module)."'");
//close_db();


if ( strpos($module,".") || strpos($module,"\\") || strpos($module,"/") || !is_file("./Modules/$module/index.php") || mysql_num_rows($result)==0)
{
   $msg_module=$lang['Not_Found'];//if language not found
   $cur_module="./Modules/MSG/index.php";// show error msg
}else
{
   $cur_module="./Modules/$module/index.php";// include index module
}

session_start();// start new session
unregister_globals('_SESSION');// turn off global vars
ob_start();//avoid sending headers, maybe modules want to change it (like redirections)
if (@$_SESSION['LoggedIn'])// if users is loggen 
{
  include "./Templates/$template/index_logged.php";// show logged in index page
}else
{
  include "./Templates/$template/index.php";// else show public index page
}
ob_end_flush();

close_db();
?>