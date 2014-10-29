<?PHP
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     File Desc:     Image verification code "security "file used to prevent spamming by spambots   
*   +--------------------------------------------
*/
include './functions.php';// inlude functions file
$session_var=@$_GET['svar'];// start session
if (($session_var!='SecCode') && ($session_var!='Reg_SecCode')) exit;// if security code & Reg Code is disabled exit & dnt start the session
session_start();// start a new sesion
unregister_globals('_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES', '_SESSION');// this function unset any variable that has been set by user for security reason like remote file inclusion in template

$str = "abcdefghijklmnopqrstuvwxyz1234567890";// define string chars
$randkey = substr(str_shuffle($str),0,5); //5 chars code
$_SESSION[$session_var] = $randkey; //session must have been started before

$image =ImageCreate(56,20);// imagecreatefromjpeg "image hight and width"("./test.jpg");
$font = 3 ;// define font size

$white = imagecolorallocate($image,255,255,255);// function to Allocate a color for an image
$green = imagecolorallocate($image,10,90,40);// function to Allocate a color for an image


ImageFill($image, 0, 0, $white);//Performs a flood fill starting at the given coordinate (top left is 0, 0) with the given color in the image. 

	
$y = (imagesy($image)-imagefontheight($font))/2;	
$x = (imagesx($image)-imagefontwidth($font)*strlen($randkey))/2;
imagestring($image,$font,$x,$y,$randkey,$green);//Draws a string  horizontally at the given coordinates

header("Content-type: image/jpeg");// create a .jpeg image
imagejpeg($image);//Output image to browser or file
imagedestroy($image);//Destroy an image after verfication

?>