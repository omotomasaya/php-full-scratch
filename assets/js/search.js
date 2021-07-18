$(function(){
  $(document).ready(function() {
    $('#search').keyup(function() {
      var query = $(this).val();
        $.ajax({
            //ローカル用
            // url: "http://localhost:8888/phpfullscratch/core/ajax/search.php",
            url: "https://phpfullscratch0701.herokuapp.com/core/ajax/search.php",
            method: "POST",
            data: {
                query: query
            },
            success: function(data) {
                $('#search-list').html(data);
            }
        });
    });
  });
});


