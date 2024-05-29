function calculateSums(tableSelector) {
    debugger
    const $table = $('#table-div'+tableSelector);
    const $rows = $table.find('tr');
    const rowCount = $rows.length;
    const colCount = $rows.first().find('th, td').length;


}
