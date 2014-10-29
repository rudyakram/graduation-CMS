<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
        <form action=index.php?Module=Admin&submodule=Admin&action=global&do=save method=post>
          <center>
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
            <td width="50%" nowrap><?PHP echo $lang_admin['Site_Title']; ?></td>
            <td width="50%"><input type=text name=sitetitle value="<?PHP echo htmlspecialchars($site_title); ?>" size="20" maxlength=100></td>
          </tr>
          <tr>
            <td width="50%" nowrap><?PHP echo $lang_admin['Site_Caption']; ?></td>
            <td width="50%"><input type=text name=sitecaption value="<?PHP echo htmlspecialchars($site_caption); ?>" size="20" maxlength=50></td>
          </tr>
          <tr>
            <td width="50%" nowrap><?PHP echo $lang_admin['Default_Template']; ?></td>
            <td width="50%"><?PHP CreatTemplateSelect("defaulttemplate",$template_id); ?></td>
          </tr>
          <tr>
            <td width="50%" nowrap><?PHP echo $lang_admin['Default_Language']; ?></td>
            <td width="50%"><?PHP CreatLanguageSelect("defaultlanguage",$language_id); ?></td>
          </tr>
          <tr>
            <td width="50%" nowrap><?PHP echo $lang_admin['Home_Module']; ?></td>
            <td width="50%"><input type=text name=homemodule value="<?PHP echo htmlspecialchars($home_module); ?>" size="20" maxlength=20></td>
          </tr>
          <tr>
            <td width="50%" nowrap><?PHP echo $lang_admin['Copyright_String']; ?></td>
            <td width="50%"><input type=text name=copyright value="<?PHP echo htmlspecialchars($copyright); ?>" size="20" maxlength=100></td>
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