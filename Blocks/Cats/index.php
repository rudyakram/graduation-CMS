<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Categories block  
*   +--------------------------------------------
*/

@include_once ("../../Common/functions.php");// include functions file that will be used in this file
avoid_direct_access();//aviod direct access of the page 
include_once "./Common/db.php";// include db configuration "settings" file


include "./Templates/$template/Blocks/Cats/header.php";// include categories block
echo CategoriesList($catmodule);// show the block
include "./Templates/$template/Blocks/Cats/footer.php";//category footer



function CategoriesList($catmodule)
{
global $template;
open_select_db(); //connect to mysql and select db
$cats=Find_Sub_Cats_block(0,$catmodule);


 ob_start();
  include "./Templates/$template/Blocks/Cats/seperator.php";
  $seplen = ob_get_length();
 ob_end_clean();
 
  $cats=substr($cats,0,strlen($cats)-$seplen);
close_db();
return $cats;
}

/////////////////////////////////////////////////////////////////////

function Find_Sub_Cats_block($parent,$catmodule)
{
global $table_prefix,$template,$lang,$lang_cat;
 $childs=mysql_query("SELECT * FROM {$table_prefix}categories WHERE Parent=$parent AND Module='".addslashes($catmodule)."'");
 $cats='';
 
 ob_start();
  include "./Templates/$template/Blocks/Cats/seperator.php";
  $sep = ob_get_contents();
 ob_end_clean();
 
 while ($row = mysql_fetch_array($childs))
 {
  $cat_id=$row['ID'];
  $cat_name=$row['Name'];
  $child=$row['Child'];
  $cat_posts=PostNumsByCat($cat_id,$catmodule);
  
  include "./Templates/$template/Blocks/Cats/cats.php";
  $cats.=$sep;

  $cats.=Find_Sub_Cats_block($cat_id,$catmodule);
 }

return $cats;
} 


?>