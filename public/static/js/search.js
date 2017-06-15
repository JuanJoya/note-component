$(function(){
    $('#search-form').submit(function(e){
        e.preventDefault();
    });

    $('#search-input').keyup(function(){
        var query = $('#search-input').val();
        $.ajax({
            cache: false,
            type: 'POST',
            url: '/search',
            dataType: 'html',
            data: {query: query}
        })
        .done(function(response){
            $('#result').html(response);
        })
        .fail(function(jqXHR, textStatus, errorThrown){
            $('#result').html(
                '<div class="alert alert-danger">'+jqXHR.status+'</div>'
            )
        })
    })
});
