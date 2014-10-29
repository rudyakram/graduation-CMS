<?PHP

/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Index file (public "vistors")  
*   +--------------------------------------------
*/
@include_once ("../../Common/functions.php");
avoid_direct_access();
?>
<html dir="<?PHP echo $lang['dir'];?>">

<head>
<LINK REL=StyleSheet HREF="Templates/default/menu.css" TYPE="text/css" TITLE="8-bit Color Style" MEDIA="screen, print">
<meta http-equiv="Content-Language" content="<?PHP echo $lang['content_lang'];?>">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="Templates/default/style.css" type="text/css">
<title><?PHP echo $site_title; ?></title>
<style type="text/css">
<!--
body {
	background-color: #ABC6D9;
}
-->
</style></head>
<body dir="<?PHP echo $lang['dir'];?>">
<table style="border-collapse: collapse; font-size: 9pt;" border="0" bordercolor="#808080;" cellpadding="0" height="90%" width="100%">
  <tr>
    <td width="100%" colspan="3" height="110" ><center>
<table border="0" cellpadding="0" style="border-collapse: collapse; font-size:9pt" width="90%" height="100%" >
        <tr>
       <td>
       <img src="Templates/default/Images/ukh.png" border=0 align=middle>
       </td>
       <td>
         <p><img src="Templates/default/Images/logo.png" width="529" height="62"></p></td>
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
  <tr>
    <td width="20%" align="center" valign="top" style="padding:10">
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-size:9pt" bordercolor="#b1b1b1" width="100%">
        <tr>
        <tr>
          <th width="100%" bgcolor="#7CA5C9" background-repeat: repeat-x; border-bottom:0px" height="18">
          <img src="Templates/default/Images/home.png" width="16" height="16" align="left"><?PHP echo $lang['Navigation']; ?>

          </th>
        </tr>
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
          &nbsp;</td>
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
          <?PHP $num=10; /*$orderby="Post_Views DESC";*/ include "./Blocks/LastNews/index.php"; ?>
          &nbsp;</td>
        </tr>
      </table>
</td>

    <td width="60%" align="center" valign="top" style="padding:10">
      <p>
        <?PHP include $cur_module; ?>
      </p>
      <p>&nbsp;
    </p></td>
    <td width="20%" align="center" valign="top" style="padding:10">
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-size:12pt" bordercolor="#b1b1b1" width="100%" >
      <tr>
          <th width="100%"bgcolor="#7CA5C9" border-bottom:0px" height="20"><table width="110" border="0" >
  <tr>
    <td width="53" scope="row"><img src="Templates/default/Images/gb.png" width="16" height="11"> <strong>Eng</strong></td>
    <td width="38" scope="row"><img src="Templates/default/Images/ku.png" width="16" height="11"><strong> Kur</strong></td>
  </tr>
</table>


        <tr>
          <td width="100%" valign="top" style="padding:10">&nbsp;

          </td>
        </tr>
        <br>
        <tr>
          <th width="100%" bgcolor="#7CA5C9"; border-bottom:0px" height="18"><img src="Templates/default/Images/login.png" alt="user" width="16" height="16" align="left">&nbsp;<?PHP echo $lang['Login']; ?>

          </th>
        </tr>
        <tr>
          <td width="100%" valign="top" style="padding:10">
          <?PHP include "./Blocks/Login/index.php"; ?>
          &nbsp;</td>
        </tr>
      </table>
	  <br>
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
        <tr>
          <th width="100%" bgcolor="#7CA5C9" background-repeat: repeat-x; border-bottom:0px" height="18">
          <img src="Templates/default/Images/apply.png" width="16" height="16" align="left">Apply for UKH

          </th>
        </tr>
        <tr>
          <td width="100%" valign="top" style="padding:10">
          <?PHP include "./Blocks/ads/index.php"; ?>
          &nbsp;</td>
        </tr>
                <th width="100%" bgcolor="#7CA5C9"; background-repeat: repeat-x; border-bottom:0px" height="18">
          <img src="Templates/default/Images/follow.png" width="16" height="16" align="left">Follow UKH</th>
        </tr>
        <tr>
          <td width="100%" valign="top" style="padding:10">
         <img src="Templates/default/Images/rss.png" width="48" height="48">&nbsp;<img src="Templates/default/Images/facebook.png" width="48" height="48">&nbsp;<img src="Templates/default/Images/twitter.png" width="48" height="48">&nbsp;<img src="Templates/default/Images/myspace.png" width="48" height="48"></td>
      </table>
	  <br>	  
    </td>
  </tr>
</table>

<p align="center"><font color="#808080"><?PHP echo $copyright; ?> - Developed by: <a href=http://www.rudykaka.com" target="_blank">Rudy Kaka</a> IT 301 project<a href="#"><img src="Templates/default/Images/content_backToTop.gif" width="82" height="19" border="0" align="right"></a><br><?PHP echo $lang['GenerationTime']; ?> <?PHP $pagegen->stop();  echo $pagegen->gen(); ?> <?PHP echo $lang['sec']; ?></font></p>

</body>

</html>