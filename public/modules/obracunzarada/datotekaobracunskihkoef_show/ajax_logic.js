$(document).ready(function () {

    var jsonData = vrstePlacanjaData;
    var selectOptions = '';
    for (var key in vrstePlacanja) {
        selectOptions += '<option value="' + vrstePlacanja[key]['rbvp_sifra_vrste_placanja'] + '">' + vrstePlacanja[key]['rbvp_sifra_vrste_placanja'] + ' - ' + vrstePlacanja[key]['naziv_naziv_vrste_placanja'] + '</option>';
    }

    // Function to populate the table with JSON data
    function populateTable(vrsteData) {
        var tbody = $('#editableTable tbody');


        $.each(vrsteData, function (index, item) {

            var row = `
  <tr class="vrste-placanja-data_tr">
    <td>
      <input type="hidden" class="vrste-placanja-data" data-vrste-name="${item.name}" data-vrste-key="${item.key}" data-vrste-value="${item.value}" data-vrste-id="${item.id}">
      <input disabled type="text" class="form-control" name="sifra" value="${item.key}">
    </td>
    <td><input disabled type="text" class="form-control" name="naziv" value="${item.name}"></td>
    <td><input type="number" class="form-control col-width" name="value" value="${item.value}"></td>
    <td><input type="text" class="form-control col-width" name="phone" value="${item.name}"></td>
    <td><input type="text" class="form-control col-width" name="address" value="${item.name}"></td>
    <td><input type="text" class="form-control col-width" name="address" value="${item.name}"></td>
    <td><input type="text" class="form-control col-width" name="address" value="${item.name}"></td>
    <td><button type="button" class="btn btn-danger btn-sm delete-row">Obriši</button></td>
  </tr>
`;

            if (vrsteData.length - 1 == index) {
                row += `
  <tr class="vrste-placanja-data_tr">
    <td>
      <select class="form-control new-vrste-placanja nov-key" name="sifra">${selectOptions}</select>
      <input type="hidden" class="vrste-placanja-data nov-id" data-vrste-name="${item.name}" data-vrste-key="${item.key}" value="${item.id}" data-vrste-value="${item.value}" data-vrste-id="${item.id}">
    </td>
    <td><input type="text" disabled class="form-control nov-naziv" name="naziv" value=""></td>
    <td><input type="number" class="form-control col-width nov-value" name="value" value=""></td>
    <td><input type="text" class="form-control col-width" name="phone" value=""></td>
    <td><input type="text" class="form-control col-width" name="address" value=""></td>
    <td><input type="text" class="form-control col-width" name="address" value=""></td>
    <td><input type="text" class="form-control col-width" name="address" value=""></td>
    <td><button type="button" class="btn btn-success btn-sm add-row">Dodaj</button></td>
  </tr>
`;
            }
            tbody.append(row);
        });

    }

    // Call the function to populate the table
    populateTable(jsonData);

    // Add row button click event
    $(document).on('click', 'body  .add-row', function (event) {

        var column  = $(event.target).parent().parent();

        var hiddenInput  = column.find('.vrste-placanja-data')
        var vrstePlacanjaId =  column.find('.nov-id')
        var vrstePlacanjaName = column.find('.nov-naziv')
        var vrstePlacanjaValue = column.find('.nov-value')
        var vrstePlacanjaKey= column.find('.nov-key')

        hiddenInput.data('vrste-id',vrstePlacanjaId.val());
        hiddenInput.data('vrste-name',vrstePlacanjaName.val());
        hiddenInput.data('vrste-value',vrstePlacanjaValue.val());
        hiddenInput.data('vrste-key',vrstePlacanjaKey.val());
        debugger;
        var newRow = `
  <tr class="vrste-placanja-data_tr">
    <td>
      <select class="form-control new-vrste-placanja nov-key" name="sifra">${selectOptions}</select>
      <input type="hidden" class="vrste-placanja-data" data-vrste-name="" data-vrste-key="" data-vrste-value="" data-vrste-id="">
    </td>
    <td><input type="text" class="form-control nov-naziv" name="naziv" value=""></td>
    <td><input type="number" class="form-control col-width nov-value" name="value" value=""></td>
    <td><input type="text" class="form-control col-width" name="phone" value=""></td>
    <td><input type="text" class="form-control col-width" name="address" value=""></td>
    <td><input type="text" class="form-control col-width" name="address" value=""></td>
    <td><input type="text" class="form-control col-width" name="address" value=""></td>
    <td><button type="button" class="btn btn-success btn-sm add-row">Dodaj</button></td>
  </tr>
`;

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

    $(document).on('click', 'body .submitBtn', function (event) {
        event.stopImmediatePropagation();
        var vrstePlacanjaInputs = $('.vrste-placanja-data');
        var record_id = event.target.dataset.recordId
        var data = {};
        $.each(vrstePlacanjaInputs, function (index, input) {
            var value = $(input).data('vrsteValue');
            var key = $(input).data('vrsteKey');
            var id =  $(input).data('vrsteId');

            if(value !== '' && key !==''){
                data[id] = {
                    value: value,
                    key: key
                };
            }

        });

            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: storeAllRoute,
                type: 'POST',
                data: {
                    _token: _token,
                    vrste_rada:data,
                    record_id: record_id
                }, success: function (response) {
                    if (response.status) {
                        location.reload()
                    } else {
                        // $("#statusMessage").text(response.message).addClass("text-danger");
                    }
                }, error: function (response) {


                }
            });

    });
});
