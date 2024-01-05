$(document).ready(function () {

    var jsonData =  vrstePlacanjaData;
    var selectOptions = '';
    for (var key in vrstePlacanja) {
        selectOptions += '<option value="' + vrstePlacanja[key]['id']  + '">' + vrstePlacanja[key]['rbvp_sifra_vrste_placanja'] +' - '+ vrstePlacanja[key]['naziv_naziv_vrste_placanja'] + '</option>';
    }
    // Function to populate the table with JSON data
    function populateTable(vrsteData) {
        var tbody = $('#editableTable tbody');



        $.each(vrsteData, function (index, item) {
            var row = '<tr>' +
                '<td><input disabled type="text" class="form-control" name="sifra[]" value="' + item.key + '"></td>' +
                '<td><input disabled type="text" class="form-control" name="naziv[]" value="' + item.name + '"></td>' +
                '<td><input type="text" class="form-control col-width" name="email[]" value="' + item.value + '"></td>' +
                '<td><input type="text" class="form-control col-width" name="phone[]" value="' + item.name + '"></td>' +
                '<td><input type="text" class="form-control col-width" name="address[]" value="' + item.name + '"></td>' +
                '<td><input type="text" class="form-control col-width" name="address[]" value="' + item.name + '"></td>' +
                '<td><input type="text" class="form-control col-width" name="address[]" value="' + item.name + '"></td>' +
                '<td><button type="button" class="btn btn-danger btn-sm delete-row">Obriši</button></td>' +
                '</tr>';

            if(vrsteData.length-1 == index){
                row += '<tr>' +
                    '<td><select class="form-control new-vrste-placanja" name="sifra[]">' + selectOptions + '</select></td>' +
                    '<td><input type="text" class="form-control  nov-naziv" name="naziv[]" value=""></td>' +
                    '<td><input type="text" class="form-control col-width" name="email[]" value=""></td>' +
                    '<td><input type="text" class="form-control col-width" name="phone[]" value=""></td>' +
                    '<td><input type="text" class="form-control col-width" name="address[]" value=""></td>' +
                    '<td><input type="text" class="form-control col-width" name="address[]" value=""></td>' +
                    '<td><input type="text" class="form-control col-width" name="address[]" value=""></td>' +
                    '<td><button type="button" class="btn btn-success btn-sm add-row">Dodaj</button></td>' +
                    '</tr>';
            }
            tbody.append(row);
        });

        // TODO ADD LAST INDEX COLUMN, ADD, SELECT2, SAVE ALL BUTTONS
    }

    // Call the function to populate the table
    populateTable(jsonData);

    // Add row button click event
    $(document).on('click', 'body  .add-row',function (event) {
        var newRow ='<tr>' +
                '<td><select class="form-control new-vrste-placanja" name="sifra[]">' + selectOptions + '</select></td>' +
                '<td><input type="text" class="form-control nov-naziv" name="naziv[]" value=""></td>' +
                '<td><input type="text" class="form-control col-width" name="email[]" value=""></td>' +
                '<td><input type="text" class="form-control col-width" name="phone[]" value=""></td>' +
                '<td><input type="text" class="form-control col-width" name="address[]" value=""></td>' +
                '<td><input type="text" class="form-control col-width" name="address[]" value=""></td>' +
                '<td><input type="text" class="form-control col-width" name="address[]" value=""></td>' +
                '<td><button type="button" class="btn btn-success btn-sm add-row">Dodaj</button></td>' +
                '</tr>';

        $('#editableTable tbody').append(newRow);
        $(this).removeClass('btn-success');
        $(this).addClass('btn-danger');

        $(this).text("Obriši");
        $(this).removeClass('add-row');
        $(this).addClass('delete-row');
    });


    $(document).on('change', 'body .new-vrste-placanja', function (event) {

        var selectedOption = $('option:selected', this);
        var siblingElement = $(event.currentTarget).parent().siblings()[0];

        var nazivInput = $(siblingElement).children('.nov-naziv');
        nazivInput.val(selectedOption.text().trim().split(' - ')[1]);
    });
    // Delete row button click event
    $('#editableTable').on('click', '.delete-row', function () {
        $(this).closest('tr').remove();
    });


});
