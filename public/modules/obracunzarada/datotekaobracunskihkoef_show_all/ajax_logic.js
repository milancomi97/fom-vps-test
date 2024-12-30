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
                if (response) {
                    location.reload()
                } else {
                }
            },
            error: function (response) {
            }
        });
    });
});
