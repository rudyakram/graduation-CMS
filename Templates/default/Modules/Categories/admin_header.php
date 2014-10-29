<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
<script type="text/javascript">
<!--

function AddNewCat(parent,child)
{
var catname= prompt("Enter name of new category", "");

if (catname!=null && catname!='')
  window.location='index.php?Module=Admin&submodule=Categories&action=addnewcat&CatModule=<?PHP echo $catmodule; ?>&name='+catname+'&parent='+parent+'&child='+child;  
}


function EditCat(catid,oldcatname)
{
var catname= prompt("Enter new name of the category", oldcatname);

if (catname!=null && catname!='' && catname!=oldcatname)
  window.location='index.php?Module=Admin&submodule=Categories&action=editcat&CatModule=<?PHP echo $catmodule; ?>&catid='+catid+'&newname='+catname;
}


function DeleteCat(catid,catname)
{
var answer= confirm("Are you sure you want to delete '"+catname+"' and all its sub categories?");

if (answer)
  window.location='index.php?Module=Admin&submodule=Categories&action=deletecat&CatModule=<?PHP echo $catmodule; ?>&catid='+catid;

}

//-->

</script>


        <table border="0" cellpadding="5" cellspacing="0" style="border-collapse: collapse;" >
		<?PHP
        if (@$display_msg==1)
        {
        ?>
          <tr>
            <td colspan=2 align=center><p class=<?PHP echo $msg_class.'>'.$msg; ?></p></td>
          </tr>
          <tr>
            <td colspan=2 >&nbsp;</td>
          </tr>
        <?PHP
        }
        ?>
          <tr>
          
		  <td colspan=2 align=center>
<?PHP $module_names=mysql_query("SELECT * FROM {$table_prefix}modules");
 while ($row = mysql_fetch_array($module_names))
 {
  $module_id=$row['ID'];
  echo '<a href=index.php?Module=Admin&submodule=Categories&CatModule='.$row['Name'].'>'.$row['Name'].'</a> ';
  }
  ?>
			</td>
          </tr>
          <tr>
            <td nowrap colspan=2 align=center>
			&nbsp;
            </td>
          </tr>		  
		  <tr>
            <td nowrap colspan=2 align=center>
			<?PHP echo $lang_cat['Cats_Available'].' '.htmlspecialchars($catmodule); ?>
            </td>
          </tr>
		  <tr>
            <td nowrap colspan=2 align=center>
			<a href="javascript:AddNewCat(0,0)"><img border=0 title="Add sub category" src=Templates/default/Images/add.bmp><?PHP echo $lang_cat['Add_new_Cat']; ?></a>
            </td>
          </tr>
		</table>
		<table border="0" cellpadding="5" cellspacing="0" style="border-collapse: collapse;" >
          <tr>
            <td nowrap>
