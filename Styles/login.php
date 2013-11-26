<?php 
header("Content-type: text/css"); 
require 'theme.php';
?>

form {
    width: 250px;
    padding: 20px;
    <?php echo "border: 1px solid ".$shadowColour.";"; ?>
    margin: 0 auto; 
     
    /*** Adding in CSS3 ***/
 
    /*** Rounded Corners ***/
    -moz-border-radius: 20px;
    -webkit-border-radius: 20px;
 
    /*** Background Gradient - 2 declarations one for Firefox and one for Webkit ***/
    <?php 
    echo "background-color: ".$lightColour.";";
    echo "background:  -moz-linear-gradient(19% 75% 90deg,".$darkColour.", ".$lightColour.");"; 
    echo "background:-webkit-gradient(linear, 0% 0%, 0% 100%, from(".$lightColour."), to(".$darkColour."));"; 
 
    /*** Shadow behind the box ***/
    echo "-moz-box-shadow:0px -5px 300px ".$shadowColour.";";
    echo "-webkit-box-shadow:0px -5px 300px ".$shadowColour.";";
    ?>
}

form input {
    width: 230px;
    background: <?PHP echo $darkColour; ?>;
    color: #FFF;
    padding: 6px;
    margin-bottom: 10px;
    border-top: 1px solid <?PHP echo $lightColour; ?>;
    border-left: 0px;
    border-right: 0px;
    border-bottom: 0px;
 
    /*** Adding CSS3 ***/
 
    /*** Transition Selectors - What properties to animate and how long ***/
    -webkit-transition-property: -webkit-box-shadow, background;
    -webkit-transition-duration: 0.25s;
 
    /*** Adding a small shadow ***/
    -moz-box-shadow: 0px 0px 2px #000;
    -webkit-box-shadow: 0px 0px 2px #000;
}

form input:hover {
    -webkit-box-shadow: 0px 0px 4px #000;
    background: <?PHP echo $lightColour; ?>;
		color: <?PHP echo $navTextColour; ?>;
}

form input[type=submit] , form input[type=reset] {
    width: 100px;
    color: <?PHP echo $navTextColour; ?>;
    font-weight: bold;
    text-transform: uppercase;
    text-shadow: <?PHP echo $lightColour; ?> 1px 1px;
    border-top: 1px solid <?PHP echo $lightColour; ?>;
    margin-top: 10px;
 
    /*** Adding CSS3 Gradients ***/
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?PHP echo $lightColour; ?>), to(<?PHP echo $darkColour; ?>));   
    background:  -moz-linear-gradient(19% 75% 90deg,<?PHP echo $darkColour; ?>, <?PHP echo $lightColour; ?>);   
}

form p , form label {
    color: <?PHP echo $navTextColour; ?>;
/*    text-transform: uppercase; */
    text-shadow: <?PHP echo $lightColour; ?> 1px 1px;    
}

form a , form a:link {
    font-weight: bold;
    color: <?PHP echo $navTextColour; ?>;
    text-shadow: <?PHP echo $lightColour; ?> 1px 1px;    
}