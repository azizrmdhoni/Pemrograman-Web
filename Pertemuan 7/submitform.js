$(document).ready(function() {
    $('#submitform').on('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            nama: $('#nama').val(),
            email: $('#email').val(),
            pesan: $('#pesan').val()
        };

        $('#successMsg, #errorMsg').hide();
        $(this).addClass('loading');

        setTimeout(function() {
            console.log('Data yang dikirim:', formData);

            $('#successMsg').fadeIn();
            $('#submitform')[0].reset();
            $('#submitform').removeClass('loading');

            setTimeout(function() {
                $('#successMsg').fadeOut();
            }, 5000);
        }, 1000);
    });
});
