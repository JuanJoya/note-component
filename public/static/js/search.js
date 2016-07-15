$(function(){
    $('#search-form').submit(function(e){
        e.preventDefault();
    });

    $('#search-input').keyup(function(){
        var query = $('#search-input').val();

        $.ajax({
            type: 'POST',
            url: '/search',
            data: ('note-word='+query)
        })
        .done(function(response){
            $('#result').html(response);
        })
        .fail(function(){
            $('#result').html('<h2>Request Error</h2>');
        })
    })
})