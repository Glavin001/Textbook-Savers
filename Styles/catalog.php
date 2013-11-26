<?php 
header("Content-type: text/css"); 
require 'theme.php';
?>

/* ===== Catalog ===== */

.catalogTitle {
  text-align: center;
  text-transform: uppercase;
  text-decoration:underline;
  font-size: 2em;
  
}

div.catalogItem , #statsBanner {
  display: block;
  color: <?PHP echo $widgetText; ?>;
  /* background-color: <?PHP echo $widgetBackground; ?>; */
	background-color: <?PHP echo $widgetBorder; ?>;
  border: 0px solid <?PHP echo $widgetBorder; ?>;
  margin: 20px 20px 20px 20px;
  padding: 10px;

  border-radius: 5px;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  -khtml-border-radius: 5px;
}

div.catalogItem div.title {
  display: block;
  margin: 0px;
  background-color: <?PHP echo $widgetTitleBackground; ?>;
  color: <?PHP echo $widgetText; ?>;
  border: 0px solid <?PHP echo $widgetBackground; ?>;
  padding: 5px;
  
  border-radius: 5px 5px 0px 0px;
  -moz-border-radius: 5px 5px 0px 0px;
  -webkit-border-radius: 5px 5px 0px 0px;
  -khtml-border-radius: 5px 5px 0px 0px;
}

div.catalogItem div.details img
{
  margin: 0 5px 0 5px;
}

#statsBanner {
    overflow: auto;
}

#statsBanner div.widget span.value {
    font-weight: bold;
    font-size: 2em;
}

#statsBanner div.widget {
    margin: 0px;
    background-color: <?PHP echo $widgetContentBackground; ?>;
    border: 1px solid <?PHP echo $widgetBackground; ?>;
    padding: 5px;
    
    border-radius: 5px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    -khtml-border-radius: 5px;

    float: left;
    z-index:3;
    /* line-height: 25px; */
    text-align: center;
}


#statsBanner div.widget span.title , #statsBanner div.widget span.value 
{

}


div.catalogItem span.title {
  /*font-weight: bold;*/
  font-family: Impact, Charcoal, sans-serif;
}

div.catalogItem .course {
  width: 100%;
}

div.catalogItem .sellerName, div.sale .price {
  font-weight: bold;
}

div.catalogItem .bid {
  float: right;
}

div.catalogItem .details {
  display: block;
  margin: 0 0px;
  color: <?PHP echo $widgetText; ?>;
  background-color: <?PHP echo $widgetContentBackground; ?>;
  padding: 10px;
  overflow: auto;

  border-top-left-radius: 0px;
  border-bottom-left-radius: 5px;
  border-top-right-radius: 0px;
  border-bottom-right-radius: 5px;
    
  -moz-border-top-left-radius: 0px;
  -moz-border-bottom-left-radius: 5px;
  -moz-border-top-right-radius: 0px;
  -moz-border-bottom-right-radius: 5px;
  
  -webkit-border-top-left-radius: 0px;
  -webkit-border-bottom-left-radius: 5px;
  -webkit-border-top-right-radius: 0px;
  -webkit-border-bottom-right-radius: 5px;

  -khtml-border-top-left-radius: 0px;
  -khtml-border-bottom-left-radius: 5px;
  -khtml-border-top-right-radius: 0px;
  -khtml-border-bottom-right-radius: 5px;
}

div.catalogItem .description {
  font-family: "Trebuchet MS", Helvetica, sans-serif;
}

div.catalogItem a.linkButton:link div, div.catalogItem a.linkButton:active div, div.catalogItem a.linkButton:hover div, div.catalogItem a.linkButton:visited div {
  color: <?PHP echo $navTextColour; ?>;
}
div.catalogItem a.linkButton div {
  background-color: <?PHP echo $lightColour; ?>; 
  width: 75px; 
  height: 40px; 
  padding: 5px;
  float: right;
  text-align: center;
  vertical-align: middle;
  line-height: 20px;
  font-weight: bold;
  
  <?PHP
  $tl = 5;
  $bl = 5;
  $tr = 5;
  $br = 5;
  ?>  
  border-top-left-radius: <?PHP echo $tl; ?>px;
  border-bottom-left-radius: <?PHP echo $bl; ?>px;
  border-top-right-radius: <?PHP echo $tr; ?>px;
  border-bottom-right-radius: <?PHP echo $br; ?>px;
    
  -moz-border-top-left-radius: <?PHP echo $tl; ?>px;
  -moz-border-bottom-left-radius: <?PHP echo $bl; ?>px;
  -moz-border-top-right-radius: <?PHP echo $tr; ?>px;
  -moz-border-bottom-right-radius: <?PHP echo $br; ?>px;
  
  -webkit-border-top-left-radius: <?PHP echo $tl; ?>px;
  -webkit-border-bottom-left-radius: <?PHP echo $bl; ?>px;
  -webkit-border-top-right-radius: <?PHP echo $tr; ?>px;
  -webkit-border-bottom-right-radius: <?PHP echo $br; ?>px;

  -khtml-border-top-left-radius: <?PHP echo $tl; ?>px;
  -khtml-border-bottom-left-radius: <?PHP echo $bl; ?>px;
  -khtml-border-top-right-radius: <?PHP echo $tr; ?>px;
  -khtml-border-bottom-right-radius: <?PHP echo $br; ?>px;

  
}

div.catalogItem .title a:link , div.catalogItem .title a:active , div.catalogItem .title a:hover , div.catalogItem .title a:visited {
  color: <?PHP echo $widgetText; ?>;
}

/* ====== Search box ===== */
div.searchBox {
  display: block;
  color: <?PHP echo $widgetText; ?>;
  <!--background-color: <?PHP echo $widgetBackground; ?>;-->
	background-color: <?PHP echo $widgetBorder; ?>;
  border: 0px solid <?PHP echo $widgetBorder; ?>;
  margin: 20px 20px 20px 20px;
  padding: 10px;

  border-radius: 5px;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  -khtml-border-radius: 5px;
}

div.searchBox div.searchInput {
/*  display: block; */
  <!--width: 100%;-->
  margin: 0px 0px 0px 0px;
  background-color: <?PHP echo $widgetContentBackground; ?>;
  /*border: 1px solid #d1dce6;*/
  padding: 2px;
  
  border-radius: 5px 5px 0px 0px;
  -moz-border-radius: 5px 5px 0px 0px;
  -webkit-border-radius: 5px 5px 0px 0px;
  -khtml-border-radius: 5px 5px 0px 0px;  
}

div.searchBox div.searchInput input {
  -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	-moz-box-sizing: border-box;    /* Firefox, other Gecko */
	box-sizing: border-box;         /* Opera/IE 8+ */
  height: 100%;
	width: 99.9%;
	<!-- width: 100%; -->
  padding: 5px;
  font-size: 1em;
  border-radius: 5px 5px 0px 0px;
  -moz-border-radius: 5px 5px 0px 0px;
  -webkit-border-radius: 5px 5px 0px 0px;
  -khtml-border-radius: 5px 5px 0px 0px;  
}

div.searchBox div.suggestionResults {
  display: block;
  margin: px 5px;
  color: <?PHP echo $widgetText; ?>;
  background-color: <?PHP echo $widgetContentBackground; ?>;
  padding: 5px;
  
  vertical-align: top;
  text-align: left;

  border-top-left-radius: 0px;
  border-bottom-left-radius: 5px;
  border-top-right-radius: 0px;
  border-bottom-right-radius: 5px;
    
  -moz-border-top-left-radius: 0px;
  -moz-border-bottom-left-radius: 5px;
  -moz-border-top-right-radius: 0px;
  -moz-border-bottom-right-radius: 5px;
  
  -webkit-border-top-left-radius: 0px;
  -webkit-border-bottom-left-radius: 5px;
  -webkit-border-top-right-radius: 0px;
  -webkit-border-bottom-right-radius: 5px;

  -khtml-border-top-left-radius: 0px;
  -khtml-border-bottom-left-radius: 5px;
  -khtml-border-top-right-radius: 0px;
  -khtml-border-bottom-right-radius: 5px;
}

div.searchBox div.suggestionResults li .searchTitle {
  font-weight: bold;
}

div.searchBox a:link , div.searchBox a:active , div.searchBox a:hover , div.searchBox a:visited {
  color: <?PHP echo $widgetText; ?>;
}