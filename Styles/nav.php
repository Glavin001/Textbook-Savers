<?php 
header("Content-type: text/css"); 
require 'theme.php';

$menuItemWidth = 110;
$menuColumns = 6;
$menuPaddingHor = 30;
$menuPaddingVert = 10;

?>

/* START NAV MENU */
nav {
  background-color:<?PHP echo $darkColour; ?>;
  height:40px;
  display: block;
/*  width: <?PHP echo (($menuItemWidth+$menuPaddingHor)*$menuColumns); ?>px; */
  margin: 0 auto;

  /*** Adding CSS3 Gradients ***/
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?PHP echo $lightColour; ?>), to(<?PHP echo $darkColour; ?>));   
  background:  -moz-linear-gradient(19% 75% 90deg,<?PHP echo $darkColour; ?>, <?PHP echo $lightColour; ?>);   
}

header, footer {
  background-color:<?PHP echo $darkColour; ?>;
  width: 100%;
  
  /*** Adding CSS3 Gradients ***/
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?PHP echo $lightColour; ?>), to(<?PHP echo $darkColour; ?>));   
  background:  -moz-linear-gradient(19% 75% 90deg,<?PHP echo $darkColour; ?>, <?PHP echo $lightColour; ?>);   

  box-shadow: 0px 5px 15px <?PHP echo $shadowColour;?>;
  
  border: 1px solid <?PHP echo $navBorderColour; ?>;
  border-style: outset;
}


header {
  position: fixed;
  top: 0px;
  width: 100%;
/*  
  height: 50px;
  margin: 0 0 50px 0; */
  z-index: 10;
}

/*
footer {
  position: absolute;
  bottom:0;
  width: 100%;
}
*/
 
 
nav ul {
  margin: 0;
  padding: 0;
  list-style: none;
}
 
nav ul li {
  display: block;
  position: relative;
  float: left;

  font-family: <?PHP echo $navTextFontFam; ?>; /* Arial, Verdana; */
  font-size: 20px;
  color: <?PHP echo $defaultTextColour; ?>;
 
}
 
nav li ul { 
  display: none; 
}
 
nav ul li a {
  display: block;
  text-decoration: none;
  padding: 7px 15px 3px 15px;
  background:<?PHP echo $darkColour; ?>;
  color: <?PHP echo $navTextColour; ?>;  
  margin-left: 1px;
  white-space: nowrap;
  height:30px; /* Width and height of top-level nav items */
  width:<?PHP print $menuItemWidth; ?>px;
  text-align:center;
  font-family: <?PHP echo $navTextFontFam; ?>;
  
  /*** Adding CSS3 Gradients ***/
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?PHP echo $lightColour; ?>), to(<?PHP echo $darkColour; ?>));   
  background:  -moz-linear-gradient(19% 75% 90deg,<?PHP echo $darkColour; ?>, <?PHP echo $lightColour; ?>);   
 
}

nav ul li a:link
{
  text-decoration: none;
  font-style: normal;
}

/*
nav ul li.LoginPanel {
  display: block;
  text-decoration: none;
  padding: 7px 15px 3px 15px;
  background: #3A464F;   
  color: #ffffff;  
  margin-left: 1px;
  white-space: nowrap;
  text-align:center;
}
*/
 
nav ul li a:hover { 
	color: <?PHP echo $navTextColour; ?>;
  text-shadow: none;    
	/*border: 1px solid $hoverBorder;*/
  
  /*** Adding CSS3 Gradients ***/
  /*
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?PHP echo $hoverColour; ?>), to(<?PHP echo $hoverColour; ?>));   
  background:  -moz-linear-gradient(19% 75% 90deg,<?PHP echo $hoverColour; ?>, <?PHP echo $hoverColour; ?>);    
*/
  /*** Adding CSS3 Gradients ***/
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?PHP echo $lightColour; ?>), to(<?PHP echo $darkColour; ?>));   
  background:  -moz-linear-gradient(19% 75% 90deg,<?PHP echo $darkColour; ?>, <?PHP echo $lightColour; ?>);   

}

nav ul li a:hover 
{
  border-bottom: <?PHP echo $shadowColour; ?> solid 3px;
  padding-bottom: 0px; /* padding-bottom was 3px. This adjusts for the border-bottom 3px */
}
 
nav li:hover ul {
  display: block;
  position: absolute;
  height:30px;
}
 
nav li:hover li {
  float: none;
  font-size: 11px;

  background-color:<?PHP echo $darkColour; ?>;
 
}
 
nav li:hover a { 

  background: #3A464F; 
  height:30px; /* Height of lower-level nav items is shorter than main level */

  /*** Adding CSS3 Gradients ***/
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?PHP echo $lightColour; ?>), to(<?PHP echo $darkColour; ?>));   
  background:  -moz-linear-gradient(19% 75% 90deg,<?PHP echo $darkColour; ?>, <?PHP echo $lightColour; ?>);   

}
 
nav li:hover li a:hover {  
  color: #3B5998;
	border: 1px solid #3b5998;

  /*** Adding CSS3 Gradients ***/
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?PHP echo $hoverColour; ?>), to(<?PHP echo $hoverColour; ?>));   
  background:  -moz-linear-gradient(19% 75% 90deg,<?PHP echo $hoverColour; ?>, <?PHP echo $hoverColour; ?>);     


}
 
nav ul li ul li a {
    text-align:left; /* Top-level items are centered, but nested list items are left-aligned */
}

nav ul li ul li {
    z-index: 3;
}


nav ul li#copyright a {
  width: 332px;
  /* font-size: 0.7em; */
}
 
nav ul li .notificationCount {
  color: red; 
  border-radius: 2px; 
  background-color: white; 
  padding: 2px;
} 
 
/* END NAV MENU */