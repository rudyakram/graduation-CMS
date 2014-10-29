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
		<script language=javascript>
		function checkform()
		{
     	if (Login.Username.value=="")
		 {
		  alert('Username empty!');
		  return false;
		 }
		if (Login.Password.value=="")
		 {
		  alert('Password empty!');
		  return false;
		 }
		if (Login.Password.value!=Login.Password_confirm.value)
		 {
		  alert('Password does not match!');
		  return false;
		 }
		if (Login.email.value=="")
		 {
		  alert('Email empty!');
		  return false;
		 }
		if (Login.Seccode.value=="")
		 {
		  alert('Security code empty!');
		  return false;
		 }

		 return true;
		}
		</script>
        <form name=Login action="index.php?Module=Register&Action=Register" method=Post onsubmit="javascript:return checkform();">
        <script language=javascript>
        function ReloadI(){
           d=new Date();
           document["imgSecCode"].src="Common/ImageVer.php?svar=Reg_SecCode&ssid=" + d.getTime();
        }
        </script>
        <table border="0" cellpadding="5" cellspacing="0" style="border-collapse: collapse;" >
<?PHP if ($reg_msg !='') { 
echo "          <tr>\n";
echo "            <td colspan=2 align=center>\n";
echo "            <p class=badmsg><b>$reg_msg</b><br>&nbsp;</p>\n";
echo "            </td>\n";
echo "          </tr>\n";
          } ?>
          <tr>
            <td nowrap>
            <?PHP echo $lang_register['Username']; ?>:

            </td>
            <td>
            <input type=text name=Username size=15 maxlength=31>
            </td>
          </tr>
          <tr>
            <td nowrap>
            <?PHP echo $lang_register['Password']; ?>:

            </td>
            <td>
            <input type=password name=Password size=15 maxlenght=32>
            </td>
          </tr>
          <tr>
            <td nowrap>
            <?PHP echo $lang_register['Confirm_Password']; ?>:

            </td>
            <td>
            <input type=password name=Password_confirm size=15 maxlenght=32>
            </td>
          </tr>
          <tr>
            <td nowrap>
            <?PHP echo $lang_register['Mail']; ?>:

            </td>
            <td>
            <input type=text name=email size=15 maxlenght=50>
            </td>
          </tr>
          <tr>
            <td nowrap>
            <?PHP echo $lang_register['Code']; ?>: <a href="javascript:ReloadI();"><font size="1"><small><?PHP echo $lang_register['reload']; ?></a></small></font>
            </td>
            <td>
            <img name="imgSecCode" src="Common/ImageVer.php?svar=Reg_SecCode" align=top width=56 height=20 border=0>
            <input type=text name=Seccode size=5 maxlength=5>
            <script language=javascript>
            ReloadI(); //force to refresh
            </script>
            </td>
          </tr>
          <tr>
            <td>
            </td>
            <td>
            <input type=Reset name=reset value="<?PHP echo $lang_register['Reset']; ?>">
            <input type=submit name=Login value="<?PHP echo $lang_register['Register']; ?>">
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