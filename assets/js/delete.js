$(function(){
    $(document).on('click','.deleteTweet', function(){
        var tweetID  = $(this).data('tweet');
        $.ajax({
            url: "http://localhost:8888/phpfullscratch/core/ajax/deleteTweet.php",
            method: "POST",
            data: {
                deleteTweet:tweetID
            },
            success: function(data) {
                location.reload();
            }
        });
    }); 

    $(document).on('click','.deleteComment', function(){
        var tweetID  = $(this).data('tweet');
        var comment_id  = $(this).data('comment');
        $.ajax({
            url: "http://localhost:8888/phpfullscratch/core/ajax/deleteComment.php",
            method: "POST",
            data: {
                tweetID:tweetID,
                deleteComment:comment_id
            },
            success: function(data) {
                location.reload();
            }
        });
    });
});


