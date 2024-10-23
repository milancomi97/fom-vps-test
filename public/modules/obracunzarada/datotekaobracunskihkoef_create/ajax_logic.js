$(document).ready(function () {
    // Attach a click event handler to the button

    $('#enable_mesecni_fond_sati_praznika_modal').change(function() {
        var praznikInput = $('#mesecni_fond_sati_praznika_modal');
        if ($(this).is(':checked')) {
            praznikInput.prop('disabled', false);
            praznikInput.val(0);
        } else {
            praznikInput.prop('disabled', true);
            praznikInput.val(0);
        }
    });




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
        if(month_id !==''){
            $('#myModal').modal('hide');
            return null;

            var mesecni_fond_sati = $('#mesecni_fond_sati_modal').val();
            var year = $('.create-mesecna-poentaza').data('year');
            var month = $('.create-mesecna-poentaza').data('month')
            var prosecni_godisnji_fond_sati = $('#prosecni_godisnji_fond_sati_modal').val()
            var kalendarski_broj_dana =  $('#kalendarski_broj_dana_modal').val()
            var mesecni_fond_sati_praznika = $('#mesecni_fond_sati_praznika_modal').val();
            var cena_rada_tekuci = $('#cena_rada_tekuci_modal').val()
            var cena_rada_prethodni = $('#cena_rada_prethodni_modal').val()
            var period_isplate_do = $('#period_isplate_do_modal').val()
            var period_isplate_od = $('#period_isplate_od_modal').val()
            var vrednost_akontacije = $('#vrednost_akontacije_modal').val()
            var _token = $('input[name="_token"]').val();
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
                        mesecni_fond_sati_praznika:mesecni_fond_sati_praznika,
                        mesecni_fond_sati:mesecni_fond_sati,
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
            var mesecni_fond_sati_praznika = $('#mesecni_fond_sati_praznika_modal').val();
            var mesecni_fond_sati = $('#mesecni_fond_sati_modal').val();

            var _token = $('input[name="_token"]').val();
            vrednost_akontacije =0;

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
                        mesecni_fond_sati_praznika:mesecni_fond_sati_praznika,
                        mesecni_fond_sati:mesecni_fond_sati,
                        _token: _token
                    },
                    success: function (response) {
                        if (response.status) {
                            location.reload()
                        } else {
                            $("#statusModalMessage").text(response.message).addClass("text-danger");
                        }
                    },
                    error: function (response) {
                        $("#statusModalMessage").text("Greska: " + response.message).addClass("error");
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

    $(document).on('click', 'body .obradaproseka', function (e) {
        var id = $(this).data('month_id');
        window.location.href = obradaProsekaRoute + id;
    });

    $(document).on('click', 'body .priprema-banke', function (e) {
        var id = $(this).data('month_id');
        window.location.href = pripremaBankeRoute + id;
    });


    $(document).on('click', 'body .prikaz-po-vrsti-placanja', function (e) {
        var id = $(this).data('month_id');
        window.location.href = prikazPoVrstiPlacanjaRoute + id;
    });




    $(document).on('click', 'body .odobravanje-mesecna-poentaza', function (e) {
        var id = $(this).data('month_id');
        window.location.href = odobravanjeRoute + id;
    });

    $(document).on('click', 'body .index-akontacija-mesecna-poentaza', function (e) {
        var id = $(this).data('month_id');
        window.location.href = showAkontacijeRoute + id;
    });

    $(document).on('click', 'body .index-fiksnap-mesecna-poentaza', function (e) {
        var id = $(this).data('month_id');
        window.location.href = showFiksnapRoute + id;
    });

    $(document).on('click', 'body .index-krediti-mesecna-poentaza', function (e) {
        var id = $(this).data('month_id');
        window.location.href = showKreditiRoute + id;
    });


    // $(document).on('click', 'body .izvestaji-rang-lista-zarade', function (e) {
    //     var id = $(this).data('month_id');
    //     window.location.href = izvestajRangListaZarade + id;
    // });
    //
    // $(document).on('click', 'body .izvestaji-rekapitulacija-zarada', function (e) {
    //     var id = $(this).data('month_id');
    //     window.location.href = izvestajRekapitulaciajaZarade + id;
    // });

    // arhiviranjeMeseca
    $(document).on('click', 'body .arhiviranje_meseca', function (e) {

        var _token = $('input[name="_token"]').val();
        var month_id = $(this).data('month_id')




        Swal.fire({
            title: 'Da li želite da arhivirate?',
            text: $('#monthYear').text(),
            icon: 'warning',
            confirmButtonText: 'Arhiviraj',
            cancelButtonText: 'Odustani',
            showCancelButton: true,
            showCloseButton: true,
            confirmButtonColor: "#cc3f44",

        }).then((result) => {

            if(result.isConfirmed){

                $('.obrada-title').removeClass('hidden').text('Arhiviranje je u toku');
                $('.loading').removeClass('hidden')
                $('.main-container-calendar').addClass('hidden')

                $.ajax({
                    url: arhiviranjeMeseca,
                    type: 'POST',
                    data: {
                        month_id:month_id,
                        _token: _token
                    },
                    success: function (response) {
                        window.location.reload();

                    },
                    error: function (response) {
                        debugger;
                    }
                });
            }
            debugger;
        });

    });


    $(document).on('click', 'body .podesavanje-pristupa', function (e) {
        var id = $(this).data('month_id');
        window.location.href = showPodesavanjePristupa + id;
    });


    $(document).on('click', 'body .obrada', function (e) {

        debugger;
        var redirectUrl = $(this).data('url-redirect');

        // var buttons = document.querySelectorAll('button');
        // buttons.forEach(function(button) {
        //     button.disabled = true;
        // });
        $('.obrada-title').removeClass('hidden')
        $('.loading').removeClass('hidden')
        $('.main-container-calendar').addClass('hidden')

        var _token = $('input[name="_token"]').val();
        var month_id = $(this).data('month_id')

        $.ajax({
            url: indexObradaRoute,
            type: 'POST',
            data: {
                month_id:month_id,
                redirect_url:redirectUrl,
                _token: _token
            },
            success: function (response) {
                if(response.status){

                    Swal.fire({
                        title: 'Obrada je završena',
                        icon: 'success',
                        confirmButtonText: 'Potvrdi poruku',
                        showCloseButton: true,
                        confirmButtonColor: "#5cb85c"
                    }).then((result) => {
                        window.location.href = response.redirectUrl;
                });
                }


            },
            error: function (response) {
                debugger;
            }
        });

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
                debugger;
                $('#myModal').modal('show');
                $('.modal-backdrop').hide();
                $('#submitFormBtn').prop('id', 'updateFormBtn');
                $('#updateFormBtn').text('Izmeni');
                $('#exampleModalLabel').text('Izmena');
                $("#kalendarski_broj_dana_modal").val(response.kalendarski_broj_dana)
                $("#mesecni_fond_sati_modal").val(response.mesecni_fond_sati)
                $("#month_modal").val(parseInt(response.mesec))
                $("#year_modal").val(response.godina)
                $('#prosecni_godisnji_fond_sati_modal').val(response.prosecni_godisnji_fond_sati)
                $('#cena_rada_tekuci_modal').val(response.cena_rada_tekuci)
                $('#cena_rada_prethodni_modal').val(response.cena_rada_prethodni)
                $('#vrednost_akontacije_modal').val(response.vrednost_akontacije)
                $('#month_id').val(response.id);

                $('#period_isplate_od_modal').val(response.period_isplate_od)

                $('#period_isplate_do_modal').val(response.period_isplate_do)
            },
            error: function (response) {
            }
        });


    });






});
