<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Index file (users only)  
*   +--------------------------------------------
*/
@include_once ("../../Common/functions.php");
avoid_direct_access();
?>
<html dir="<?PHP echo $lang['dir'];?>">

<head>
<meta http-equiv="Content-Language" content="<?PHP echo $lang['content_lang'];?>">
<meta http-equiv="Content-Type" content="text/html; charset=<?PHP echo $lang['charset'];?>">
<link rel="stylesheet" href="Templates/default/style.css" type="text/css">
<title><?PHP echo $site_title; ?></title>
<style type="text/css">
<!--
body {
	background-color: #ABC6D9;
}
-->
</style>
</head>
<body style="background-image: url('Templates/default/Images/bgt.gif'); background-repeat: repeat" dir="<?PHP echo $lang['dir'];?>">
<table style="border-collapse: collapse; font-size: 9pt;" border="0" bordercolor="#808080;" cellpadding="0" height="90%" width="100%">
  <tr>
    <td width="100%" colspan="3" height="110" style="background-image:url('Templates/default/Images/cellhead.gif'); background-repeat: repeat-x;" >
    <center>
    <table border="0" cellpadding="0" style="border-collapse: collapse; font-size:9pt" width="90%" height="100%" >
     <tr>
       <td><img src="Templates/default/Images/ukh.png" alt="" border=0 align=middle></td>
       <td><img src="Templates/default/Images/Logo.png" alt="" border=0 align=middle></td>
     </tr>
    </table>
           <p>&nbsp;</p>
           <table width="1235" border="0">
<tr><td align="center" background="Templates/default/Images/highlights.gif" width="78"></td>
	<td style="padding-left: 1px; padding-right: 1px;" bgcolor="#4476A1" 
height="20">
	
<marquee class="smallsizeWhite" id="tmpScorl003" 
onmouseover="this.scrollDelay=70" onMouseOut="this.scrollDelay=25" 
truespeed="" scrollamount="1" scrolldelay="25" >	
Test News Coming Soon  &nbsp;&nbsp;&nbsp;More News Here
</marquee>
	
	</td>
	</tr>
    </table>
    </center>
    </td>
  </tr>
  <tr>
    <td width="20%" align="center" valign="top" style="padding:10">
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-size:9pt" bordercolor="#b1b1b1" width="100%">
        <tr>
          <th width="100%" bgcolor="#7CA5C9" background-repeat: repeat-x; border-bottom:0px" height="18">
          <?PHP echo $lang['Welcome'].' '.$_SESSION['Username'];?>

          </th>
        </tr>
        <tr>
          <td width="100%" valign="top" style="padding:10">
          <?php if ($_SESSION['User_Level']==10) echo '<font color=#a0800E><img src="Templates/default/Images/bullet_Li.gif"></font><a href=index.php?Module=Admin>'.$lang['Admin_Panel'].'</a><br>'; ?>
          <font color=#a0800E><img src="Templates/default/Images/bullet_Li.gif"></font><a href=index.php?Module=User_Settings&uid=<?PHP echo $_SESSION['User_ID'].'>'.$lang['User_Setting'];?></a><br>
          <font color=#a0800E><img src="Templates/default/Images/bullet_Li.gif"></font><a href=index.php?Module=Login&Action=Logout><?PHP echo $lang['Logout']; ?></a><br>

          </td>
        </tr>
      </table>
      <br>
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-size:9pt" bordercolor="#b1b1b1" width="100%">
        <tr>
          <th width="100%" bgcolor="#7CA5C9" background-repeat: repeat-x; border-bottom:0px" height="18">
          <?PHP echo $lang['Navigation'];?>

          </th>
        </tr>
        <tr>
          <td width="100%" valign="top" style="padding:10">
          <div id="button">
  <ul>
    <li><a href=index.php ><?PHP echo $lang['Home'];?></a></li>
    <li><a href=index.php?Module=News ><?PHP echo $lang['News'];?></a></li>
    <li><a href=index.php?Module=Downloads ><?PHP echo $lang['Downloads'];?></a></li>
    <li><a href=index.php?Module=Categories ><?PHP echo $lang['Categories'];?></a></li>
    <li><a href=index.php?Module=Search ><?PHP echo $lang['Search'];?></a></li>
    <li><a href=index.php?Module=Members ><?PHP echo $lang['Members'];?></a></li>
    <li><a href=/cms/ukh/Templates/default/contact.php >Staff</a></li>
  </ul>
</div>

          </td>
        </tr>
      </table>
      <br>
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-size:9pt" bordercolor="#b1b1b1" width="100%" >
        <tr>
          <th width="100%" bgcolor="#7CA5C9" background-repeat: repeat-x; border-bottom:0px" height="18">
          <img src="Templates/default/Images/cat.png" width="16" height="16" align="left"><?PHP echo $lang['News_Categories']; ?>

          </th>
        </tr>
        <tr>
          <td width="100%" valign="top" style="padding:10">
          <?PHP $catmodule='News'; include "./Blocks/Cats/index.php"; ?>
          </td>
        </tr>
      </table>
      <br>
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-size:9pt" bordercolor="#b1b1b1" width="100%" >
        <tr>
          <th width="100%" bgcolor="#7CA5C9" background-repeat: repeat-x; border-bottom:0px" height="18">
          <img src="Templates/default/Images/news.png" width="16" height="16" align="left"><?PHP echo $lang['Last_News']; ?>

          </th>
        </tr>
        <tr>
          <td width="100%" valign="top" style="padding:10">
          <?PHP $num=10; include "./Blocks/LastNews/index.php"; ?>
          </td>
        </tr>
      </table>
    </td>
    <td width="60%" align="center" valign="top" style="padding:10">
    <?PHP include $cur_module; ?>

    </td>
  
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-size:9pt" bordercolor="#b1b1b1" width="100%" >
        <tr>
         <th width="100%" bgcolor="#7CA5C9" background-repeat: repeat-x; border-bottom:0px" height="18">
          <img src="Templates/default/Images/search.png" width="16" height="16" align="left"><?PHP echo $lang['Search']; ?>

          </th>
        </tr>
        <tr>
          <td width="100%" valign="top" style="padding:10">
          <?PHP include "./Blocks/Search/index.php"; ?>
          &nbsp;</td>
        </tr>
      </table>
      <br>	  
    </td>	
  </tr>
</table>

<p align="center"><font color="#808080"><?PHP echo $copyright; ?>- Developed by: <a href=http://www.rudykaka.com target="_blank">Rudy Kaka</a> IT 301 project<a href="#"><img src="Templates/default/Images/content_backToTop.gif" alt="" width="82" height="19" border="0" align="right"></a><br><?PHP echo $lang['GenerationTime']; ?> <?PHP $pagegen->stop();  echo $pagegen->gen(); ?> <?PHP echo $lang['sec']; ?></font></p>

</body>

</html>