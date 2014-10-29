<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
    <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-size:9pt" bordercolor="#111111" width="100%"><tr><td>
    <table border="0" cellspacing="0" style="border-collapse: collapse; font-size:9pt" bordercolor="#111111" width="100%">
      <tr>
        <td width="100%" height=25 style="background-image:url('Templates/default/images/cellpic.gif'); background-repeat: repeat-x; border-right:0px solid">
        <b><?PHP echo $post_title; ?></b>
        </td>
        <td nowrap style="background-image:url('Templates/default/images/cellpic.gif'); background-repeat: repeat-x; border-left:0px solid; border-right:0px solid; padding-left:3px; padding-right:3px;">
        <?PHP echo $lang['Author:']; ?> <?PHP echo $post_author; ?>

        </td>
        <td nowrap style="background-image:url('Templates/default/images/cellpic.gif'); background-repeat: repeat-x; border-left:0px">
        <?php echo $post_date; ?>

        </td>
      </tr>
      <tr>
        <td width="100%" colspan=3 style="padding:5px; border-top:1px solid">
        <?PHP echo $post_pre; ?>

        </td>
      </tr>
      <tr>
        <td width="100%" colspan=2 >
        <?PHP echo $lang['Views:']; ?> <?PHP echo $post_views; ?>
        </td>
        <td nowrap>
        <a href=index.php?Module=News&Action=read&id=<?PHP echo $post_id; ?>><?PHP echo $lang['Read_More']; ?></a>
        </td>
      </tr>
    </table>
    </td></tr></table>