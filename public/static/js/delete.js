/**
 * @deprecated
 */
$(document).ready(function () {
    $('.btn-del').click(function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        if(confirm('are you sure?')){
            $.ajax({
                url: "/notes/" + id,
                type: 'DELETE',
            }).done(function(response){
                location.replace(response.route);
            }).fail(function(jqXHR, textStatus, errorThrown){
                $('.show-info').html('Something goes wrong.').removeClass('alert-info').addClass('alert-danger');
                console.log(jqXHR.status+' '+errorThrown);
            });
        }
    });
});
