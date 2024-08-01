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

    $(document).on('click', 'body .vrsta_placanja_td input', function (event) {
        $(event.currentTarget).attr('data-update-value', $(event.currentTarget).val());

        debugger;
    });


    $(document).on('change', 'body .vrsta_placanja_td input', function (event) {

        debugger;
        var newValue = $(event.currentTarget).val();
        $(event.currentTarget).attr('data-update-value', newValue);

    });

    $(document).on('focusout', 'body .vrsta_placanja_td input', function (event) {
        var shouldUpdate = $(event.currentTarget).data('update-value');

        debugger;
        if(shouldUpdate!==undefined) {
            // var shouldUpdate = $(event.currentTarget).data('update-value');
            event.stopImmediatePropagation();
            $(".loading").show();
            $('input').prop('disabled', true);

            var input_value = event.target.value;
            if(input_value==''){
                input_value=0;
            }
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


                    debugger;
                    if(response.action=='vrstePlacanjaUpdated'){


                        for(let index in response.result){

                            var vrstaPlacanjaData = response.result[index];
                            var sifraVrstePlacanja = vrstaPlacanjaData['key'];
                            var satiVrstePlacanja = vrstaPlacanjaData['sati'];

                            if(satiVrstePlacanja!='0'){
                                var vrstePlacanjaElement =  $('input[data-record-id="' + response.record_id + '"][data-vrsta-placanja-key="'+sifraVrstePlacanja+'"]');
                                vrstePlacanjaElement.val(satiVrstePlacanja)
                            }



                        }
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
                        title: 'Podaci izmenjeni'
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
    });
});
