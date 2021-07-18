$(function(){
    $(document).on('click','.like-btn', function(){
        var tweetID  = $(this).data('tweet');
        var tweet_id  = $(this).data('user');
        $.ajax({
            // ローカル用
            // url: "http://localhost:8888/phpfullscratch/core/ajax/like.php",
            url: "https://phpfullscratch0701.herokuapp.com/core/ajax/like.php",
            method: "POST",
            data: {
                like:tweetID,
                tweetBy:tweet_id
            },
            success: function(data) {
                location.reload();
            }
        });
    }); 

    $(document).on('click','.unlike-btn', function(){
        var tweetID  = $(this).data('tweet');
        var tweet_id  = $(this).data('user');
        $.ajax({
            // ローカル用
            // url: "http://localhost:8888/phpfullscratch/core/ajax/like.php",
            url: "https://phpfullscratch0701.herokuapp.com/core/ajax/like.php",
            method: "POST",
            data: {
                unlike:tweetID,
                tweetBy:tweet_id
            },
            success: function(data) {
                location.reload();
            }
        });
    });
});

