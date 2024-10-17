$(document).ready(function () {

    $(document).ready(function () {
        $(document).on('keydown', '.vrsta_placanja_input', function (e) {
            let $current = $(e.target);
            let $next;

            switch (e.key) {
                case 'ArrowUp':
                    $next = findAdjacentInput($current, 'up');
                    break;
                case 'ArrowDown':
                    $next = findAdjacentInput($current, 'down');
                    break;
                case 'ArrowLeft':
                    $next = findAdjacentInput($current, 'left');
                    break;
                case 'ArrowRight':
                    $next = findAdjacentInput($current, 'right');
                    break;
                default:
                    return; // Exit for other keys
            }

            if ($next.length) {
                $next.focus();
                e.preventDefault(); // Prevent default arrow key behavior
            }
        });

        function findAdjacentInput($current, direction) {
            let $row = $current.closest('tr');
            let currentIndex = $current.closest('td').index();

            switch (direction) {
                case 'up':
                    return $row.prev().find('td').eq(currentIndex).find('.vrsta_placanja_input');
                case 'down':
                    return $row.next().find('td').eq(currentIndex).find('.vrsta_placanja_input');
                case 'left':
                    return $current.closest('td').prev().find('.vrsta_placanja_input');
                case 'right':
                    return $current.closest('td').next().find('.vrsta_placanja_input');
            }
        }
    });



    // Debounce function
    function debounce(func, delay) {
        let timeout;
        return function () {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), delay);
        };
    }

    // Click event for updating status
    $(document).on('click', 'body .change-status', function (event) {
        var statusType = event.target.dataset.statusType;
        var userId = event.target.dataset.userId;
        var status = event.target.dataset.status;
        var recordId = event.target.dataset.permissionRecordId;
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: statusUpdateRoute,
            type: 'POST',
            data: {
                statusType: statusType,
                userId: userId,
                status: status,
                recordId: recordId,
                _token: _token
            },
            success: function (response) {
                if (response.status) {
                    location.reload();
                }
            },
            error: function () {
                // Handle error if needed
            }
        });
    });

    // Store initial value on focus
    $(document).on('focus', 'body .vrsta_placanja_td input', function (event) {
        $(event.currentTarget).data('initial-value', $(event.currentTarget).val());
    });

    // Focus out event with debounced update
    $(document).on('focusout', 'body .vrsta_placanja_td input', debounce(function (event) {
        var $input = $(event.currentTarget);
        var initialValue = $input.data('initial-value');
        var newValue = $input.val();

        // Only proceed if the value has changed
        if (initialValue !== newValue) {
            $(".loading").show();
            $('input').prop('disabled', true);

            var input_value = newValue || 0;
            var input_key = event.target.dataset.vrstaPlacanjaKey;
            var record_id = event.target.dataset.recordId;
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
                    if (response.action === 'vrstePlacanjaUpdated') {
                        for (let index in response.result) {
                            var vrstaPlacanjaData = response.result[index];
                            var sifraVrstePlacanja = vrstaPlacanjaData['key'];
                            var satiVrstePlacanja = vrstaPlacanjaData['sati'];

                            if (satiVrstePlacanja !== 0) {
                                var vrstePlacanjaElement = $('input[data-record-id="' + response.record_id + '"][data-vrsta-placanja-key="' + sifraVrstePlacanja + '"]');
                                vrstePlacanjaElement.val(satiVrstePlacanja);
                            }
                        }
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Podaci izmenjeni',
                        toast: true,
                        position: 'top',
                        showConfirmButton: false,
                        customClass: 'swal-wide',
                        timer: 5000
                    });

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
    }, 300)); // Adjust debounce delay as needed
});
