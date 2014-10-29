<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     Desc:          Administration manage modules "site content".   
*   +--------------------------------------------
*/

@include_once ("../../Common/functions.php");
avoid_direct_access();
$v=preg_split('/&/',$subvars);//Split string by a regular expression; here the regular expression is the action we take to make a change or update or delete the content
for ($i=0;$i<count($v);$i++) {
 $t=preg_split('/=/',$v[$i]);
 $myvars[$t[0]]=$t[1];// Returns an array containing substrings of subject split along boundaries matched by pattern
}


//open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}modules");


include "./Templates/$template/Modules/Admin/index_mmodules_pre.php";
$cpath.="--><a href=index.php?Module=Admin&submodule=Admin&action=mmodules>{$lang_admin['Manage_Modules']}</a>";

$counter=0;
if (mysql_num_rows($result)>0)
{
   while ($row = mysql_fetch_array($result))
   {
      $counter++;                          // create a counter for adding new modules
      $module_id=$row['ID'];
      $module_name=$row['Name'];
      $module_active=$row['Active'];
      $module_permission=$row['Permission'];
      $module_ishomemodule=$row['IsHomeModule'];

      include "./Templates/$template/Modules/Admin/index_mmodules_index.php";// include the manage module index from temaplaets

      if ($counter<mysql_num_rows($result)) include "./Templates/$template/Modules/Admin/index_mmodules_seperator.php";
   }
}

include "./Templates/$template/Modules/Admin/index_mmodules_end.php";// include the manage module page in tempaltes to show the page for admin in order to manage modules

mysql_free_result($result);
//close_db();


?>