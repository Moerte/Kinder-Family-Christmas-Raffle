$(document).ready(function () {
    $('#register_id').on('submit',function (e) {
        $.ajax({
            type: 'POST',
            async: false,
            dataType: "json",
            url: 'validate_data.php',
            data: $('#register_id').serialize(),
            success: function (response) {
                if (response.returnValue == 1) {
                    $msg = "Erros:\n";
                    if (response.duplicateEmail == 1) {
                        $("#mail_id").css("border-color", "red");
                        $msg += "This email already exists.\n";
                    }
                    $msg += "Fix the errors before submit again.";
                    $("#error-div").html($msg);
                    e.preventDefault();
                    return false;
                }
            }
        });

    });
});