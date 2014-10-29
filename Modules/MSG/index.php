<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Message module. This is an internal module that other modules use it to display messages.   
*   +--------------------------------------------
*/

@include_once ("../../Common/functions.php");// include the common function file
avoid_direct_access();

global $template, $lang;


include "./Templates/$template/Modules/MSG/index.php";// include the template page for this Module

?>