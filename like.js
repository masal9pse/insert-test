$(function() {
 var $good = $('.btn-good'), //いいねボタンセレクタ
  likePostId; //投稿ID
 $good.on('click', function(e) {
  e.stopPropagation();
  var $this = $(this);
  //カスタム属性（postid）に格納された投稿ID取得
  likePostId = $this.parents('.post_id').data('postid');
  likeUserId = $this.parents('.post_id').data('userid');
  console.log(likePostId)
  console.log(likeUserId)
  console.log({post_id: likePostId, user_id: likeUserId});
  $.ajax({
   type: 'POST',
   url: './Api/Like.php', //post送信を受けとるphpファイル
   //data: {postd: likePostId, userId: likeUserId} //{キー:投稿ID}
   data: {post_id: likePostId, user_id: likeUserId} //{キー:投稿ID}
  }).done(function(data) {
   console.log('Ajax Success');
   console.log(this.data);

   // いいねの総数を表示
   $this.children('span').html(data);
   // いいね取り消しのスタイル
   $this.children('i').toggleClass('far'); //空洞ハート
   // いいね押した時のスタイル
   $this.children('i').toggleClass('fas'); //塗りつぶしハート
   $this.children('i').toggleClass('active');
   $this.toggleClass('active');
  }).fail(function(msg) {
   console.log('Ajax Error');
   console.log(this.data);
   $this.children('span').html(data);
   // いいね取り消しのスタイル
   $this.children('i').toggleClass('far'); //空洞ハート
   // いいね押した時のスタイル
   $this.children('i').toggleClass('fas'); //塗りつぶしハート
   $this.children('i').toggleClass('active');
   $this.toggleClass('active');
  });
 });
});