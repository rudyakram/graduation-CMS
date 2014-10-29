<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Function for openning and closing database connection.   
*   +--------------------------------------------
*/

require_once "./Common/config.php";

//open_select_db();

function open_select_db() //connects to mysql and select database
{
    global $db_host,$db_user,$db_pass,$db_name,$con;// define db connection parameters

    $con = mysql_connect($db_host,$db_user,$db_pass);//determine connection strings
    mysql_select_db($db_name,$con);// determine db name, and establish connection
    if (!$con)// if connection paratemters were notindentical establish connection
    {
        die('Could not connect: ' . mysql_error());// otherwise show connection error
    }
}


function close_db()// close connection
{
    global $con;
}


?>