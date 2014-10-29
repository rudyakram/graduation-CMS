<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Last news block   
*   +--------------------------------------------
*/

@include_once ("../../Common/functions.php");
avoid_direct_access();
include_once "./Common/db.php";

//$num=@$_GET['num'];
if (!is_numeric($num)) $num=10;

open_select_db(); //connect to mysql and select db
$sql="SELECT * FROM {$table_prefix}news ORDER BY ";
if (@$orderby!='') $sql.=$orderby.", ";
$sql.="Post_ID DESC LIMIT 0,".$num; //limit 0,10
$result=mysql_query($sql); //limit 0,10
$counter=0;
if (mysql_num_rows($result)>0)
{
   include "./Templates/$template/Blocks/LastNews/pre.php";// include block part for preview "1st part of the news"
   while ($row = mysql_fetch_array($result))
   {
      $counter++;
      $post_id=$row['Post_ID'];
      $post_title=$row['Post_Title'];
      $post_author=$row['Post_Author'];
      $post_date=$row['Post_Date'];
      $post_pre=$row['Post_Pre'];
      $post_views=$row['Post_Views'];

      //ob_start();
      include "./Templates/$template/Blocks/LastNews/index.php";
      //$out = ob_get_contents();
      //ob_end_clean();
      //$out= substr($out,3);
      //echo $out;

      if ($counter<mysql_num_rows($result)) include "./Templates/$template/Blocks/LastNews/seperator.php";
   }
   include "./Templates/$template/Blocks/LastNews/end.php";
}

mysql_free_result($result);
close_db();

?>