<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
          <center>
          <?PHP
          if ($display_msg==1)
          {
          ?>
          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#aaaaaa" width="90%">
            <tr>
              <td align=center><p class=<?PHP echo $msg_class.'>'.$msg; ?></p></td>
            </tr>
          </table><br>
          <?PHP
          }
          ?>
		  <script language=javascript>
		  function confirmdelete()
		  {
		   var answer=confirm ("Are you sure you want to delete this user?")
		   if (answer)
		    return true;
		   else
		    return false;
		  }
		  </script>
          <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#aaaaaa" width="90%">
            <tr>
              <td align=center><font color=#00ADAA><?PHP echo $lang_members['Username']; ?></font></td>
              <td align=center><font color=#00ADAA><?PHP echo $lang_members['Register_Date']; ?></font></td>
              <td align=center><font color=#00ADAA><?PHP echo $lang_members['User_Group']; ?></font></td>
              <td align=center><font color=#00ADAA><?PHP echo $lang_members['Email']; ?></font></td>
              <td align=center><font color=#00ADAA><?PHP echo $lang_members['Edit']; ?></font></td>			  
              <td align=center><font color=#00ADAA><?PHP echo $lang_members['Delete']; ?></font></td>
            </tr>
