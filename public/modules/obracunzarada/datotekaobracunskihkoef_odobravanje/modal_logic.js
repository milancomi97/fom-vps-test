function cloneElement(originalClass, targetClass, dataArray,type) {
    // Object.keys(dataArray).forEach(function (item, index) {

    for (var user in dataArray){

        var userId = user;
        var userName = dataArray[user]['name']
        var status = dataArray[user]['status'];

        var newElement = $("." + originalClass + ":first").clone();
        newElement[0].classList.add("newSelectDiv");
        newElement[0].style.display ='inline-block';
        // Clone the template element
        var labelElement = newElement.find("label").attr("for", originalClass + "_" + userId);

        labelElement[0].textContent = userName;
       var selectElement = newElement.find("select").attr({
            id: originalClass + "_" + userId,
            name: originalClass + "_" + userId
        })

        selectElement[0].setAttribute('data-user-id',userId);
        selectElement[0].setAttribute('data-user-name',userName);
        selectElement[0].setAttribute('data-type',type);
        selectElement[0].classList.add("newSelectElement");
        selectElement[0].value = status;

        // Append the modified element to the container
        $("." + targetClass).append(newElement);
    }
    $("." + originalClass + ":first").removeClass('newSelectDiv');
    $("." + originalClass + ":first").hide();

}


$(document).ready(function () {

    //  GET Status logic Admin status logic
    $(document).on('click', 'body .administrator-config', function (event) {

        $('#statusAdminModal').modal('show');

        debugger;
        var statusType = event.currentTarget.dataset.statusType;
        var userId = event.currentTarget.dataset.userId;
        var record_id =event.currentTarget.dataset.permissionRecordId;
        var _token = $('input[name="_token"]').val();
        $('#record_id_status_admin_modal').val(record_id);
        $('#user_id_status_admin_modal').val(userId);
        $('#status_type_admin_modal').val(statusType);

        $.ajax({
            url: getPermissionStatusAdministratorRoute,
            type: 'POST',
            data: {
                record_id: record_id,
                statusType:statusType,
                userId:userId,
                _token: _token
            },
            success: function (response) {
                if (response.status) {
                    var user_status = response.data.user_status;
                    var selectOptions = response.data.select_options;
                    var selectElement = $("#status_admin");

                    // Loop through the array and append options to the select element
                    $.each(selectOptions, function (index, value) {
                        selectElement.append($("<option></option>")
                            .attr("value", index)
                            .text(value));
                    });

                    selectElement.val(user_status);
                    // $('.newSelectDiv').each(function() {
                    //     $(this).remove();
                    // });
                    // $('#record_id_status_admin_modal').val(record_id);
                    // cloneElement("status_poentera_element", "status_poentera_div", poenterArray,'status_poentera');
                    // cloneElement("status_odgovornih_lica_element", "status_odgovornih_lica_div", odgovornaLicaArray,'status_odgovornih_lica');
                } else {
                }
            },
            error: function (response) {
            }
        });
    });

    //  UPDATE Status logic Admin status logic
    $(document).on('click', 'body #submitFormBtnStatusAdmin', function (event) {
        var _token = $('input[name="_token"]').val();

        var status=$('#status_admin').val()
        var record_id=$('#record_id_status_admin_modal').val()
        var userId=$('#user_id_status_admin_modal').val()
        var type=$('#status_type_admin_modal').val()

        debugger;
        $.ajax({
            url: updateStatusAdministratorRoute,
            type: 'POST',
            data: {
                recordId: record_id,
                userId:userId,
                status:status,
                statusType:type,
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
    // Status logic
    $(document).on('click', 'body .status_td', function (event) {

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
