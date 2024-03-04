$(document).ready(function () {

    var jsonData = listaKreditoraData;
    var selectOptions ='<option value="">Izaberi kreditora</option>'
    for (var key in listaKreditora) {

        selectOptions += '<option value="' + listaKreditora[key]['sifk_sifra_kreditora'] + '">' + listaKreditora[key]['sifk_sifra_kreditora'] + ' - ' + listaKreditora[key]['imek_naziv_kreditora'] + '</option>';
    }


    // Function to populate the table with JSON data
    function populateTable(vrsteData) {

        var tbody = $('#editableTable tbody');

        var counter = 0;

        debugger;
        $.each(vrsteData, function (index, item) {
            counter++;
            if(item.partija !== '' || item.glavnica !== ''|| item.saldo !== ''){

            var row = `
  <tr class="vrste-placanja-data_tr">
    <td>
      <input disabled type="text" class="form-control" name="sifra" value="${item.SIFK_sifra_kreditora}">
    </td>
    <td><input disabled type="text" class="form-control" name="naziv" value="${item.IMEK_naziv_kreditora}"></td>
    <td><input type="text" class="form-control col-width" name="partija" value="${item.PART_partija_poziv_na_broj}"></td>
    <td><input type="number" class="form-control col-width" name="glavnica" value="${item.GLAVN_glavnica}"></td>
    <td><input type="number" class="form-control col-width" name="saldo" value="${item.SALD_saldo}"></td>
    <td><input type="number" class="form-control col-width" name="rata" value="${item.RATA_rata}"></td>
    <td><input type="checkbox" class="form-control col-width" name="pocetak_zaduzenja" value=""></td>
     <td><input type="date" class="form-control col-width" name="datum_zaduzenja" value=""></td>
    <td><button type="button" class="btn btn-danger btn-sm delete-row">Obriši</button></td>
  </tr>
`;

            }

            debugger;
            if (Object.keys(vrsteData).length === counter) {
                row += `
  <tr class="vrste-placanja-data_tr nova_vrsta_placanja">
    <td>
      <select class="form-control new-vrste-placanja nov-key" name="sifra">${selectOptions}</select>
    </td>
    <td><input type="text" disabled class="form-control nov-naziv" name="naziv" value=""></td>
    <td><input type="text" class="form-control col-width " name="partija" value=""></td>
    <td><input type="number" class="form-control col-width" name="glavnica" value=""></td>
    <td><input type="number" class="form-control col-width" name="saldo" value=""></td>
    <td><input type="number" class="form-control col-width" name="rata" value=""></td>
    <td><input type="checkbox" class="form-control col-width" name="pocetak_zaduzenja" value=""></td>
    <td><input type="date" class="form-control col-width" name="datum_zaduzenja" value=""></td>
    <td><button type="button" class="btn btn-success btn-sm add-row">Dodaj</button></td>
  </tr>
`;
            }
            tbody.append(row);
        });

        if(counter==0){
            var row = `
  <tr class="vrste-placanja-data_tr nova_vrsta_placanja">
    <td>
      <select class="form-control new-vrste-placanja nov-key" name="sifra">${selectOptions}</select>
    </td>
    <td><input type="text" disabled class="form-control nov-naziv" name="naziv" value=""></td>
    <td><input type="text" class="form-control col-width " name="partija" value=""></td>
    <td><input type="number" class="form-control col-width" name="glavnica" value=""></td>
    <td><input type="number" class="form-control col-width" name="saldo" value=""></td>
    <td><input type="number" class="form-control col-width" name="rata" value=""></td>
    <td><input type="checkbox" class="form-control col-width" name="pocetak_zaduzenja" value=""></td>
    <td><input type="date" class="form-control col-width" name="datum_zaduzenja" value=""></td>
    <td><button type="button" class="btn btn-success btn-sm add-row">Dodaj</button></td>
  </tr>
`;
            tbody.append(row);

        }



    }

    // Call the function to populate the table
    populateTable(jsonData);

    // Add row button click event
    $(document).on('click', 'body  .add-row', function (event) {

        var column  = $(event.target).parent().parent();
        var glavnica = column.find(':input[name="glavnica"]');
        var partija = column.find(':input[name="partija"]');
        var saldo = column.find(':input[name="saldo"]');

        var listaKreditoraKey= column.find('.nov-key');

        if(listaKreditoraKey.val() !=='' && (glavnica.val() !=='' || partija.val() !==''  || saldo.val() !=='' ) ){

        var newRow = `
  <tr class="vrste-placanja-data_tr nova_vrsta_placanja">
    <td>
      <select class="form-control new-vrste-placanja nov-key" name="sifra">${selectOptions}</select>
    </td>
    <td><input type="text" class="form-control nov-naziv" disabled name="naziv" value=""></td>
    <td><input type="text" class="form-control col-width" name="partija" value=""></td>
    <td><input type="number" class="form-control col-width" name="glavnica"  value=""></td>
    <td><input type="number" class="form-control col-width" name="saldo" value=""></td>
    <td><input type="number" class="form-control col-width" name="rata" value=""></td>
    <td><input type="checkbox" class="form-control col-width" name="pocetak_zaduzenja"  value=""></td>
    <td><input type="date" class="form-control col-width" name="datum_zaduzenja"  value=""></td>
    <td><button type="button" class="btn btn-success btn-sm add-row">Dodaj</button></td>
  </tr>
`;

        $('#editableTable tbody').append(newRow);
        $(this).removeClass('btn-success');
        $(this).addClass('btn-danger');

        $(this).text("Obriši");
        $(this).removeClass('add-row');
        $(this).addClass('delete-row');
        }
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

        debugger;
        var listaKreditoraInputs = $('.vrste-placanja-data_tr');

        //nova_vrsta_placanja
        var record_id = event.target.dataset.recordId
        var listaKreditora = [];
        $.each(listaKreditoraInputs, function (index, input) {
            var data = {};

            debugger;
            var naziv = $(input).find(':input[name="naziv"]');
            var key = $(input).find(':input[name="sifra"]');
            var partija = $(input).find(':input[name="partija"]');
            var glavnica = $(input).find(':input[name="glavnica"]');
            var saldo = $(input).find(':input[name="saldo"]');
            var rata = $(input).find(':input[name="rata"]');
            var datum_zaduzenja = $(input).find(':input[name="datum_zaduzenja"]');

            key.val() !== '' ? data.key = key.val() : undefined;
            partija.val()  !== '' ? data.partija = partija.val() : undefined;
            glavnica.val() !== '' ? data.glavnica = glavnica.val() : undefined;
            saldo.val() !== '' ? data.saldo = saldo.val() : undefined;
            rata.val() !== '' ? data.rata = rata.val() : undefined;
            datum_zaduzenja.val() !== '' ? data.datum_zaduzenja = datum_zaduzenja.val() : undefined;
            naziv.val() !== '' ? data.naziv = naziv.val() : undefined;

            if(key.val() !=='' && (glavnica.val() !=='' || partija.val() !==''  || saldo.val() !=='')){
                listaKreditora.push(data);
            }
        });

            var _token = $('input[name="_token"]').val();

        $.ajax({
                url: storeAllRoute,
                type: 'POST',
                data: {
                    _token: _token,
                    vrste_placanja:listaKreditora,
                    record_id: record_id
                }, success: function (response) {
                    if (response.status) {
                        window.location.href = response.url;
                    } else {
                        // $("#statusMessage").text(response.message).addClass("text-danger");
                    }
                }, error: function (response) {


                }
            });

    });
});
