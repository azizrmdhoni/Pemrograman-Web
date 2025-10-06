$(document).ready(function() {
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }

    $('#contactForm').on('submit', function(e) {
        e.preventDefault();

        const messageBox = $('.message_box');
        messageBox.hide(); 
        
        const nama = $('#nama').val();
        if (nama == '') {
            messageBox.html('<span style="color:red;">Silakan masukkan nama Anda!</span>').fadeIn();
            $('#nama').focus();
            return false;
        }
        
        const email = $('#email').val();
        if (email == '') {
            messageBox.html('<span style="color:red;">Silakan masukkan alamat email Anda!</span>').fadeIn();
            $('#email').focus();
            return false;
        }
        if (!isValidEmailAddress(email)) {
            messageBox.html('<span style="color:red;">Format alamat email tidak valid!</span>').fadeIn();
            $('#email').focus();
            return false;
        }
        
        const pesan = $('#pesan').val();
        if (pesan == '') {
            messageBox.html('<span style="color:red;">Silakan masukkan pesan Anda!</span>').fadeIn();
            $('#pesan').focus();
            return false;
        }   
                                
        $.ajax({
            type: "POST",
            url: "submitform.php",
            data: $(this).serialize(),
            beforeSend: function() {
                messageBox.html('<span>Mengirim data...</span>').css('background-color', '#f0f0f0').fadeIn();
            },      
            success: function(response) {
                messageBox.html(response).css('background-color', '#4caf50').css('color', 'white');
                $('#contactForm')[0].reset();
                setTimeout(function() {
                    messageBox.fadeOut();
                }, 5000);
            },
            error: function() {
                messageBox.html('<span style="color:white;">Terjadi kesalahan. Coba lagi.</span>').css('background-color', '#f44336').fadeIn();
            }
        });
    });
});
