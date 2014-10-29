<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
        <form action=index.php?Module=User_Settings&Action=SaveSettings method=post name=usrset onsubmit="javascript:return checkform();">
          <center>
		<script language=javascript>
		function checkform()
		{
		if (usrset.Password_old.value=='' && (usrset.Password_new.value!='' || usrset.Password_new2.value!=''))
		{
		  alert("Please type the old password.");
		  return false;
		}
		if (usrset.Password_new.value!=usrset.Password_new2.value){
		  alert("New password doesn\'t match");
		  return false;
		}
		if (usrset.Password_old.value!='' && (usrset.Password_new.value=='' || usrset.Password_new2.value==''))
		{
		  alert("Please type new password.");
		  return false;
   	    }
		}  
		</script>
        <table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="260">
		<?PHP
		if (@$show_msg==1)
		{
		?>
		<tr>
			<td colspan=2 align=center><p class=<?PHP echo $msg_class.'>'.$set_msg; ?></p></td>
		</tr>
		<tr>
			<td colspan=2 >&nbsp;</td>
		</tr>
		<?PHP
		}
		?>                
          <tr>
            <td width="50%" nowrap><?PHP echo $lang_user_settings['Username']; ?>:</td>
            <td width="50%"><b><?PHP echo $_SESSION['Username']; ?></b></td>
          </tr>
          <tr>
            <td width="50%" nowrap><?PHP echo $lang_user_settings['Email']; ?>:</td>
            <td width="50%"><input type=text name=email value="<?PHP echo htmlspecialchars($_SESSION['User_Email']); ?>" size="20" maxlength=50></td>
          </tr>
          <tr>
            <td width="50%" nowrap><?PHP echo $lang_user_settings['Old_Pass']; ?>:</td>
            <td width="50%"><input type=password name=Password_old value="" size="20" maxlength=32></td>
          </tr>
          <tr>
            <td width="50%" nowrap><?PHP echo $lang_user_settings['New_Pass']; ?>:</td>
            <td width="50%"><input type=password name=Password_new value="" size="20" maxlength=32></td>
          </tr>
          <tr>
            <td width="50%" nowrap><?PHP echo $lang_user_settings['Confirm_Pass']; ?>:</td>
            <td width="50%"><input type=password name=Password_new2 value="" size="20" maxlength=32></td>
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