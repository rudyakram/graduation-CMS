<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Common functions used in developing the website  
*   +--------------------------------------------
*/

function avoid_direct_access()// function to prevent direct access of the page
{
unregister_globals('_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');// this function unset any variable that has been set by user for security reason like remote file inclusion in template
if (!defined('MAIN_LOADED')) die ("This file can't be accessed directly.");
}

function unregister_globals()// define unregsiter golobals to prevent RFI attacks
{
    if (!ini_get('register_globals'))
    {
        return false;
    }

    foreach (func_get_args() as $name)
    {
        foreach ($GLOBALS[$name] as $key=>$value)
        {
            if (isset($GLOBALS[$key]))
                unset($GLOBALS[$key]);
        }
    }
}


function get_module_perm($module_name)
{
global $table_prefix;
open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT Permission FROM {$table_prefix}modules WHERE Name='".addslashes($module_name)."'");
$row = mysql_fetch_array($result);
return $row['Permission'];
mysql_free_result($result);
//close_db();
}

///////////////////////////////////////////////////////////////////// functions needed for defining (setting) permissions 

function CreatPermissionSelect($name="permission",$selected=0,$onlyusers=0)
{
global $table_prefix;
open_select_db(); //connect to mysql and select db
$mresult=mysql_query("SELECT * FROM {$table_prefix}groups");

echo '<select name="'.$name.'">';
while ($row = mysql_fetch_array($mresult))
{
 $gp_name=$row['Name'];
 $gp_perm=$row['Permission'];
 if ($onlyusers!=1 || $gp_perm!=0) //do not show anyone for user groups
 {
  echo "<option ";
  if ($selected==$gp_perm ) echo "Selected ";
  echo "value=".$gp_perm.">";
  echo $gp_name;
  echo "</option>";
 } 
}
echo "</select>";
mysql_free_result($mresult);
//close_db();
}

///////////////////////////////////////////////////////////////////// functions needed for creating new languages

function CreatLanguageSelect($name="defaultlanguage",$selected=0)// define function CreateLangugae
{
global $table_prefix;
open_select_db(); //connect to mysql and select db
$mresult=mysql_query("SELECT * FROM {$table_prefix}languages");

echo '<select name="'.$name.'">';
while ($row = mysql_fetch_array($mresult))
{
 $lang_name=$row['Name'];
 $lang_id=$row['ID'];
  echo "<option ";
  if ($selected==$lang_id ) echo "Selected ";
  echo "value=".$lang_id.">";
  echo $lang_name;
  echo "</option>";
}
echo "</select>";
mysql_free_result($mresult);
//close_db();
}

///////////////////////////////////////////////////////////////////// functions needed for creating templates

function CreatTemplateSelect($name="defaulttemplate",$selected=0)
{
global $table_prefix;
open_select_db(); //connect to mysql and select db
$mresult=mysql_query("SELECT * FROM {$table_prefix}templates");

echo '<select name="'.$name.'">';
while ($row = mysql_fetch_array($mresult))
{
 $them_name=$row['Name'];
 $them_id=$row['ID'];
  echo "<option ";
  if ($selected==$them_id ) echo "Selected ";
  echo "value=".$them_id.">";
  echo $them_name;
  echo "</option>";
}
echo "</select>";
mysql_free_result($mresult);
//close_db();
}

/////////////////////////////////////////////////////////////////////functions needed for groups (admin,users...etc)

function groupName($gp_perm)
{
global $table_prefix;
if (!is_numeric($gp_perm)) return "Anyone"; //wrong input-> return lowest
open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}groups WHERE Permission=".addslashes($gp_perm));

if (mysql_num_rows($result)>0)
{
 $row = mysql_fetch_array($result);
 return $row['Name'];
}else return "UNKNOWN";
mysql_free_result($result);
//close_db();
}

///////////////////////////////////////////////////////////////////// functions needed for defining language file path

function LangPath($lang_id)
{
global $table_prefix;
if (!is_numeric($lang_id)) return "English"; //wrong input-> return default
open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}languages WHERE ID=".addslashes($lang_id));

if (@mysql_num_rows($result)>0)
{
 $row = mysql_fetch_array($result);
 return $row['Path'];
}else return "English";
mysql_free_result($result);
//close_db();
}

/////////////////////////////////////////////////////////////////////functions needed for defining template path

function ThemePath($them_id)
{
global $table_prefix;
if (!is_numeric($them_id)) return "default"; //wrong input-> return default
open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}templates WHERE ID=".addslashes($them_id));

if (@mysql_num_rows($result)>0)
{
 $row = mysql_fetch_array($result);
 return $row['Path'];
}else return "default";
mysql_free_result($result);
//close_db();
}


function CreatCatSelect($name="Category",$selected=0,$catmodule) // function for defining category
{
open_select_db(); //connect to mysql and select db
echo '<select name="'.$name.'">';
echo Find_Sub_Cats_Select(0,$selected,$catmodule);
echo '</select>';
//close_db();
}

///////////////////////////////////////////////////////////////////// function for defining sub categories

function Find_Sub_Cats_Select($parent,$selected,$catmodule)
{
global $table_prefix,$template,$lang,$lang_cat;
 $childs=mysql_query("SELECT * FROM {$table_prefix}categories WHERE Parent=$parent AND Module='".addslashes($catmodule)."'");
 $cats='';
  
 while ($row = mysql_fetch_array($childs))
 {
  $cat_id=$row['ID'];
  $cat_name=$row['Name'];
  $child=$row['Child'];
  
  $cats.='<option value='.$cat_id;
  if ($selected==$cat_id) $cats.=' selected ';
  $cats.='>';
  for ($i=1;$i<=$child;$i++) $cats.='... ';
  $cats.=$cat_name.'</option>';

  $cats.=Find_Sub_Cats_Select($cat_id,$selected,$catmodule);
 }

return $cats;
} 

///////////////////////////////////////////////////////////////////// function for getting category name

function getCatname($catid)
{
global $table_prefix;
if (!is_numeric($catid)) return "Deleted";
open_select_db(); //connect to mysql and select db
$result=mysql_query("SELECT * FROM {$table_prefix}categories WHERE ID=".addslashes($catid));

if (mysql_num_rows($result)>0)
{
 $row = mysql_fetch_array($result);
 return $row['Name'];
}else return "Deleted";
mysql_free_result($result);
//close_db();
}

///////////////////////////////////////////////////////////////////// function for arranging posts by categories

function PostNumsByCat($catid,$catmodule)
{
global $table_prefix,$subCats;
if (!is_numeric($catid)) return 0; 

   open_select_db(); //connect to mysql and select db
   $subCats=array($catid);
   Creat_Sub_Cats_Array($catid,$catmodule);
   $total_posts=0;
   foreach ($subCats as $subcatid)
   {
    $result=mysql_query("SELECT * FROM `{$table_prefix}".addslashes(strtolower($catmodule))."` WHERE `Cat_ID`=".$subcatid);  
    $total_posts+=mysql_num_rows($result);
   }
   mysql_free_result($result);
   return $total_posts;
}

/////////////////////////////////////////////////////////////////////

function Creat_Sub_Cats_Array($parent,$catmodule) // this function fills $subCats array with all subcategories id by parent and module sent to it.
{
global $table_prefix,$subCats;
 $childs=mysql_query("SELECT * FROM {$table_prefix}categories WHERE Parent=$parent AND Module='".addslashes($catmodule)."'");
 
 
 while ($row = mysql_fetch_array($childs))
 {
  $cat_id=$row['ID'];
  $subCats[count($subCats)]=$cat_id;
  Creat_Sub_Cats_Array($cat_id,$catmodule);
 }

} 

/////////////////////////////////////////////////////////////////////

function Creat_Sub_Cats_Query($parent,$catmodule)//this is same Sub_Cats_Array function but doesn't fill an array it creates a condition for using in sql.
{
global $table_prefix,$subCatsQuery;
 $childs=mysql_query("SELECT * FROM {$table_prefix}categories WHERE Parent=$parent AND Module='".addslashes($catmodule)."'");
 
 
 while ($row = mysql_fetch_array($childs))
 {
  $cat_id=$row['ID'];
  $subCatsQuery.="Cat_ID=".$cat_id." or ";
  Creat_Sub_Cats_Array($cat_id,$catmodule);
 }

} 

///////////////////////////////////////////////////////////////////// redirect function; it redirect browser to the url specified. (applies for old versions of Mozilla browsers because they don't support automatic redirection); it's optional functions can be removed.

function redirect($url)
{
    $content=<<<HTML
    <meta http-equiv="refresh" content="2; url=$url" />
    <script type='text/javascript'>
    //<![CDATA[
    // Fix Mozilla bug: 209020
    location.href = '$url';
    if ( navigator.product == 'Gecko' )
    {
        navstring = navigator.userAgent.toLowerCase();
        geckonum  = navstring.replace( /.*gecko\/(\d+)/, "$1" );
              
        setTimeout("moz_redirect()",1500);
    }
         
    function moz_redirect()
    {
        var url_bit     = "{$url}";
        window.location = url_bit.replace( new RegExp( "&amp;", "g" ) , '&' );
    }
    //>
    </script>
HTML;
    echo $content;
}
?>