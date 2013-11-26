
function pad(number, length) {
  if (length != null)
  {
    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }
    return str;  
  }
  else
  {
    return number;
  }
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function animatedCounter(theObject, startVal, endVal, incrementVal, padding, speed, callback)
{
  if (theObject != null)
  {  
    var currentContents = theObject.innerHTML;
    var currentValue = null;
    if ( (currentContents == "") || (isNaN(currentContents)) )
    {
      theObject.innerHTML = pad(startVal,padding);
    }
    else
    {
      currentValue = parseInt(currentContents,10);
      var tempVal = (currentValue+incrementVal);
      if (currentValue != endVal)
      {
        theObject.innerHTML = pad(tempVal,padding);
      }
    }
    if (currentValue != endVal)
    {
      setTimeout(function() { animatedCounter(theObject, startVal, endVal, incrementVal, padding, speed, callback); } , speed);    
    }
    else
    {
      callback();
    }
  }
  else
  {
    
  }
}

function inWindowPopup(title,html)
{
  $(".inWindowPopup").slideUp("fast", function () { $(".inWindowPopup").remove() } );

  var $popupWidget = $('<div />').appendTo('body');
  $popupWidget.attr('class','inWindowPopup');
  $popupWidget.hide();
  
  var $popupClose = $('<div />').appendTo($popupWidget);
  $popupClose.attr('class','closeButton');
  $popupClose.attr('onclick','$(".inWindowPopup").slideUp("slow", function () { $(".inWindowPopup").remove() } );');
  $popupClose.html("X");

  var $popupTitle = $('<div />').appendTo($popupWidget);
  $popupTitle.attr('class','popupTitle');
  $popupTitle.html(title);
    
  var $popupContent = $('<div />').appendTo($popupWidget);
  $popupContent.attr('class','popupContent');
  $popupContent.html(html);
  
  $popupWidget.slideDown("slow");
}


function loginPopup() { 
/*
var loginPanel = $("#loginPanel");
var page = $(".page");
var wall = $(".textbookWall");
if (loginPanel.height() != 0)
{
  loginPanel.height("0px");
  page.css("padding-top","0px");
  wall.css("padding-top","0px");
}
else
{
  loginPanel.height("50px");
  page.css("padding-top","50px");
  wall.css("padding-top","0px");
}
*/

$.ajax({
  type: "POST",
  url: "User/Login.php",
  data: { },
  dataType: "html"
}).done(function( data ) {
  var loginObject = $(data).find("form#loginForm").parent();
  loginObject.find("a img").attr('style','width: 169; height: 21; left: 50%; margin-left: 85px;');
  inWindowPopup("Login",loginObject.html());
}); 


} 

function sendFeedbackPopup() { 
  var feedbackHTML = '<div id="feedbackWindow">';
  feedbackHTML += '<textarea id="inputMessage" name="inputMessage" placeholder="Type your feedback here." style="width: 100%; height: 300px;"></textarea><br />';
  feedbackHTML += '<input type="submit" id="sendButton" value="Submit Feedback" style="width: 100%;" />';  
  scriptHTML = '<script> $("input#sendButton").click(function() {  $.ajax({ type: "POST", url: "Scripts/sendMessage.php", data: { ToId: 1, messageContent: $("textarea#inputMessage").val() }, dataType: "html" }).done(function( data ) {  $(".closeButton").click();   }); </script>';
  feedbackHTML += '</div>';
  inWindowPopup("Send Feedback", feedbackHTML );
  $("input#sendButton").click(function() 
  {  
  var message = "Feedback:\n"+$("div#feedbackWindow textarea#inputMessage").val();
  console.log(message);
    $.ajax({ 
    type: "POST", 
      url: "Scripts/sendMessage.php", 
      data: { ToId: 1, messageContent: message }, 
      dataType: "html" 
    }).done(function( data ) {  
    console.log(data);
      $(".closeButton").click();   
  });
  });
  
} 

(function ($) {

  function listFilter(datasource, input, list) { // header is any element, list is an unordered list
    
    $(input)
      .change( function () {
        var filter = $(this).val();
          $.ajax({
            url: datasource,
            data: {listType: 'select', query: filter},
            success: function(data) {
              //$('.result').html(data);
              list.html(data);
            }
          });
      })
    .keyup( function () {
        // fire the above change event after every letter
        $(this).change();
    });
  }

//ondomready
  $(function () {
    listFilter("Scripts/searchTextbook.php", $("#textbookfilter"), $("#textbook"));
    listFilter("Scripts/searchCourse.php", $("#coursefilter"), $("#course"));
    listFilter("Scripts/searchSubject.php", $("#subjectfilter"), $("#subject"));
  });
  
}(jQuery));

// Blinking Text
function blinkText
    (
    element,    // JavaScript element
    text1,      // String
    text2,      // String
    defaultText // String; Default
    )
{
    var currentText = element.innerHTML;
    //console.log("currentText:"+currentText);
    if (currentText == text1)
    {
    // Switch to text1
    element.innerHTML = text2;
    }
    else if (currentText == text2)
    {
    // Switch to text1
    element.innerHTML = text1;
    }
    else
    {
    // Defaulte text 
    element.innerHTML = defaultText;
    }

}

// Marquee Text
function marqueeText
    (
    element,    // JavaScript element
    text,       // String. null=element.innerHTML
    move        // Integer. Both direction and rate, in the form DR, ex: +1. 
                    // Direction: +/- for forward/backward.
                    // Rate: in characters.
    )
{
    if (text == null)
    {
        text = element.innerHTML;   
    }
    
}


function getLocalStorage(varName)
{
  if(typeof(Storage)!=="undefined")
  {
    // Yes! localStorage and sessionStorage support!
    return localStorage[varName];
  }
  else
  {
    // Sorry! No web storage support..
    return null;
  }
}

function getSessionStorage(varName)
{
  if(typeof(Storage)!=="undefined")
  {
    // Yes! localStorage and sessionStorage support!
    return sessionStorage[varName];
  }
  else
  {
    // Sorry! No web storage support..
    return null;
  }
}

function setLocalStorage(varName, value)
{
  if(typeof(Storage)!=="undefined")
  {
    // Yes! localStorage and sessionStorage support!
    localStorage[varName] = value;
    return value;
  }
  else
  {
    // Sorry! No web storage support..
    return null;
  }
}

function setSessionStorage(varName, value)
{
  if(typeof(Storage)!=="undefined")
  {
    // Yes! localStorage and sessionStorage support!
    sessionStorage[varName] = value;
    return value;
  }
  else
  {
    // Sorry! No web storage support..
    return null;
  }
}