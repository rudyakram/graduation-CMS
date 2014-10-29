<?php
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     Desc:          Installation file,please DELTEE this file after you finish installtion for security reasons!  
*   +--------------------------------------------
*/



include "./Common/db.php";// include db connection file
include './Common/functions.php';// include functions file
@session_start();// start a new session
unregister_globals('_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES','_SESSION');// this function unset any variable that has been set by user for security reason like remote file inclusion in template

header("Cache-Control: no-cache");// prevent browser cache

if (isset($db_host) && isset($db_user) && isset($db_pass) && isset($db_name) && !isset($_SESSION['InstallStep'])) 
{ //already installed! redirect to home page
 header("Location: index.php");
 exit;
} 


$step=@$_GET['Step'];// Determine if a variable "setup" is set and is not NULL

if (!isset($step)) $step=0;// start step 0

$_SESSION['InstallStep']=$step;

switch ($step)
{
 case '0':
  ShowWelcome();
  break;
 case '1':
 if (is_readable("./Common/config.php"))
  {
   if (is_writeable("./Common/config.php"))
    ShowStep1();
   else 
    ShowError("The File (root)/Common/config.php is not writeable! Please set write permission on the file.",0);
  }
  else
   ShowError("The File (root)/Common/config.php is not readable! If the file doesn't exist, please create file.",0);
  break;   
 case '2':
  $db_host=$_POST['DB_Host'];
  $db_user=$_POST['DB_User'];
  $db_pass=$_POST['DB_Pass'];
  $db_name=$_POST['DB_Name'];
  $table_prefix=$_POST['TB_Pre'];
  if ( strpos($table_prefix,".") || strpos($table_prefix,"\\") || strpos($table_prefix,"/"))
  {
   ShowError('Invalid table prefix!',1);
   break;
  }
  $con = @mysql_connect($db_host,$db_user,$db_pass);
  if (!$con) ShowError(mysql_error(),1);
  else
  {
   $res=mysql_select_db($db_name,$con);
   if (!$res) 
    ShowError(mysql_error(),1);
   else
   {
    $res=CreateTables();	
    if ($res) ShowStep2();
   }
  } 
  break;  
 case '3':
  $st_title=$_POST['title'];
  $st_caption=$_POST['caption'];
  $st_template=$_POST['template'];
  $st_language=$_POST['language'];
  $st_copyright=$_POST['copyright'];
  $con = @mysql_connect($db_host,$db_user,$db_pass);
  if ($con)
   $res=mysql_select_db($db_name,$con);
  if ($res)
   @mysql_query("REPLACE INTO `{$table_prefix}general` (`Site_Title`, `Site_Caption`, `Default_Template`, `Default_Language`, `Home_Module`, `Copyright`) VALUES ('".$st_title."','".$st_caption."','".$st_template."','".$st_language."','News','".$st_copyright."');", $con);
  if ($res) 
   unset($_SESSION['InstallStep']);
   ShowFinished();
  break;
 case '21':
  ShowStep2();
  break;
 
}

function CreateTables()// a function for creating db tables
{
    Global $con,$db_host,$db_user,$db_pass,$db_name,$table_prefix;
    $res = @mysql_query("CREATE TABLE IF NOT EXISTS `{$table_prefix}general` (`Site_Title` varchar(100) DEFAULT NULL,`Site_Caption` varchar(50) DEFAULT NULL,`Default_Template` int(20) DEFAULT NULL,`Default_Language` int(20) DEFAULT NULL,`Home_Module` varchar(20) DEFAULT NULL,`Copyright` varchar(100) DEFAULT NULL) ENGINE=InnoDB ;", $con);
    $res = @mysql_query("CREATE TABLE IF NOT EXISTS `{$table_prefix}groups` (`ID` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,`Name` varchar(50) DEFAULT NULL, `Permission` tinyint(3) unsigned DEFAULT NULL,PRIMARY KEY (`ID`)) ENGINE=InnoDB ;", $con);
    $res = @mysql_query("REPLACE INTO `{$table_prefix}groups` (`ID`, `Name`, `Permission`) VALUES (1,'Anyone',0),(2,'Registered Users',1),(3,'Administrators',10);", $con);
    $res = @mysql_query("CREATE TABLE IF NOT EXISTS `{$table_prefix}languages` (`ID` int(10) unsigned NOT NULL AUTO_INCREMENT,`Name` char(50) DEFAULT NULL,`Path` char(50) DEFAULT NULL,PRIMARY KEY (`ID`),KEY `ID` (`ID`)) ENGINE=InnoDB ;", $con);
    $res = @mysql_query("REPLACE INTO `{$table_prefix}languages` (`ID`, `Name`, `Path`) VALUES ('1','English','English'),('2','Kurdish','Kurdish');", $con);
    $res = @mysql_query("CREATE TABLE IF NOT EXISTS `{$table_prefix}modules` (`ID` int(10) unsigned NOT NULL AUTO_INCREMENT,`Name` varchar(30) DEFAULT NULL,`Active` tinyint(1) unsigned DEFAULT NULL,`Permission` tinyint(3) unsigned DEFAULT NULL,`IsHomeModule` tinyint(1) unsigned DEFAULT NULL,PRIMARY KEY (`ID`)) ENGINE=InnoDB ;", $con);
    $res = @mysql_query("REPLACE INTO `{$table_prefix}modules` (`ID`, `Name`, `Active`, `Permission`, `IsHomeModule`) VALUES ('1','News',1,0,1),('2','Admin',1,10,0),('3','Login',1,0,0),('4','Register',1,0,0),('5','User_Settings',1,1,0),('6','Members',1,1,0),('7','Search',1,0,0),('8','Categories',1,0,0),('9','Downloads',1,0,0);", $con);

    $res = @mysql_query("CREATE TABLE `{$table_prefix}categories` (`ID` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,`Module` varchar(50) DEFAULT NULL,`Name` char(50) DEFAULT NULL, `Child` tinyint(3) unsigned DEFAULT '0', `Parent` tinyint(3) unsigned DEFAULT '0', PRIMARY KEY (`ID`)) ;", $con);
    $res = @mysql_query("REPLACE INTO `{$table_prefix}categories` (`ID`, `Module`, `Name`, `Child`, `Parent`) VALUES (null,'News','General',0,0);", $con);
    $res = @mysql_query("REPLACE INTO `{$table_prefix}categories` (`ID`, `Module`, `Name`, `Child`, `Parent`) VALUES (null,'Downloads','All Files',0,0);", $con);

    $res = @mysql_query("CREATE TABLE `{$table_prefix}module_settings` (`Module` varchar(50) DEFAULT NULL, `Setting` varchar(50) DEFAULT NULL, `Value` text) ;", $con);
    $res = @mysql_query("REPLACE INTO `{$table_prefix}module_settings` (`Module`, `Setting`, `Value`) VALUES ('News','Max_Post_in_Preview','10'),('Register','allow_registration','1'),('Login','UseSecurityCode','0');", $con);

    $res = @mysql_query("CREATE TABLE `{$table_prefix}downloads` (`ID` int(10) unsigned NOT NULL AUTO_INCREMENT,`Cat_ID` tinyint(3) unsigned DEFAULT NULL,`Title` varchar(50) DEFAULT NULL,`Added_By` varchar(50) DEFAULT NULL,`Description` text,`Filename` varchar(100) DEFAULT NULL,`Filename_on_disk` varchar(25) DEFAULT NULL,`Date_Added` varchar(50) DEFAULT NULL,`Downloads` int(3) unsigned DEFAULT NULL,`Permission` tinyint(3) unsigned DEFAULT NULL,PRIMARY KEY (`ID`),KEY `ID` (`ID`)) ENGINE=InnoDB ;", $con);
	
    $res = @mysql_query("CREATE TABLE IF NOT EXISTS `{$table_prefix}news` (`Post_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,Cat_ID tinyint(3) unsigned DEFAULT NULL,`Post_Title` varchar(200) DEFAULT NULL,`Post_Author` varchar(50) DEFAULT NULL,`Post_Date` varchar(50) DEFAULT NULL,`Post_Views` int(10) unsigned DEFAULT NULL,`Post_Pre` text,`Post_Full` text,`Post_Permission` tinyint(3) unsigned DEFAULT NULL,PRIMARY KEY (`Post_ID`),KEY `ID` (`Post_ID`)) ENGINE=InnoDB ;", $con);
    $res = @mysql_query("REPLACE INTO `{$table_prefix}news` (`Post_ID`, `Cat_ID`, `Post_Title`, `Post_Author`, `Post_Date`, `Post_Views`, `Post_Pre`, `Post_Full`, `Post_Permission`) VALUES ('1','1','Welcome to UKH','Admin','".date('Y/m/d')."','0','<p><img alt=\"\" src=\"Common/FCKEditor/editor/images/smiley/msn/lightbulb.gif\" />         You have successfully installed <a href=\"http://rudykaka.net/\">UKH</a> 1.02 <br />\r\nNow you can manage your site <img alt=\"\" src=\"Common/FCKEditor/editor/images/smiley/msn/thumbs_up.gif\" /></p>','<p>You can delete this post at any time.</p>',0);", $con);
    $res = @mysql_query("CREATE TABLE IF NOT EXISTS `{$table_prefix}templates` (`ID` int(10) unsigned NOT NULL AUTO_INCREMENT,`Name` char(50) DEFAULT NULL,`Path` char(50) DEFAULT NULL,PRIMARY KEY (`ID`),KEY `ID` (`ID`)) ENGINE=InnoDB ;", $con);
    $res = @mysql_query("REPLACE INTO `{$table_prefix}templates` (`ID`, `Name`, `Path`) VALUES ('1','Default','default');", $con);
    $res = @mysql_query("CREATE TABLE IF NOT EXISTS `{$table_prefix}users` (`ID` int(4) unsigned NOT NULL AUTO_INCREMENT,`Username` varchar(30) DEFAULT NULL,`Password` varchar(32) DEFAULT NULL,`Email` varchar(50) DEFAULT NULL,`Register_Date` varchar(50) DEFAULT NULL,`Group` tinyint(3) unsigned DEFAULT '1',KEY `ID` (`ID`)) ENGINE=InnoDB ;", $con);
    $res = @mysql_query("REPLACE INTO `{$table_prefix}users` (`ID`, `Username`, `Password`, `Email`, `Register_Date`, `Group`) VALUES (1,'Admin','21232f297a57a5a743894a0e4a801fc3',NULL,'".date('Y/m/d')."',10)", $con);
	
	$config_file="<?PHP\n".// add the connection parameters to config.php (update the file with new parameters)
				 "/* UKH auto-generated configuration file */\n".
				 "\$db_host\t= '".$db_host."';\n".
				 "\$db_user\t= '".$db_user."';\n".
				 "\$db_pass\t= '".$db_pass."';\n".
				 "\$db_name\t= '".$db_name."';\n".
				 "\$table_prefix\t= '".$table_prefix."';\n".
				 "?>";
	echo $config_file;
    $cf_handle = @fopen('./Common/config.php', 'w');
	if (!$cf_handle) {
	 ShowError("Can't write config file! Save following text into file ./Common/config.php<br><textarea rows=8 cols=50 name=config>".$config_file."</textarea>",21);// show error message if configuration file was not created
 	 return false;
	}else
	{
     fwrite($cf_handle, $config_file);
     fclose($cf_handle);
	 return true;
	} 
}

function ShowWelcome() //step0
{
?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Install IT 301 Projcet |Rudy Kaka|</title>
</head>

<body>

<div align="center">
  <center>

<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"width="100%" height="100%">
  <tr>
    <td width="100%" align="center">
<div align="center">
  <center>
  <table border="1" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="520" height="260" cellpadding="9">
    <tr>
      <td width="100%" bordercolor="#111111" bgcolor="#ABFCCB" height="40"><b>
      <font face="Verdana" color="#003399">IT 301 Project Installation - Step 0</font></b></td>
    </tr>
    <tr>
      <td width="100%" height="177" valign="top"><font face="Verdana" size="2">
      First of all set read/write permission on the <b>(root)/Common/config.php</b> 
      file.</font><p><font face="Verdana" size="2">Once you have done the 
      permission setting click <a href="install.php?Step=1">here</a> to 
      continue.</font></td>
    </tr>
  </table>
  </center>
</div>
    </td>
  </tr>
</table>

  </center>
</div>

</body>

</html>
<?php
}


function ShowStep1() //step1
{
?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Install IT 301 Projcet |Rudy Kaka|</title>
</head>

<body>

<div align="center">
  <center>

<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"width="100%" height="100%">
  <tr>
    <td width="100%" align="center">
<div align="center">
  <center>
  <table border="1" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="520" height="260" cellpadding="9">
    <tr>
      <td width="100%" bordercolor="#111111" bgcolor="#ABFCCB" height="40"><b>
      <font face="Verdana" color="#003399">IT 301 Project Installation - Step 1</font></b></td>
    </tr>
    <tr>
      <td width="100%" height="177" valign="top"><font face="Verdana" size="2">
      Please enter your SQL database details. The DB user must have SELECT, 
      INSERT, UPDATE, DELETE, CREATE rights.<br>
      Create a new database in your MySQL server and enter the name of it or you 
      can use an existing database.<br><BR></font>
	  <form method="post" action="install.php?Step=2">
      <div align="center">
        <center>
        <table border="0" cellpadding="0" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber1">
          <tr>
            <td width="50%"><b><font face="Verdana" size="1">DB Host:</font></b></td>
            <td width="50%"><font face="Verdana" size="1"><b><input type=text name=DB_Host size="10" value="localhost"></b></font></td>
          </tr>
          <tr>
            <td width="50%"><b><font face="Verdana" size="1">DB User:</font></b></td>
            <td width="50%"><font face="Verdana" size="1"><b><input type=text name=DB_User size="10"></b></font></td>
          </tr>
          <tr>
            <td width="50%"><b><font face="Verdana" size="1">DB Pass:</font></b></td>
            <td width="50%"><font face="Verdana" size="1"><b><input type=text name=DB_Pass size="10"></b></font></td>
          </tr>
          <tr>
            <td width="50%"><b><font face="Verdana" size="1">DB Name:</font></b></td>
            <td width="50%"><font face="Verdana" size="1"><b>
            <input type=text name=DB_Name size="10" value="UKH"></b></font></td>
          </tr>
          <tr>
            <td width="50%"><b><font face="Verdana" size="1">Table Prefix:</font></b></td>
            <td width="50%"><font face="Verdana" size="1"><b><input type=text name=TB_Pre size="10" value="<?PHP if (@$_SESSION['tblprefix']=='') echo $_SESSION['tblprefix']=substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"),0,3).'_'; else echo $_SESSION['tblprefix'];?>"></b></font></td>
          </tr>
          <tr>
            <td width="50%" colspan=2>
            <p align="center">
            <input type=submit value="Go" style="float: right"></td>
          </tr>
        </table>
        </center>
      </div>
	  </form>
      </td>
    </tr>
  </table>
  </center>
</div>
    </td>
  </tr>
</table>

  </center>
</div>

</body>

</html>
<?php
}

function ShowStep2()//step2
{
?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Install IT 301 Projcet |Rudy Kaka|</title>
</head>

<body>

<div align="center">
  <center>

<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"width="100%" height="100%">
  <tr>
    <td width="100%" align="center">
<div align="center">
  <center>
  <table border="1" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="520" height="260" cellpadding="9">
    <tr>
      <td width="100%" bordercolor="#111111" bgcolor="#ABFCCB" height="40"><b>
      <font face="Verdana" color="#003399">IT 301 Project Installation - Step 2</font></b></td>
    </tr>
    <tr>
      <td width="100%" height="177" valign="top"><font face="Verdana" size="2">
      Complete your site settings.<br><BR></font>
	  <form method="post" action="install.php?Step=3">
      <div align="center">
        <center>
        <table border="0" cellpadding="0" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber1">
          <tr>
            <td width="50%"><b><font face="Verdana" size="1">Site Title:</font></b></td>
            <td width="50%"><font face="Verdana" size="1"><b>
            <input type=text name=title size="10" value="UKH Simple Site"></b></font></td>
          </tr>
          <tr>
            <td width="50%"><b><font face="Verdana" size="1">Site Caption:</font></b></td>
            <td width="50%"><font face="Verdana" size="1"><b>
            <input type=text name=caption size="10" value="Easy To use CMS"></b></font></td>
          </tr>
          <tr>
            <td width="50%"><b><font face="Verdana" size="1">Site Template:</font></b></td>
            <td width="50%"><font face="Verdana" size="1"><b>
            <?PHP CreatTemplateSelect("template",1); ?>
			</b></font></td>
          </tr>
          <tr>
            <td width="50%"><b><font face="Verdana" size="1">Site Language:</font></b></td>
            <td width="50%"><font face="Verdana" size="1"><b>
            <?PHP CreatLanguageSelect("language",1); ?>
			</b></font></td>
          </tr>
          <tr>
            <td width="50%"><b><font face="Verdana" size="1">Copyright:</font></b></td>
            <td width="50%"><font face="Verdana" size="1"><b>
            <input type=text name=copyright size="10" value="Copyright © 2010, Developed by: Rudy KaKa"></b></font></td>
          </tr>
          <tr>
            <td width="50%" colspan=2>
            <p align="center">
            <input type=submit value="Go" style="float: right"></td>
          </tr>
        </table>
        </center>
      </div>
	  </form>
      </td>
    </tr>
  </table>
  </center>
</div>
    </td>
  </tr>
</table>

  </center>
</div>

</body>

</html>
<?PHP
}


function ShowFinished() //step 3
{
?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Install IT 301 Projcet |Rudy Kaka|</title>
</head>

<body>

<div align="center">
  <center>

<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"width="100%" height="100%">
  <tr>
    <td width="100%" align="center">
<div align="center">
  <center>
  <table border="1" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="520" height="260" cellpadding="9">
    <tr>
      <td width="100%" bordercolor="#111111" bgcolor="#ABFCCB" height="40"><b>
      <font face="Verdana" color="#003399">UKH CMS Installation - Finished!</font></b></td>
    </tr>
    <tr>
      <td width="100%" height="177" valign="top"><font face="Verdana" size="2">
      IT 301 Project Installation, UKH Website CMS Installation was successfully done. Don't forget to delete install.php file for security reasons, Now you can view your 
      website by going to <a href="index.php">home page</a>.<br>
      To administrate your site go to <a href="index.php?Module=Login">Login</a> 
      module and use following username and password:</font><p>
      <font face="Verdana" size="2">Username: admin<br>
      Password: admin<BR></font></p>
      <p><font face="Verdana" size="2">After login <font color="#FF0000">please</font> 
      change your password unlees if you want to make life easier for HACKERZ!</font></td>
    </tr>
  </table>
  </center>
</div>
    </td>
  </tr>
</table>

  </center>
</div>

</body>

</html>
<?PHP
}

function ShowError($msg, $continue_step)
{
?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Install IT 301 Projcet |Rudy Kaka|</title>
</head>

<body>

<div align="center">
  <center>

<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"width="100%" height="100%">
  <tr>
    <td width="100%" align="center">
<div align="center">
  <center>
  <table border="1" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="520" height="260" cellpadding="9">
    <tr>
      <td width="100%" bordercolor="#111111" bgcolor="#ABFCCB" height="40"><b>
      <font face="Verdana" color="#003399">UKH CMS Installation - ERROR!</font></b></td>
    </tr>
    <tr>
      <td width="100%" height="177" valign="top">
      <font face="Verdana" size="2" color="#FF0000"><?PHP echo $msg; ?></font><p>
      <font face="Verdana" size="2">Please fix the error and click
      <a href="install.php?Step=<?PHP echo $continue_step; ?>">here</a> to continue.</font></td>
    </tr>
  </table>
  </center>
</div>
    </td>
  </tr>
</table>

  </center>
</div>

</body>

</html>
<?php
}


?>