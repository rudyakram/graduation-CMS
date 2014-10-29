<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
<?PHP include_once "./Lang/$language/login.php"; ?>
<br>
<center>
<table border="0" cellpadding="3" cellspacing="0" style="border-collapse: collapse;" >
	<form method="POST" action="index.php?Module=Login&Action=Login">
          <tr>
            <td nowrap>
            <small><?PHP echo $lang_login['Username:']; ?></small>
			
            </td>
            <td>
            <input type=text name=Username size=15 maxlength=20>
            </td>
          </tr>
          <tr>
            <td nowrap>
            <small><?PHP echo $lang_login['Password:']; ?></small>
			
            </td>
            <td>
            <input type=password name=Password size=15 maxlenght=32>
            </td>

          </tr>
		            <tr>
            <td>
            </td>
            <td align=right>
            <input type=Reset name=reset value="<?PHP echo $lang_login['Reset']; ?>">
            <input type=submit name=Login value="<?PHP echo $lang_login['Login']; ?>">
            </td>
          </tr>
		  <tr>
		   <td>&nbsp;</td>
		  </tr> 

    </form>
</table>
</center>