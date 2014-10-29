<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
            <tr>
              <td align=center><a href=index.php?Module=News&Action=read&id=<?PHP echo $post_id; ?>><?PHP echo $post_title; ?></a></td>
              <td align=center><?PHP echo $post_author; ?></td>
              <td align=center><?PHP echo $post_date; ?></td>
              <td align=center><?PHP echo groupName($post_permission); ?></td>
              <td align=center><?PHP echo $post_catname; ?></td>			  
              <td align=center><?PHP echo $post_views; ?></td>
              <td align=center><a href=index.php?Module=Admin&submodule=News&action=EditPost&id=<?PHP echo $post_id; ?>><img src=Templates/default/Images/Edit.gif border=0 width=19 height=19 alt="<?PHP echo $lang_news['Edit_the_post']; ?>"></td>
              <td align=center><a href=index.php?Module=Admin&submodule=News&action=DeletePost&id=<?PHP echo $post_id; ?>><img src=Templates/default/Images/Delete.gif border=0 width=19 height=19 alt="<?PHP echo $lang_news['Delete_the_post']; ?>"></td>
            </tr>
