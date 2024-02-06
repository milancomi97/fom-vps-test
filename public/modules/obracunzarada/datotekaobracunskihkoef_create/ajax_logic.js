$(document).ready(function () {
    // Attach a click event handler to the button
    $(document).on('click', 'body .create-mesecna-poentaza', function (e) {

        $('#myForm :input').val('');
        var _token = $('input[name="_token"]').val();
        var year = $('.create-mesecna-poentaza').data('year');
        var month = $('.create-mesecna-poentaza').data('month')
        $.ajax({
            url: getStoreDataRoute,
            type: 'POST',
            data: {
                month:month,
                year:year,
                _token: _token
            },
            success: function (response) {
                $('#myModal').modal('show');
                $('.modal-backdrop').hide();
                $("#kalendarski_broj_dana_modal").val(response.kalendarski_broj_dana)
                $("#mesecni_fond_sati_modal").val(response.mesecni_fond_sati)
                $("#month_modal").val(parseInt(month)+1)
                $("#year_modal").val(year)
            },
            error: function (response) {
            }
        });


    });

    $('#submitFormBtn').on('click', function () {

        // Swal.fire({
        //     title: 'Da li želite da otvorite mesec?',
        //     text: "Unesi dinamicki kasnije",
        //     icon: 'warning',
        //     confirmButtonText: 'Obriši',
        //     cancelButtonText: 'Odustani',
        //     showCancelButton: true,
        //     showCloseButton: true,
        //     confirmButtonColor: "#cc3f44",
        //
        // })

        var month_id = $('#month_id').val();
debugger;
        if(month_id !==''){
            var year = $('.create-mesecna-poentaza').data('year');
            var month = $('.create-mesecna-poentaza').data('month')
            var prosecni_godisnji_fond_sati = $('#prosecni_godisnji_fond_sati_modal').val()
            var kalendarski_broj_dana =  $('#kalendarski_broj_dana_modal').val()
            var cena_rada_tekuci = $('#cena_rada_tekuci_modal').val()
            var cena_rada_prethodni = $('#cena_rada_prethodni_modal').val()
            var period_isplate_do = $('#period_isplate_do_modal').val()
            var period_isplate_od = $('#period_isplate_od_modal').val()
            var vrednost_akontacije = $('#vrednost_akontacije_modal').val()

            var _token = $('input[name="_token"]').val();
            debugger;
            if(prosecni_godisnji_fond_sati !=='' && cena_rada_tekuci!=='' && cena_rada_prethodni!=='' && vrednost_akontacije!==''){

                $.ajax({
                    url: storeUpdateRoute,
                    type: 'POST',
                    data: {
                        month_id:month_id,
                        year: year,
                        month: month,
                        prosecni_godisnji_fond_sati:prosecni_godisnji_fond_sati,
                        cena_rada_tekuci:cena_rada_tekuci,
                        kalendarski_broj_dana:kalendarski_broj_dana,
                        cena_rada_prethodni:cena_rada_prethodni,
                        period_isplate_do:period_isplate_do,
                        period_isplate_od:period_isplate_od,
                        vrednost_akontacije:vrednost_akontacije,
                        month_id:month_id,
                        _token: _token
                    },
                    success: function (response) {
                        if (response.status) {
                            location.reload()
                        } else {
                            $("#statusMessage").text(response.message).addClass("text-danger");
                        }
                    },
                    error: function (response) {
                        $("#statusMessage").text("Greska: " + response.message).addClass("error");
                    }
                });
            }else {
                $("#statusModalMessage").text("Popunite sva polja").addClass("error");
            }

        } else {
            var year = $('.create-mesecna-poentaza').data('year');
            var month = $('.create-mesecna-poentaza').data('month')
            var prosecni_godisnji_fond_sati = $('#prosecni_godisnji_fond_sati_modal').val()
            var kalendarski_broj_dana =  $('#kalendarski_broj_dana_modal').val()
            var cena_rada_tekuci = $('#cena_rada_tekuci_modal').val()
            var cena_rada_prethodni = $('#cena_rada_prethodni_modal').val()
            var period_isplate_do = $('#period_isplate_do_modal').val()
            var period_isplate_od = $('#period_isplate_od_modal').val()
            var vrednost_akontacije = $('#vrednost_akontacije_modal').val()

            var _token = $('input[name="_token"]').val();
            debugger;
            if(prosecni_godisnji_fond_sati !=='' && cena_rada_tekuci!=='' && cena_rada_prethodni!=='' && vrednost_akontacije!==''){

                $.ajax({
                    url: storeRoute,
                    type: 'POST',
                    data: {
                        year: year,
                        month: month,
                        prosecni_godisnji_fond_sati:prosecni_godisnji_fond_sati,
                        cena_rada_tekuci:cena_rada_tekuci,
                        kalendarski_broj_dana:kalendarski_broj_dana,
                        cena_rada_prethodni:cena_rada_prethodni,
                        period_isplate_do:period_isplate_do,
                        period_isplate_od:period_isplate_od,
                        vrednost_akontacije:vrednost_akontacije,
                        month_id:month_id,
                        _token: _token
                    },
                    success: function (response) {
                        if (response.status) {
                            location.reload()
                        } else {
                            $("#statusMessage").text(response.message).addClass("text-danger");
                        }
                    },
                    error: function (response) {
                        $("#statusMessage").text("Greska: " + response.message).addClass("error");
                    }
                });
            }else {
                $("#statusModalMessage").text("Popunite sva polja").addClass("error");
            }
        }



    });
    $(document).on('click', 'body .index-mesecna-poentaza', function (e) {
        var id = $(this).data('month_id');
        window.location.href = showRoute + id;
    });



    $(document).on('click', 'body .odobravanje-mesecna-poentaza', function (e) {
        var id = $(this).data('month_id');
        window.location.href = odobravanjeRoute + id;
    });



    $(document).on('click', 'body .update-mesecna-poentaza', function (e) {
        var _token = $('input[name="_token"]').val();
        var month_id = $(this).data('month_id')

        $.ajax({
            url: getMonthDataByIdRoute,
            type: 'POST',
            data: {
                month_id:month_id,
                _token: _token
            },
            success: function (response) {
                $('#myModal').modal('show');
                $('.modal-backdrop').hide();
                $('#submitFormBtn').prop('id', 'updateFormBtn');
                $('#updateFormBtn').text('Izmeni');
                $("#kalendarski_broj_dana_modal").val(response.kalendarski_broj_dana)
                $("#mesecni_fond_sati_modal").val(response.mesecni_fond_sati)
                $("#month_modal").val(parseInt(response.mesec)+1)
                $("#year_modal").val(response.godina)
                $('#prosecni_godisnji_fond_sati_modal').val(response.prosecni_godisnji_fond_sati)
                $('#cena_rada_tekuci_modal').val(response.cena_rada_tekuci)
                $('#cena_rada_prethodni_modal').val(response.cena_rada_prethodni)
                $('#vrednost_akontacije_modal').val(response.vrednost_akontacije)
                $('#month_id').val(response.id)

            },
            error: function (response) {
            }
        });


    });


    $(document).on('click', 'body .check-mesecna-poentaza', function (e) {

        var month_id = $(this).data('month_id')
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: checkRoute,
            type: 'POST',
            data: {
                month_id:month_id,
                _token: _token
            },
            success: function (response) {
                $("#check_data").text(response.message).addClass("text-danger");
            },
            error: function (response) {
                $("#check_data").text("Greska: " + response.message).addClass("error");
            }
        });
    });


});
