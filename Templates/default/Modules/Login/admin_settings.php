<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
        <form action=index.php?Module=Admin&submodule=Login&action=SaveSettings method=post>
          <center>
        <table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="270">
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
            <td width="50%"><input type=checkbox name=use_sec_code value=1 <?PHP if ($use_sec_code==1) echo 'checked'; ?>><?PHP echo $lang_login['Use_Sec_Code']; ?></td>
          </tr>
        </table>
          </center>
          <center>
          <table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="270">
            <tr>
              <td width="100%">&nbsp;</td>
              <td nowrap><input type=reset name=reset value="<?PHP echo $lang['Reset']; ?>"><input type=submit name=save value="<?PHP echo $lang['Save']; ?>"></td>
            </tr>
          </table>
          </center>
          </form>