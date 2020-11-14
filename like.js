
//POST REQUEST

$(document).ready(function() {
 $('#likeMessage').click(function(e) {
  e.preventDefault();

  //serialize form data
  var url = $('#likeForm').serialize();
  console.log(url)
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
  var stringData = getUrlVars(url);

  //post with ajax
  $.ajax({
   type: "POST",
   url: "/offshoa-intern/Api/Like.php",
   data: stringData,
   ContentType: "application/json",

   success: function() {
    //alert('successfully posted');
    //$(this).toggleClass("text-danger");
    $('i').toggleClass("text-danger");
   },
   error: function() {
    alert('Could not be posted');
   }
  });
 });
});