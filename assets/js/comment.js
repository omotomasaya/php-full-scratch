$(function(){
  $('#postComment').click(function(){
    var comment = $('#commentField').val();
    var tweet_id = $('#commentField').data('tweet');

    $.ajax({
        // ローカル用
        // url: "http://localhost:8888/phpfullscratch/core/ajax/comment.php",
        url: "https://phpfullscratch0701.herokuapp.com/core/ajax/comment.php",
        method: "POST",
        data: {
            comment:comment,
            tweet_id:tweet_id
        },
        success: function(data) {
            $('#comments').html(data);
            $('#commentField').val('');
        }
    });
  });
});
