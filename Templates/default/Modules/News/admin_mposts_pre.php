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
          <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#aaaaaa" width="90%">
            <tr>
              <td align=center><font color=#00ADAA><?PHP echo $lang_news['Title']; ?></font></td>
              <td align=center><font color=#00ADAA><?PHP echo $lang_news['Author']; ?></font></td>
              <td align=center><font color=#00ADAA><?PHP echo $lang_news['Date']; ?></font></td>
              <td align=center><font color=#00ADAA><?PHP echo $lang_news['Permission']; ?></font></td>
              <td align=center><font color=#00ADAA><?PHP echo $lang_news['Category']; ?></font></td>
              <td align=center><font color=#00ADAA><?PHP echo $lang_news['Views']; ?></font></td>
              <td align=center><font color=#00ADAA><?PHP echo $lang_news['Edit']; ?></font></td>
              <td align=center><font color=#00ADAA><?PHP echo $lang_news['Delete']; ?></font></td>
            </tr>
