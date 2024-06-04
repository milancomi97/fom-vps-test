function submitTroskovniCentar(orgCentarId,userId,recordId) {

debugger

    var _token = $('input[name="_token"]').val();


    $.ajax({
        url: statusUpdateRoute,
        type: 'POST',
        data: {
            statusType:'poenteri_status',
            userId:userId,
            status:1,
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
    debugger;

}
