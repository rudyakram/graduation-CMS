<?php
/*  +--------------------------------------------
*   |
*   |     Product:       IT 301 Project | Developing a Driven Database Website for UKH "CMS based"
*   |     Author:        Rudy Kaka
*   |     Supervisor:    Mr. Zinnar Gahsem
*   |     Starting Day:  10/Nov/2009
*   |     Version:       Developed for IT 301 project, may be other langugaes or modules will be added.
*   |     License:       this script was develped for educational purpose only.....don't use it without author's permission.
*   |     Page Desc:     Page generation time class   
*   +--------------------------------------------
*/

class page_gen { // create a class named page_gen for showing page generation time
//
// PRIVATE CLASS VARIABLES
//
var $_start_time;// start page brwosing time
var $_stop_time;// finish page loading time
var $_gen_time;// page generation time

//
// USER DEFINED VARIABLES
//
var $round_to;// Rounds to a float number

//
// CLASS CONSTRUCTOR
//
function page_gen() {// define function page_gen
if (!isset($this->round_to)) {
$this->round_to = 4;// set precicion like 12,300.2
}
}

//
// FIGURE OUT THE TIME AT THE BEGINNING OF THE PAGE
//
function start() {
$microstart = explode(' ',microtime());//the expolde function to split a string by string
$this->_start_time = $microstart[0] + $microstart[1];
}

//
// FIGURE OUT THE TIME AT THE END OF THE PAGE
//
function stop() {
$microstop = explode(' ',microtime());// the expolde function to split a string by string
$this->_stop_time = $microstop[0] + $microstop[1];
}

//
// CALCULATE THE DIFFERENCE BETWEEN THE BEGINNNG AND THE END AND RETURN THE VALUE
//
function gen() {
$this->_gen_time = round($this->_stop_time - $this->_start_time,$this->round_to);
return $this->_gen_time;// show the generation time
}
}
?>