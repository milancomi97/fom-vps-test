$(document).ready(function () {
    // Arrow navigation between inputs
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

        if ($next && $next.length) {
            $next.focus();
            e.preventDefault(); // Prevent default arrow key behavior
        }
    });

    function findAdjacentInput($current, direction) {
        let $row = $current.closest('tr');
        let currentIndex = $current.closest('td').index();
        let $targetRow;

        switch (direction) {
            case 'up':
                $targetRow = $row.prev();
                break;
            case 'down':
                $targetRow = $row.next();
                break;
            case 'left':
                return $current.closest('td').prev().find('.vrsta_placanja_input');
            case 'right':
                return $current.closest('td').next().find('.vrsta_placanja_input');
        }

        // Boundary check for up and down navigation
        if ($targetRow.length) {
            return $targetRow.find('td').eq(currentIndex).find('.vrsta_placanja_input');
        }
        return $(); // Return an empty jQuery object if no match
    }

    // Function to display a loading indicator and disable inputs during AJAX requests
    function showLoading(loading) {
        $(".loading").toggle(loading);
        $('input').prop('disabled', loading);
    }

    // Handle input value change with AJAX
    function handleValueChange(event) {
        let $input = $(event.currentTarget);
        let initialValue = $input.data('initial-value');
        let newValue = $input.val();

        if (initialValue !== newValue) {
            showLoading(true);
            let inputValue = newValue || 0;
            let inputKey = event.target.dataset.vrstaPlacanjaKey;
            let recordId = event.target.dataset.recordId;
            let _token = $('input[name="_token"]').val();

            $.ajax({
                url: storeRoute,
                type: 'POST',
                data: {
                    _token: _token,
                    input_value: inputValue,
                    input_key: inputKey,
                    record_id: recordId
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
                    showLoading(false);
                },
                error: function () {
                    $("#statusMessage").text("Greska: Nije moguće izvršiti akciju").addClass("text-danger");
                    showLoading(false);
                }
            });
        }
    }

    // Store initial value on focus
    $(document).on('focus', 'body .vrsta_placanja_td input', function (event) {
        $(event.currentTarget).data('initial-value', $(event.currentTarget).val());
    });

    // Focus out event to trigger AJAX update
    $(document).on('focusout', 'body .vrsta_placanja_td input', handleValueChange);
});
