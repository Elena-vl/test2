$(document).ready(function(){
    // save to database
    $(document).on('click', '#add_btn', function(){
        var request = $.ajax({
            url: 'ajax/server.php',
            type: 'POST',
            data: {
                'save': 1,
                'name': $('#name').val(),
                'last_name': $('#last_name').val(),
                'email': $('#email').val()
            }
        });
        request.done(function( response ) {
            response = JSON.parse(response);
            if (response.success) {
                alert('Данные добавлены');
                location.reload();
            } else {
                alert('Ошибка добавления. ' + response.message);
            }
        });
        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    });
    // delete from database
    $(document).on('click', '.delete', function(){
        var id = $(this).data('id');
        var request = $.ajax({
            url: 'ajax/server.php',
            type: 'GET',
            data: {
                'delete': 1,
                'id': id,
            }
        });
        request.done(function( response ) {
            response = JSON.parse(response);
            if (response.success) {
                alert(response.message);
                location.reload();
            } else {
                alert('Ошибка удаления. ' + response.message);
            }
        });
        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    });
    // update to database
    $(document).on('click', '#update_btn', function(){
        var request = $.ajax({
            url: 'ajax/server.php',
            type: 'POST',
            data: {
                'update': 1,
                'id': $('#id_user').val(),
                'name': $('#name').val(),
                'last_name': $('#last_name').val(),
                'email': $('#email').val()
            }
        });
        request.done(function( response ) {
            response = JSON.parse(response);
            if (response.success) {
                alert('Данные обновлены');
                location.reload();
            } else {
                alert('Ошибка обновления. ' + response.message);
            }
        });
        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    });
    $(document).on('click', '.edit', function(){
        $('#user_form').trigger('reset');
        var id = $(this).data('id');
        $.ajax({
            url: 'ajax/server.php',
            type: 'POST',
            data: {
                'view': 1,
                'id': id
            },
            success: function(response){
                response = JSON.parse(response);
                if (response.success) {
                    $('#id_user').val(response.message['id']);
                    $('#name').val(response.message['name']);
                    $('#last_name').val(response.message['last_name']);
                    $('#email').val(response.message['email']);
                    $('.form-footer').show();
                    $('#update_btn').show();
                    $('#add_btn').hide();
                } else {
                    $('.form-footer').hide();
                    alert('Ошибка. ' + response.message);
                }
            }
        });
    });
    $(document).on('click', '.view', function(){
        $('#user_form').trigger('reset');
        var id = $(this).data('id');
        $.ajax({
            url: 'ajax/server.php',
            type: 'POST',
            data: {
                'view': 1,
                'id': id
            },
            success: function(response){
                response = JSON.parse(response);
                if (response.success) {
                    $('#name').val(response.message['name']);
                    $('#last_name').val(response.message['last_name']);
                    $('#email').val(response.message['email']);
                } else {
                    alert('Ошибка. ' + response.message);
                }
            }
        });
        $('.form-footer').hide();
    });
});
