$(document).ready(function () {

    $(document).on('focusout', 'body .vrsta_placanja_td', function (event) {

        if (event.target.value !== '') {

            event.stopImmediatePropagation();
            $("#loader").show();
            $('input').prop('disabled', true);
            debugger
            var input_value = event.target.value;
            var input_key = event.target.dataset.vrstaPlacanjaKey
            var record_id = event.target.dataset.recordId
            var _token = $('input[name="_token"]').val();


            $.ajax({
                url: storeRoute,
                type: 'POST',
                data: {
                    _token: _token,
                    input_value: input_value,
                    input_key: input_key,
                    record_id: record_id
                },
                success: function (response) {
                    $("#statusMessage").text(response.message).addClass("text-success");
                    $("#loader").hide();
                    $('input').prop('disabled', false);

                },
                error: function (response) {
                    $("#statusMessage").text("Greska: " + response.message).addClass("text-danger");
                    $("#loader").hide();
                    $('input').prop('disabled', false);

                }
            });


        }
    });

});
