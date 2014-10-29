<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
            <tr>
              <td align=center><?PHP echo htmlspecialchars($user_name); ?></td>
              <td align=center><?PHP echo htmlspecialchars($user_register_date); ?></td>
              <td align=center><?PHP echo htmlspecialchars(groupName($user_group)); ?></td>
              <td align=center><?PHP echo htmlspecialchars($user_email); ?></td>
            </tr>
