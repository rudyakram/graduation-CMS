<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
            <tr>
              <td align=center><a href=index.php?Module=Downloads&Action=view&id=<?PHP echo $file_id; ?>><?PHP echo $file_title; ?></a></td>
              <td align=center><?PHP echo $file_author; ?></td>
              <td align=center><?PHP echo $file_date; ?></td>
              <td align=center><?PHP echo groupName($file_permission); ?></td>
              <td align=center><?PHP echo $file_catname; ?></td>			  
              <td align=center><?PHP echo $file_size; ?></td>
              <td align=center><?PHP echo $file_downloads; ?></td>
              <td align=center><a href=index.php?Module=Admin&submodule=Downloads&action=EditFile&id=<?PHP echo $file_id; ?>><img src=Templates/default/images/Edit.gif border=0 width=19 height=19 alt="<?PHP echo $lang_downloads['Edit_the_file']; ?>"></td>
              <td align=center><a href=index.php?Module=Admin&submodule=Downloads&action=DeleteFile&id=<?PHP echo $file_id; ?>><img src=Templates/default/images/Delete.gif border=0 width=19 height=19 alt="<?PHP echo $lang_downloads['Delete_the_file']; ?>"></td>
            </tr>
