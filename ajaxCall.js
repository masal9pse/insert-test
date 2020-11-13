
//POST REQUEST

$(document).ready(function() {
 $('#postMessage').click(function(e) {
  e.preventDefault();

  //serialize form data
  var url = $('form').serialize();

  //function to turn url to an object
  function getUrlVars(url) {
   var hash;
   var myJson = {};
   var hashes = url.slice(url.indexOf('?') + 1).split('&');
   //console.log(hashes)
   for (var i = 0; i < hashes.length; i++) {
    hash = hashes[i].split('=');
    myJson[hash[0]] = hash[1];
   }
   console.log(myJson);
   return JSON.stringify(myJson);
  }

  //pass serialized data to function
  var test = getUrlVars(url);

  //post with ajax
  $.ajax({
   type: "POST",
   //url: "/Work folders/OOP php/RESTFUL traversy/php_rest_myblog/api/post/create.php",
   //url: "/Applications/MAMP/htdocs/offshoa-intern/Api/postInsert.php",
   url: "/offshoa-intern/Api/postInsert.php",
   data: test,
   ContentType: "application/json",

   success: function() {
    alert('successfully posted');
   },
   error: function() {
    alert('Could not be posted');
   }
  });
 });
});