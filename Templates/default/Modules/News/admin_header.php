<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
          <center>
          <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="90%">
            <tr>
              <td width="33%" align=center><a href=index.php?Module=Admin&submodule=News&action=Settings><?PHP echo $lang_news['Settings']; ?></a></td>
              <td width="33%" align=center><a href=index.php?Module=Admin&submodule=News&action=ManagePosts><?PHP echo $lang_news['Manage_Posts']; ?></a></td>
              <td width="33%" align=center><a href=index.php?Module=Admin&submodule=News&action=NewPost><?PHP echo $lang_news['New_Post']; ?></a></td>
            </tr>
          </table>
          </center>
          <br>
