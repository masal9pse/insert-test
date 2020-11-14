
//POST REQUEST

$(document).ready(function() {
 $('#likeMessage').click(function(e) {
  e.preventDefault();

  //serialize form data
  var url = $('#likeForm').serialize();
  console.log(url)
 });
});