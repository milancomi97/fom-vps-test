$(document).ready(function () {

    var jsonData = vrstePlacanjaData;
    var selectOptions ='<option value="">Izaberi vrstu plaćanja</option>'
    for (var key in vrstePlacanja) {

        selectOptions += '<option value="' + vrstePlacanja[key]['rbvp_sifra_vrste_placanja'] + '">' + vrstePlacanja[key]['rbvp_sifra_vrste_placanja'] + ' - ' + vrstePlacanja[key]['naziv_naziv_vrste_placanja'] + '</option>';
    }


    // Function to populate the table with JSON data
    function populateTable(vrsteData) {

        var tbody = $('#editableTable tbody');

        var counter = 0;

        $.each(vrsteData, function (index, item) {
            counter++;
            if(item.sati > 0 || item.iznos !== ''|| item.procenat !== ''){

            var row = `
  <tr class="vrste-placanja-data_tr">
    <td>
      <input disabled type="text" class="form-control" name="sifra" value="${item.sifra_vrste_placanja}">
    </td>
    <td><input disabled type="text" class="form-control" name="naziv" value="${item.naziv_vrste_placanja}"></td>
    <td><input type="number" class="form-control col-width" name="sati" value="${item.sati}"></td>
    <td><input type="number" class="form-control col-width" name="iznos" value="${item.iznos}"></td>
    <td><input type="number" class="form-control col-width" name="procenat" value="${item.procenat}"></td>
    <input type="hidden" name="update_id" value="${item.id}">
    <td><input type="text" class="form-control col-width" name="RJ_radna_jedinica" value=""></td>
    <td><input type="text" class="form-control col-width" name="BRIG_brigada" value=""></td>
    <td><button type="button" class="btn btn-danger btn-sm delete-row" data-delete-id="${item.id}">Obriši</button></td>
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
    <td><input type="number" class="form-control col-width " name="sati" value=""></td>
    <td><input type="number" class="form-control col-width" name="iznos" value=""></td>
    <td><input type="number" class="form-control col-width" name="procenat" value=""></td>
    <td><input type="text" class="form-control col-width" name="RJ_radna_jedinica" value=""></td>
    <td><input type="text" class="form-control col-width" name="BRIG_brigada" value=""></td>
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
    <td><input type="number" class="form-control col-width " name="sati" value=""></td>
    <td><input type="number" class="form-control col-width" name="iznos" value=""></td>
    <td><input type="number" class="form-control col-width" name="procenat" value=""></td>
    <td><input type="text" class="form-control col-width" name="RJ_radna_jedinica" value=""></td>
    <td><input type="text" class="form-control col-width" name="BRIG_brigada" value=""></td>
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
        var iznos = column.find(':input[name="iznos"]');
        var sati = column.find(':input[name="sati"]');
        var procenat = column.find(':input[name="procenat"]');

        var vrstePlacanjaKey= column.find('.nov-key');

        if(vrstePlacanjaKey.val() !=='' && (iznos.val() !=='' || sati.val() > 0  || procenat.val() !=='' ) ){

        var newRow = `
  <tr class="vrste-placanja-data_tr nova_vrsta_placanja">
    <td>
      <select class="form-control new-vrste-placanja nov-key" name="sifra">${selectOptions}</select>
    </td>
    <td><input type="text" class="form-control nov-naziv" disabled name="naziv" value=""></td>
    <td><input type="number" class="form-control col-width" name="sati" value=""></td>
    <td><input type="number" class="form-control col-width" name="iznos"  value=""></td>
    <td><input type="number" class="form-control col-width" name="procenat" value=""></td>
    <td><input type="text" class="form-control col-width" name="RJ_radna_jedinica" value=""></td>
    <td><input type="text" class="form-control col-width" name="BRIG_brigada"  value=""></td>
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

    $('#editableTable').on('click', '.delete-row', function () {
        var deleteId = $(this).data('delete-id');
        if(deleteId !==undefined){

            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: deleteVrstaPlacanjaData,
                type: 'POST',
                data: {
                    _token: _token,
                    record_id: deleteId
                }, success: function (response) {
                    Swal.fire({
                        title: 'Podatak je uspešno obrisan',
                        icon: 'success',
                        timer: 3000, // Show the Swal alert for 3 seconds
                        timerProgressBar: true, // Add a progress bar to the timer
                    }).then(() => {
                        // Reload the page after the alert is closed
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000); // 3 seconds delay
                    });
                    if (response.status) {




                    } else {
                        // $("#statusMessage").text(response.message).addClass("text-danger");
                    }
                }, error: function (response) {

                }
            });


        } else{
            $(this).closest('tr').remove();
        }
    });


    $(document).on('click', 'body .submitBtn', function (event) {
        event.stopImmediatePropagation();

        debugger;
        var vrstePlacanjaInputs = $('.vrste-placanja-data_tr');

        //nova_vrsta_placanja
        var record_id = event.target.dataset.recordId
        var vrstePlacanja = [];
        $.each(vrstePlacanjaInputs, function (index, input) {
            var data = {};

            debugger;
            var naziv = $(input).find(':input[name="naziv"]');
            var key = $(input).find(':input[name="sifra"]');
            var sati = $(input).find(':input[name="sati"]');
            var iznos = $(input).find(':input[name="iznos"]');
            var procenat = $(input).find(':input[name="procenat"]');
            var RJ_radna_jedinica = $(input).find(':input[name="RJ_radna_jedinica"]');
            var BRIG_brigada = $(input).find(':input[name="BRIG_brigada"]');
            var updateId = $(input).find(':input[name="update_id"]');

            key.val() !== '' ? data.key = key.val() : undefined;
            sati.val() !== 0 ? data.sati = sati.val() : undefined;
            iznos.val() !== '' ? data.iznos = iznos.val() : undefined;
            procenat.val() !== '' ? data.procenat = procenat.val() : undefined;
            RJ_radna_jedinica.val() !== '' ? data.RJ_radna_jedinica = RJ_radna_jedinica.val() : undefined;
            BRIG_brigada.val() !== '' ? data.BRIG_brigada = BRIG_brigada.val() : undefined;
            naziv.val() !== '' ? data.naziv = naziv.val() : undefined;
            updateId.val() !== '' ? data.updateId = updateId.val() : undefined;

            if(key.val() !=='' && (iznos.val() !=='' || sati.val() !==''  || procenat.val() !=='')){
                vrstePlacanja.push(data);
            }
        });

            var _token = $('input[name="_token"]').val();

        $.ajax({
                url: storeAllRoute,
                type: 'POST',
                data: {
                    _token: _token,
                    vrste_placanja:vrstePlacanja,
                    record_id: record_id
                }, success: function (response) {

                Swal.fire({
                    title: 'Podatak je uspešno izmenjen',
                    icon: 'success',
                    timer: 3000, // Show the Swal alert for 3 seconds
                    timerProgressBar: true, // Add a progress bar to the timer
                }).then(() => {
                    // Reload the page after the alert is closed
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000); // 3 seconds delay
                });

            }, error: function (response) {


                }
            });

    });
});
