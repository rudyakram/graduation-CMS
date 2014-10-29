<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
            <tr>
              <td align=center><?PHP echo htmlspecialchars($user_name); ?></td>
              <td align=center><?PHP echo htmlspecialchars($user_register_date); ?></td>
              <td align=center><?PHP echo htmlspecialchars(groupName($user_group)); ?></td>
              <td align=center><?PHP echo htmlspecialchars($user_email); ?></td>
              <td align=center><a href=index.php?Module=Admin&submodule=Members&action=EditUser&id=<?PHP echo $user_id; ?>><img src=Templates/default/images/Edit.gif border=0 width=19 height=19 alt="<?PHP echo $lang_members['Edit_the_user']; ?>"></td>
              <td align=center><a onclick="javascript:return confirmdelete()" href=index.php?Module=Admin&submodule=Members&action=DeleteUser&id=<?PHP echo $user_id; ?>><img src=Templates/default/images/Delete.gif border=0 width=19 height=19 alt="<?PHP echo $lang_members['Delete_the_user']; ?>"></td>
			  
            </tr>
