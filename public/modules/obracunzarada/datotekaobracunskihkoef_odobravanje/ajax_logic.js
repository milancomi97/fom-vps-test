$(document).ready(function () {

    $(document).on('click', 'body .change-status', function (event) {

        var statusType = event.target.dataset.statusType;
        var userId = event.target.dataset.userId;
        var status = event.target.dataset.status;
        var recordId =event.target.dataset.permissionRecordId;
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: statusUpdateRoute,
            type: 'POST',
            data: {
                statusType:statusType,
                userId:userId,
                status:status,
                recordId:recordId,
                _token: _token
            },
            success: function (response) {
                if (response.status) {
                    location.reload()
                } else {
                }
            },
            error: function (response) {
            }
        });
    });
    $(document).on('focusout', 'body .vrsta_placanja_td', function (event) {
        if (event.target.value !== '') {
            event.stopImmediatePropagation();
            $(".loading").show();
            $('input').prop('disabled', true);

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
                    $(".loading").hide();
                    $('input').prop('disabled', false);
                },
                error: function (response) {
                    $("#statusMessage").text("Greska: " + response.message).addClass("text-danger");
                    $(".loading").hide();
                    $('input').prop('disabled', false);
                }
            });
        }
    });
});
