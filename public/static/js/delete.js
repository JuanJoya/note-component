/**
 * @deprecated
 */
$(document).ready(function () {
    $('.btn-del').click(function (e) {
        e.preventDefault();
        var route = $(this).data("route");
        if(confirm('are you sure?')){
            $.ajax({
                url: route,
                type: 'DELETE',
            }).done(function(response){
                location.replace(response.route);
            }).fail(function(jqXHR, textStatus, errorThrown){
                $('.status').html('Something goes wrong.').addClass('alert-danger');
                console.log(jqXHR.status+' '+errorThrown);
            });
        }
    });
});
