<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
    <form action=index.php?Module=Admin&submodule=News&action=AddPost method=post name=npost>
    <table border="0" cellspacing="0" style="border-collapse: collapse; font-size:9pt" bordercolor="#111111" width="100%">
    <?PHP
    if (@$show_msg==1)
    {
    ?>
      <tr>
        <td colspan=2 align=center><p class=<?PHP if ($t==1) echo 'okmsg'; else echo 'badmsg'; ?>><?PHP echo $news_msg; ?></p></td>
      </tr>
      <tr>
        <td colspan=2 >&nbsp;</td>
      </tr>
    <?PHP
    }
    ?>
      <tr>
        <td nowrap><?PHP echo $lang_news['Title']; ?>:</td>
        <td width=100%><input type=text name=title size=20 maxlength=200 value="<?PHP if (isset($_POST['title'])) echo htmlspecialchars($_POST['title']); ?>"></td>
      </tr>
      <tr>
        <td nowrap><?PHP echo $lang_news['Category']; ?>:</td>
        <td width=100%><?PHP if (isset($_POST['category'])) $sel= $_POST['category']; else $sel= 0; CreatCatSelect("category",$sel,'News');?></td>
      </tr>
      <tr>
        <td nowrap><?PHP echo $lang_news['Preview']; ?>:</td>
        <td width=100%></td>
      </tr>
      <tr>
        <td colspan=2 width=100%>
        <?PHP
        include("./Common/FCKEditor/fckeditor.php") ;
        $oFCKeditor = new FCKeditor('FCKeditor1') ;
        $oFCKeditor->BasePath= './Common/FCKEditor/' ;
        $oFCKeditor->Height= 300 ;
        $oFCKeditor->Config['SkinPath'] = './skins/silver/';
//        $oFCKeditor->Config['AutoDetectLanguage'] = false ;
//        $oFCKeditor->Config['DefaultLanguage'] = 'en' ;
        $oFCKeditor->Value=@$_POST['FCKeditor1'];
        $oFCKeditor->Create() ;
        ?>
        </td>
      </tr>
      <tr>
        <td nowrap><?PHP echo $lang_news['Continue']; ?>:</td>
        <td width=100%></td>
      </tr>
      <tr>
        <td colspan=2 width=100%>
        <?PHP
        $oFCKeditor2 = new FCKeditor('FCKeditor2') ;
        $oFCKeditor2->BasePath= './Common/FCKEditor/' ;
        $oFCKeditor2->Height= 300 ;
        $oFCKeditor2->Config['SkinPath'] = './skins/silver/';
//        $oFCKeditor2->Config['AutoDetectLanguage'] = false ;
//        $oFCKeditor2->Config['DefaultLanguage'] = 'fa' ;
        $oFCKeditor2->Value=@$_POST['FCKeditor2'];
        $oFCKeditor2->Create() ;
        ?>
        </td>
      </tr>
      <tr>
        <td nowrap><?PHP echo $lang_news['Author']; ?>:</td>
        <td width=100%><input type=text name=author size=20 value="<?PHP if (isset($_POST['author'])) echo htmlspecialchars($_POST['author']); else echo $_SESSION['Username']; ?>" maxlength=50></td>
      </tr>
      <tr>
        <td nowrap><?PHP echo $lang_news['Date_Format']; ?>:</td>
        <td width=100%>
		<input type=hidden name=idate value=<?PHP if (isset($_POST['idate'])) echo $_POST['idate']; else echo '1'; ?>>
        <select name=date >
        <option <?PHP if (@$_POST['idate']==1 || !isset($_POST['idate'])) echo "selected"; ?> onclick="javascript:npost.idate.value=1;"><?PHP echo zonedate('Y/m/d',3.5,false); ?></option>
        <option <?PHP if (@$_POST['idate']==2) echo "selected"; ?> onclick="javascript:npost.idate.value=2;"><?PHP echo zonedate("Y/m/d H:i:s", 3.5, false); ?></option>
        <option <?PHP if (@$_POST['idate']==3) echo "selected"; ?> onclick="javascript:npost.idate.value=3;"><?PHP echo zonedate("Y/m/d h:i:s A", 3.5, false); ?></option>
        <option <?PHP if (@$_POST['idate']==4) echo "selected"; ?> onclick="javascript:npost.idate.value=4;"><?PHP echo zonedate('D j M Y',3.5,false); ?></option>
        <option <?PHP if (@$_POST['idate']==5) echo "selected"; ?> onclick="javascript:npost.idate.value=5;"><?PHP echo zonedate('D j M Y H:i:s',3.5,false); ?></option>
        <option <?PHP if (@$_POST['idate']==6) echo "selected"; ?> onclick="javascript:npost.idate.value=6;"><?PHP echo zonedate('D j M Y h:i:s A',3.5,false); ?></option>
        <option <?PHP if (@$_POST['idate']==7) echo "selected"; ?> onclick="javascript:npost.idate.value=7;"><?PHP echo zonedate("l dS \of F Y", 3.5, false); ?></option>
        <option <?PHP if (@$_POST['idate']==8) echo "selected"; ?> onclick="javascript:npost.idate.value=8;"><?PHP echo zonedate("l dS \of F Y H:i:s", 3.5, false); ?></option>
        <option <?PHP if (@$_POST['idate']==9) echo "selected"; ?> onclick="javascript:npost.idate.value=9;"><?PHP echo zonedate("l dS \of F Y h:i:s A", 3.5, false); ?></option>
        </select>
        </td>
      </tr>
      <tr>
        <td nowrap><?PHP echo $lang_news['Permission']; ?>:</td>
        <td width=100%><?PHP if (isset($_POST['permission'])) $sel= $_POST['permission']; else $sel= 0; CreatPermissionSelect("permission",$sel);?></td>
      </tr>
      <tr>
        <td nowrap><?PHP echo $lang_news['Views']; ?>:</td>
        <td width=100%><input type=text name=views size=20 value="<?PHP if (isset($_POST['views'])) echo htmlspecialchars($_POST['views']); else echo 0; ?>"></td>
      </tr>
      <tr>
        <td colspan=2>&nbsp;</td>
      </tr>
    </table>
    <table border="0" cellspacing="0" style="border-collapse: collapse; font-size:9pt" bordercolor="#111111" width="100%">
      <tr>
        <td width=100%>&nbsp;</td>
        <td nowrap><input type=reset name=reset value="<?PHP echo $lang['Reset']; ?>"><input type=submit name=send value="<?PHP echo $lang['Send']; ?>"></td>
      </tr>
    </table>
    </form>