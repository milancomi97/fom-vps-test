function calculateSums(tableSelector) {
    const $table = $('#table-div'+tableSelector);
    const $rows = $table.find('tr');
    const rowCount = $rows.length;
    const colCount = $rows.first().find('th, td').length;

    $rows.each(function() {
        $(this).append('<td></td>');
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
}
