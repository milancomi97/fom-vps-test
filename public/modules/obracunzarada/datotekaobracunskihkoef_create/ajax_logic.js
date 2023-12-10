$(document).ready(function () {
    // Attach a click event handler to the button
    $(document).on('click', 'body .create-mesecna-poentaza', function (e) {
        $('#myModal').modal('show');

    });

    $('#submitFormBtn').on('click', function () {

        debugger;
        // Swal.fire({
        //     title: 'Da li želite da otvorite mesec?',
        //     text: "Unesi dinamicki kasnije",
        //     icon: 'warning',
        //     confirmButtonText: 'Obriši',
        //     cancelButtonText: 'Odustani',
        //     showCancelButton: true,
        //     showCloseButton: true,
        //     confirmButtonColor: "#cc3f44",
        //
        // })

        var year = $('.create-mesecna-poentaza').data('year');
        var month = $('.create-mesecna-poentaza').data('month')
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: storeRoute,
            type: 'POST',
            data: {
                year: year,
                month: month,
                _token: _token
            },
            success: function (response) {
                if (response.status) {
                    location.reload()
                } else {
                    $("#statusMessage").text(response.message).addClass("text-danger");
                }
            },
            error: function (response) {
                $("#statusMessage").text("Greska: " + response.message).addClass("error");
            }
        });
    });
    $(document).on('click', 'body .index-mesecna-poentaza', function (e) {
        var id = $(this).data('month_id');
        window.location.href = showRoute + id;
    });

    $(document).on('click', 'body .check-mesecna-poentaza', function (e) {

        var month_id = $(this).data('month_id')
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: checkRoute,
            type: 'POST',
            data: {
                month_id:month_id,
                _token: _token
            },
            success: function (response) {
                $("#check_data").text(response.message).addClass("text-danger");
            },
            error: function (response) {
                $("#check_data").text("Greska: " + response.message).addClass("error");
            }
        });
    });


});
