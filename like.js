
//POST REQUEST

$(document).ready(function() {
 $('#likeForm').click(function(e) {
  e.preventDefault();

  function serializePost(form) {
   var data = {};
   form = $(form).serializeArray();
   for (var i = form.length; i--;) {
    var name = form[i].name;
    var value = form[i].value;
    var index = name.indexOf('[]');
    if (index > -1) {
     name = name.substring(0, index);
     if (!(name in data)) {
      data[name] = [];
     }
     data[name].Push(value);
    }
    else
     data[name] = value;
   }
   return data;
  }
  //serialize form data
  //var url = $('#likeForm[name=my-text]').serialize();
  var url = $('#likeForm').serialize();
  let test = serializePost(url)

  //var url = $('#likeForm').serializeArray();
  //console.log(url)
  console.log(test)
  exit
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
  console.log(stringData);
  //post with ajax
  $.ajax({
   type: "POST",
   url: "/offshoa-intern/Api/Like.php",
   data: stringData,
   ContentType: "application/json",

   success: function() {
    //alert('successfully posted');
    //$(this).toggleClass("text-danger");
    $this.children('i').toggleClass('far'); //空洞ハート
    // いいね押した時のスタイル
    $this.children('i').toggleClass('fas'); //塗りつぶしハート
    $this.children('i').toggleClass('active');
   },
   error: function() {
    $this.children('i').toggleClass('far'); //空洞ハート
    // いいね押した時のスタイル
    $this.children('i').toggleClass('fas'); //塗りつぶしハート
    $this.children('i').toggleClass('active');
   }
  });
 });
});