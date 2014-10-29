<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
    <form enctype='multipart/form-data' action=index.php?Module=Admin&submodule=Downloads&action=UpdateFile&id=<?php echo $file_id; ?> method=post name=npost>
    <table border="0" cellspacing="0" style="border-collapse: collapse; font-size:9pt" bordercolor="#111111" >
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
        <td nowrap><?PHP echo $lang_downloads['Title']; ?>:</td>
        <td ><input type=text name=title size=20 maxlength=200 value="<?PHP echo htmlspecialchars($file_title); ?>"></td>
      </tr>
      <tr>
        <td nowrap><?PHP echo $lang_downloads['Category']; ?>:</td>
        <td ><?PHP CreatCatSelect("category",$file_cat,'Downloads');?></td>
      </tr>
      <tr>
        <td nowrap><?PHP echo $lang_downloads['Description']; ?>:</td>
        <td ></td>
      </tr>
      <tr>
        <td colspan=2 >
		<textarea name=desc cols=28><?PHP echo htmlspecialchars($file_desc); ?></textarea>
        </td>
      </tr>
      <tr>
        <td nowrap><?PHP echo $lang_downloads['Author']; ?>:</td>
        <td ><input type=text name=author size=20 value="<?PHP echo htmlspecialchars($file_author) ?>" maxlength=50></td>
      </tr>
      <tr>
        <td nowrap><?PHP echo $lang_downloads['Date']; ?>:</td>
        <td >
		<input type=hidden name=idate value=<?PHP echo '1'; ?>>
        <select name=date >
        <option ><?PHP echo htmlspecialchars($file_date); ?></option>
        </select>
        </td>
      </tr>
      <tr>
        <td nowrap><?PHP echo $lang_downloads['Permission']; ?>:</td>
        <td ><?PHP CreatPermissionSelect("permission",$file_perm);?></td>
      </tr>
      <tr>
        <td nowrap><?PHP echo $lang_downloads['Downloads']; ?>:</td>
        <td ><input type=text name=downloads size=20 value="<?PHP echo htmlspecialchars($file_downloads); ?>"></td>
      </tr>
      <tr>
        <td nowrap><?PHP echo $lang_downloads['File']; ?>:</td>
        <td ><input type=file name=file size=20 ></td>
      </tr>	  
      <tr>
        <td colspan=2>&nbsp;</td>
      </tr>
      <tr>
        <td colspan=2 align=center><input type=reset name=reset value="<?PHP echo $lang['Reset']; ?>"><input type=submit name=send value="<?PHP echo $lang['Save']; ?>"></td>
      </tr>
    </table>
    </form>