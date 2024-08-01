function submitTroskovniCentar(orgCentarId,userId,recordId) {

debugger

    var _token = $('input[name="_token"]').val();

    Swal.fire({
        title: 'Da li sigurno zatvarate ?',
        text: orgCentarId,
        icon: 'warning',
        confirmButtonText: 'Zatvori',
        cancelButtonText: 'Odustani',
        showCancelButton: true,
        showCloseButton: true,
        confirmButtonColor: "#cc3f44",

    }).then((result) => {

        if(result.isConfirmed){

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
        }
    });



}
