$(document).ready(function () {

    // Status logic
    $(document).on('click', 'body .status_td', function (event) {
        debugger
        $('#statusModal').modal('show');
        var radnikNameData = event.currentTarget.dataset.radnikName;
        var status = event.currentTarget.dataset.statusValue;
        var record_id = event.currentTarget.dataset.recordId

        $('#status_radnika').val(status);
        $('#radnik_status_modal').text(radnikNameData);
        $('#record_id_status_modal').val(null);
        $('#record_id_status_modal').val(record_id);

    })
    $('#submitFormBtnStatus').on('click', function (event) {

        event.stopImmediatePropagation();

        var status_value = $('#status_radnika').val()
        var record_id = $('#record_id_status_modal').val();

        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: storeRoute,
            type: 'POST',
            data: {
                record_id: record_id,
                input_value: status_value,
                input_key: 'status_poentaze',
                _token: _token
            },
            success: function (response) {
                if (response.status) {
                    location.reload()
                } else {
                    // $("#statusMessage").text(response.message).addClass("text-danger");
                }
            },
            error: function (response) {
                // $("#statusMessage").text("Greska: " + response.message).addClass("error");
            }
        });
    });


    // Napomena Logic
    $(document).on('click', 'body .napomena_td', function (event) {
        const row = $(this);
        $('#myModal').modal('show');
        var record_id = event.currentTarget.dataset.recordId
        var napomenaData = event.currentTarget.dataset.napomenaValue;
        var radnikNameData = event.currentTarget.dataset.radnikName;

        $('#radnik_modal').text(radnikNameData);

        $('#napomena_text').val('')
        $('#napomena_text_old')[0].innerHTML=napomenaData;
        $('#record_id_modal').val(null);
        $('#record_id_modal').val(record_id);

    });

    $('#submitFormBtn').on('click', function (event) {

        var napomena_text = $('#napomena_text').val()

        if (napomena_text !== '') {
            event.stopImmediatePropagation();
            var record_id = $('#record_id_modal').val();
            debugger;

            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: storeRoute,
                type: 'POST',
                data: {
                    record_id: record_id,
                    input_value: napomena_text,
                    input_key: 'napomena',
                    _token: _token
                },
                success: function (response) {
                    if (response.status) {
                        location.reload()
                    } else {
                        // $("#statusMessage").text(response.message).addClass("text-danger");
                    }
                },
                error: function (response) {
                    // $("#statusMessage").text("Greska: " + response.message).addClass("error");
                }
            });
        } else {
            $('#myModal').modal('hide');

        }
    });


});
