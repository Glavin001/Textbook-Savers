<?php 
header("Content-type: text/css"); 
require 'theme.php';
?>

/* Tables */
table.selling , table.wishlist 
{
  padding: 5px;
  width: 100%;
}

table.selling tr > th , table.wishlist tr > th
{
  border: 1px solid rgba(0,0,0,0.4);//<?PHP echo $lightColour; ?>;
  text-align:center;
  padding: 5px;
  background-color: rgba(0,0,0,0.3);//<?PHP echo $lightColour; ?>;
  font-weight: bold;
  text-transform:capitalize;
}

table.selling tr > td , table.wishlist tr > td
{
  background-color: rgba(0,0,0,0.1);//<?PHP echo $lightColour; ?>;
}

table.selling tr:hover > td , table.wishlist tr:hover > td
{
  border: 1px solid rgba(0,0,0,0.4);//<?PHP echo $lightColour; ?>;
  background-color: rgba(0,0,0,0.2);//<?PHP echo $darkColour; ?>;
  /* font-weight: bold; */
}

table.selling tr td , table.wishlist tr td
{
  border: 1px dotted rgba(0,0,0,0.1);//<?PHP echo $lightColour; ?>;
  padding: 5px;
  text-align:center;
}

table.selling img , table.wishlist img
{
  margin: 0 5px 0 5px;
}


table.selling button.changePrice , table.wishlist button.removeWish, table.selling button.markSold
{
  margin: 5px;
  padding: 5px;
}