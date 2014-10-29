<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
        <form action=index.php?Module=Admin&submodule=Members&action=SaveUser&id=<?PHP echo $row['ID']; ?> method=post name=usrset >
          <center>
        <table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="260">
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
            <td width="50%" nowrap><?PHP echo $lang_members['Username']; ?>:</td>
            <td width="50%"><b><?PHP echo $row['Username']; ?><input name=Username type=hidden value="<?PHP echo htmlspecialchars($row['Username']); ?>"></b></td>
          </tr>
          <tr>
            <td width="50%" nowrap><?PHP echo $lang_members['Email']; ?>:</td>
            <td width="50%"><input type=text name=Email value="<?PHP echo htmlspecialchars($row['Email']); ?>" size="20" maxlength=50></td>
          </tr>
          <tr>
            <td width="50%" nowrap><?PHP echo $lang_members['Password']; ?>:</td>
            <td width="50%"><input type=password name=Password value="" size="20" maxlength=32><small><?PHP echo $lang_members['leave_clear_for_no_change.']; ?></small></td>
          </tr>
          <tr>
            <td width="50%" nowrap><?PHP echo $lang_members['User_Group']; ?>:</td>
            <td width="50%"><?PHP CreatPermissionSelect("Group",$row['Group'],1) ?></td>
          </tr>
		  
        </table>
          </center>
          <center>
          <table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="260">
            <tr>
              <td width="100%">&nbsp;</td>
              <td nowrap><input type=reset name=reset value="<?PHP echo $lang['Reset']; ?>"><input type=submit name=save value="<?PHP echo $lang['Save']; ?>"></td>
            </tr>
          </table>
          </center>
          </form>