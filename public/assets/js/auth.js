$(document).ready(function () {
    $('.toggle-password').on('click', function () {
        var input = $($(this).data('target'));
        var icon = $(this).find('i');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    setTimeout(function () {
        $('.alert').fadeOut(500, function () {
            $(this).remove();
        });
    }, 5000);
});
