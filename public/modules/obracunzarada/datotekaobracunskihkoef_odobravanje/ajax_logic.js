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

    $(document).on('change', 'body .vrsta_placanja_td input', function (event) {
        $(event.currentTarget).attr('data-update-value', $(event.currentTarget).val());

        debugger;
    });
        $(document).on('focusout', 'body .vrsta_placanja_td input', function (event) {
            debugger;
            var shouldUpdate = $(event.currentTarget).data('update-value');

            if(shouldUpdate!==undefined) {
                // var shouldUpdate = $(event.currentTarget).data('update-value');
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

                            var vrednostBrojaca = response.negativni_brojac;
                            var record_update_id = response.record_id;
                            debugger;
                            if (vrednostBrojaca) {
                                var redovni_rad = $('input[data-record-id="' + record_update_id + '"][data-vrsta-placanja-key="001"]');
                                var topli_obrok = $('input[data-record-id="' + record_update_id + '"][data-vrsta-placanja-key="019"]');

                                redovni_rad.val(parseInt(redovni_rad.val()) - vrednostBrojaca)
                                topli_obrok.val(parseInt(topli_obrok.val()) - vrednostBrojaca)
                            }
                            var Toast = Swal.mixin({
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                customClass: 'swal-wide',
                                timer: 5000
                            });

                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            })
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
            }
    });
});
