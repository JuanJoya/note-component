/**
 * @deprecated
 */
$(function(){
    $('#search-form').submit(function(e){
        e.preventDefault();
    });

    $('#search-input').keyup(function(){
        var search = $('#search-input').val().trim();
        if (search !== '') {
            $.ajax({
                url: '/check',
                data: {q: search},
                dataType: 'html'
            })
            .done(function(response){
                $('#result').html(response);
                var e_search = $('#result .row').data('search');//preg_quote escaped pattern
                if (e_search) {
                    $('.n-strong').html(function(index, oldhtml){
                        return oldhtml.replace(new RegExp(e_search, 'ig'), "<strong>$&</strong>");
                    });
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown){
                $('#result').html(
                    '<div class="alert alert-danger mt-4">'+jqXHR.status+' '+errorThrown+'</div>'
                )
            })
        } else {
            $('#result').html("");
        }
    })
});
