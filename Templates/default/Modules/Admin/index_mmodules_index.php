<?PHP
@include_once ("../../../../Common/functions.php");
avoid_direct_access();
?>
          <tr>
            <td nowrap align=center><a href=index.php?Module=Admin&submodule=<?PHP echo $module_name; ?> title="Click to administrate"><?PHP echo $module_name; ?></a></td>
            <td nowrap align=center><a href=index.php?Module=Admin&submodule=Admin&action=mmodules&do=toggle_active&mname=<?PHP echo $module_name; ?> title="Click to toggle"><?PHP echo $module_active; ?></a></td>
            <td nowrap align=center><?PHP CreatPermissionSelect("permission_" . $module_name ,$module_permission); ?></td>
            <td nowrap align=center><?PHP echo $module_ishomemodule; ?></td>
          </tr>            
