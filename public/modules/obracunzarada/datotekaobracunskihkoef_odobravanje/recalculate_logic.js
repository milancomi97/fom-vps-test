function calculateSums(tableSelector) {
    const $table = $('#table-div'+tableSelector);
    const $rows = $table.find('tr');
    const rowCount = $rows.length;
    const colCount = $rows.first().find('th, td').length;

    $rows.each(function(index) {
        if(index===0){
            $(this).append('<td><b>Zbir:</b></td>');
        }else{
            $(this).append('<td></td>');

        }
    });

    $rows.each(function(index) {
        if (index === 0) return; // Skip header row
        let rowSum = 0;
        $(this).find('td').each(function(cellIndex) {
            if (cellIndex > 0) {
                if($(this).hasClass('vrsta_placanja_td')){
                    rowSum += parseFloat($(this).find('input').val());
                }
            }
        });
        if(rowSum>350){
            $(this).find('td:last').addClass('text-danger')
        }else {
            $(this).find('td:last').addClass('bg-success')

        }
        $(this).find('td:last').text(rowSum);
    });

    const $sumRow = $('<tr></tr>').appendTo($table);
    for (let i = 0; i <= colCount-3; i++) {
        $sumRow.append('<td style="background-color: #ADD8E6;"></td>');
    }

    for (let j = 2; j < colCount; j++) {
        let colSum = 0;
        $rows.each(function(index) {
            if (index > 1) {
                if($(this).find('td').eq(j).hasClass('vrsta_placanja_td')){

                colSum += parseFloat($(this).find('td').eq(j).find('input').val());
            }
            }
        });
        if(j<colCount-2){
            $sumRow.find('td').eq(j).text(colSum).css({
                'font-weight': 600,
                'text-align': 'center'
            });

        }
    }

    // Add "Total" label to the new row
    $sumRow.find('td').eq(0).text('XXXXXXX').css('font-weight',800);
    $sumRow.find('td').eq(1).text('Ukupno:').css('font-weight',800);

}

$(document).ready(function () {
    // Attach a click event handler to the button

    debugger;
    $('.loaderEvent').on('submit', function (event) {
        debugger;
        $('.loading').toggleClass('hidden')
        $('.maincontainer').toggleClass('invisible')
    });


        $('.loadingInit').toggleClass('hidden')
        $('.maincontainer').toggleClass('invisible')
});
