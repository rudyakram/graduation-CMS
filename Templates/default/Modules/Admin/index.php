<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
    <table border="0" cellspacing="0" style="border-collapse: collapse; font-size:9pt" bordercolor="#111111" width="100%" cellpadding="7">
      <tr>
        <td  >
          <center>
          <table border="0" cellpadding="6" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
            <tr>
              <td width="25%" align="center">
              <a href=index.php?Module=Admin&submodule=Admin&action=global><img border="0" src="Templates/default/Images/global.png" width="48" height="48"><br>
              <?PHP echo $lang_admin['Global']; ?></a></td>
              <td width="25%" align="center">
              <a href=index.php?Module=Admin&submodule=Admin&action=mmodules><img border="0" src="Templates/default/Images/modulemanage.png" width="52" height="52"><br>
              <?PHP echo $lang_admin['Manage_Modules']; ?></a></td>
              <td width="25%" align="center">
              <a href=index.php?Module=Login&Action=Logout><img border="0" src="Templates/default/Images/logout.png" width="48" height="48"><br>
              <?PHP echo $lang['Logout']; ?></a></td>
            </tr>
          </table>
          </center>
        </td>
      </tr>
      <tr>
        <td colspan=2>
        <hr>
        </td>
      </tr>
      <tr>
        <td colspan=2>
        <?PHP echo $cpath; ?>
        </td>
      </tr>
      <tr>
        <td align=center>
        <?PHP echo $sub_module_out; ?>
        </td>
      </tr>
    </table>
