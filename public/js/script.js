$(document).ready(function() {


    //$('#save_comment_btn').click(function() {
    $('#comments').on("click", "#save_comment_btn", function(e) {

        $('#save_comment_btn').prop('disabled', true);
        $.ajax({
            method: "POST",
            url: "/comments/store",
            data: $('#comment_form').serialize(),
            success: function(data) {
                $('#save_comment_btn').prop('disabled', false);
                var errors=data.errors;
                if(data.errors!=null)  {
                    $.notify({message: errors.join('<br><br>')},{type: 'danger',  z_index: 2051});
                } else {
                    $.notify({message: "Комментарий успешно добавлен"},{type: 'success'});
                    $('#comments').html(data.comments);

                }
            },
            error: function(xhr) {
                if(xhr.status==401) {
                    $.notify({message: "Необходима авторизация"},{type: 'danger'});
                }
                $('#save_comment_btn').prop('disabled', false);
            }
        })
    });


    $('#comments').on("click", ".pagination a", function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        page = url.split('page=')[1];

        $.ajax({
            url: "/comments/load/"+$('#post_id').val(),
            data: {page: page},
            success: function(data) {
                $('#comments').html(data.comments);
            }
        })
    });

})



