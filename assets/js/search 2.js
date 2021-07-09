$(function(){
  $(document).ready(function() {
    $('#search').keyup(function() {
      var query = $(this).val();
        $.ajax({
            url: "http://localhost:8888/portfolio/core/ajax/search.php",
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


