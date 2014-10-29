<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
    <table border="0" cellpadding="30" cellspacing="0" style="border-collapse: collapse;" width="100%">
    <tr><td align=center>
    <table border="1" cellpadding="10" cellspacing="10" style="border-collapse: collapse; font-size:9pt; border: 1px dashed" bordercolor="#111111" width="80%">
      <tr>
        <td width="100%" style="padding:10px;" align=center>
        <center>
        <form name=Login action="index.php?Module=Login&Action=Login" method=Post>
        <script language=javascript>
        function ReloadI(){
           d=new Date();
           document["imgSecCode"].src="Common/ImageVer.php?svar=SecCode&ssid=" + d.getTime();
        }
        </script>
        <table border="0" cellpadding="5" cellspacing="0" style="border-collapse: collapse;" >
<?PHP if ($login_msg !='') { 
echo "          <tr>\n";
echo "            <td colspan=2 align=center>\n";
echo "            <p class=badmsg><b>$login_msg</b><br>&nbsp;</p>\n";
echo "            </td>\n";
echo "          </tr>\n";
          } ?>
          <tr>
            <td nowrap>
            <?PHP echo $lang_login['Username:']; ?>

            </td>
            <td>
            <input type=text name=Username size=15 maxlength=20>
            </td>
          </tr>
          <tr>
            <td nowrap>
            <?PHP echo $lang_login['Password:']; ?>

            </td>
            <td>
            <input type=password name=Password size=15 maxlenght=32>
            </td>
          </tr>
		  <?PHP if ($use_sec_code==1){ ?>
          <tr>
            <td nowrap>
            <?PHP echo $lang_login['Code:']; ?> <a href="javascript:ReloadI();"><font size="1"><small><?PHP echo $lang_login['reload']; ?></a></small></font>
            </td>
            <td>
            <img name="imgSecCode" src="Common/ImageVer.php?svar=SecCode" align=top width=56 height=20 border=0>
            <input type=text name=Seccode size=5 maxlength=5>
            <script language=javascript>
            ReloadI(); //force to refresh
            </script>
            </td>
          </tr>
		  <?PHP } ?>
          <tr>
            <td>
            </td>
            <td>
            <input type=Reset name=reset value="<?PHP echo $lang_login['Reset']; ?>">
            <input type=submit name=Login value="<?PHP echo $lang_login['Login']; ?>">
            </td>
          </tr>
          <tr>
            <td colspan=2 align=center>
            <br><?PHP echo $lang_login['register_msg']; ?>
            </td>
          </tr>
        </table>
        </form>
        </center>
        </td>
      </tr>
    </table>
    </td></tr>
    </table>