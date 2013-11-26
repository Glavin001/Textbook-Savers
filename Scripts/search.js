function showSuggestion(str)
{
if (str.length==0)
  { 
  document.getElementById("suggestionResults").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      
      document.getElementById("suggestionResults").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","Scripts/searchAll.php?query="+str,true);
xmlhttp.send();
}