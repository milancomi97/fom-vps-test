// let currentMonth = new Date().getMonth();
// let currentYear = new Date().getFullYear();
let currentMonth = parseInt(activeMonth);
let currentYear = parseInt(activeYear);

function updateMonthContainer(activeMonth) {

    const monthContainer = document.getElementById('monthContainer');
    monthContainer.innerHTML = '';

    for (let i = 0; i < 12; i++) {
        var currentActiveClass = i === activeMonth;
        if (currentActiveClass) {
            const monthCard = document.createElement('div');

            monthCard.classList.add('carousel-item');
            monthCard.classList.add('active');

            const monthData = getMonthData(i);

            var list = $('<ul class="list-group mb-5"></ul>');

            var statusData ={'1':'U obradi','2':'Arhiviran'};
            if(monthData.status){
                var monthStatusString = statusData[monthData.status];

            }else{
                var monthStatusString = 'Mesec nije otvoren, zatvori prethodni.';

            }

            $.each([
                {'label': 'Kalendarski broj dana', 'val': `${monthData.kalendarski_broj_dana}`},
                // {'label': 'Prosečni godišnji fond sati', 'val': `${monthData.prosecni_godisnji_fond_sati}`},
                {'label': 'Mesečni fond sati', 'val': `${monthData.mesecni_fond_sati}`},
                {'label': 'Status meseca', 'val': `${monthStatusString}`},
                // {'label': 'Cena rada prethodni', 'val': `${monthData.cena_rada_prethodni}`},
            ], function(key, value) {
                debugger;

                if(value.label==='Status meseca') {
                    list.append($('<li class="list-group-item">' + value.label + ': <b>' + value.val + '</b></li>'));
                }else if(value.val !=='undefined'){
                        list.append($('<li class="list-group-item">' +  value.label + ': ' + value.val + '</li>'));
                }else{
                    list.append($('<li class="list-group-item">' +  value.label + ': 0</li>'));

                }



            });

            $(monthCard).append(list);


            if(monthData.status=='1'){

                $("<h1></h1>").attr({
                    'class': 'offset-1 col col-sm-3 mt-3 btn font-weight-bold',
                }).css('cursor','default').text('Izmena').appendTo(monthCard);

                $("<h1></h1>").attr({
                    'class': 'offset-1 col col-sm-3 mt-3 btn font-weight-bold',
                }).css('cursor','default').text('Obrada').appendTo(monthCard);

                $("<h1></h1>").attr({
                    'class': 'offset-1 col col-sm-3 mt-3 btn font-weight-bold',
                }).css('cursor','default').text('Izveštaji').appendTo(monthCard);

                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-primary update-mesecna-poentaza offset-1 col-sm-3 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Ažuriranje o. koeficijenata').appendTo(monthCard);

                // $("<h1></h1>").attr({
                //     'class': 'offset-1 col col-sm-3 mt-3 btn font-weight-bold',
                // }).css('cursor','default').text('Obrada').appendTo(monthCard);

                // IBRISI BLANK POLJE OFFSET


                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-success index-mesecna-obrada-priprema obrada offset-1 col-sm-3 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear,
                    'data-url-redirect':'obrada_plate'
                }).text('Obrada plate').appendTo(monthCard);



                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-warning izvestaji-rang-lista-zarade obrada offset-1 col-sm-3 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear,
                    'data-url-redirect':'rang_lista_zarada'
                }).text('Rang lista zarade').appendTo(monthCard);


                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-primary odobravanje-mesecna-poentaza offset-1 col-sm-3 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Priprema poentaže').appendTo(monthCard);


                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-success offset-1 obradaproseka col-sm-3 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Obrada proseka').appendTo(monthCard);

                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-warning izvestaji-rekapitulacija-zarada obrada offset-1 col-sm-3 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-year': monthData.currYear,
                    'data-month': monthData.currMonth,
                    'data-url-redirect':'rekapitulacija_zarada'
                }).text('Rekapitulacija zarade').appendTo(monthCard);

                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-primary index-mesecna-poentaza offset-1 col-sm-3 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-year': monthData.currYear,
                    'data-month': monthData.currMonth
                }).text('Unos poentaže po radniku').appendTo(monthCard);


                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-success poreska-prijava offset-1 col-sm-3 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Poreska prijava').appendTo(monthCard);



                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-warning index-mesecna-obrada-priprema obrada offset-1 col-sm-3 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear,
                    'data-url-redirect':'obracunski_listovi'
                }).text('Prikaz obracunskih lista').appendTo(monthCard);

                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-primary index-fiksnap-mesecna-poentaza offset-1 col-sm-3 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Unos f. plaćanja po radniku').appendTo(monthCard);


                // Akontacije AA klasa
                // $('<button>').attr({
                //     'type': 'button',
                //     'class': 'btn btn-primary index-akontacija-mesecna-poentazaa offset-1 col-sm-3 mt-3 border',
                //     'data-month_id': monthData.month_id,
                //     'data-month': monthData.currMonth,
                //     'data-year': monthData.currYear
                // }).text('Unos akontacije').appendTo(monthCard);

                // $("<h1></h1>").attr({
                //     'class': 'offset-1 col col-sm-3 mt-3 btn font-weight-bold EMPTY',
                // }).text('Priprema podataka za banke').css('cursor','default').appendTo(monthCard);


                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-success priprema-banke offset-1 col-sm-3 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Priprema podataka za banke').appendTo(monthCard);


                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-warning prikaz-po-vrsti-placanja offset-1 col-sm-3 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Prikaz po vrsti placanja').appendTo(monthCard);


                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-primary index-krediti-mesecna-poentaza offset-1 col-sm-3 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Unos Kredita').appendTo(monthCard);

                //
                // $("<h1></h1>").attr({
                //     'class': 'offset-1 col col-sm-3 mt-3 btn font-weight-bold EMPTY',
                // }).text('Arhiva').css('cursor','default').appendTo(monthCard);

                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-success arhiviranje_meseca offset-1 col-sm-3 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Arhiviraj - Zatvori mesec').appendTo(monthCard);


                $("<h1></h1>").attr({
                    'class': 'offset-1 col col-sm-3 mt-3 btn font-weight-bold EMPTY',
                }).text('').css('cursor','default').appendTo(monthCard);

                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-primary podesavanje-pristupa offset-1 col-sm-3 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Podesavanje pristupa poentazi').appendTo(monthCard);

            }else if(monthData.status=='2'){
                // $('<button>').attr({
                //     'type': 'button',
                //     'class': 'btn btn-warning arhiva_maticne_datoteke offset-1 col-sm-3 mt-3 border',
                //     'data-month': monthData.currMonth,
                //     'data-year': monthData.currYear
                // }).text('Arhiva maticne datoteke').appendTo(monthCard);
                //
                // $('<button>').attr({
                //     'type': 'button',
                //     'class': 'btn btn-warning obracunske_liste offset-1 col-sm-3 mt-3 border',
                //     'data-month': monthData.currMonth,
                //     'data-year': monthData.currYear
                // }).text('Obracunske liste').appendTo(monthCard);
                //
                // $('<button>').attr({
                //     'type': 'button',
                //     'class': 'btn btn-warning ukupna_rekapitulacija offset-1 col-sm-3 mt-3 border',
                //     'data-month': monthData.currMonth,
                //     'data-year': monthData.currYear
                // }).text('Ukupna rekapitulacija').appendTo(monthCard);

            }else{
                if(activeMonthExist==''){
                    $('<button>').attr({
                        'type': 'button',
                        'class': 'btn btn-success create-mesecna-poentaza offset-1 col-sm-3 mt-3 border',
                        'data-month': monthData.currMonth,
                        'data-year': monthData.currYear
                    }).text('Otvorite mesec').appendTo(monthCard);
                }
            }


            monthContainer.appendChild(monthCard);
        }

    }
}

function updateMonth(activeMonth) {

    const monthYearElement = document.getElementById('monthYear');
    const monthName = new Date(currentYear, activeMonth).toLocaleString('sr-Latn', {
        month: 'long',
        year: 'numeric'
    });
    monthYearElement.innerText = monthName.charAt(0).toUpperCase() + monthName.slice(1);
}

function getMonthData(month) {
    var date = getDate(currentYear, month);

    var data = getFromDatabase(date)
    var fullData = {};
    if (data) {
        fullData = {
            month: new Date(currentYear, month).toLocaleString('sr-Latn', {month: 'long'}),
            status: data.status,
            kalendarski_broj_dana:data.kalendarski_broj_dana,
            prosecni_godisnji_fond_sati:data.prosecni_godisnji_fond_sati,
            cena_rada_tekuci:data.cena_rada_tekuci,
            cena_rada_prethodni:data.cena_rada_prethodni,
            mesecni_fond_sati: data.mesecni_fond_sati,
            month_id: data.id,
            currYear: currentYear,
            currMonth: month,
            vrednost_akontacije: data.vrednost_akontacije
        };
    } else {
        fullData = {
            month: new Date(currentYear, month).toLocaleString('sr-Latn', {month: 'long'}),
            status: false,
            currYear: currentYear,
            currMonth: month,
            noData:true
        };
    }
    return fullData
}

function getDate(currentYear, month) {
    let currentDate = new Date(currentYear, month);
    let year = currentDate.getFullYear();
    let months = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
    let day = currentDate.getDate().toString().padStart(2, '0');
    return `${year}-${months}-${day}`;
}


function getFromDatabase(date) {
    return databaseData.find(obj => obj.datum === date) || null;
}

function prevMonth() {
    currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
    if (currentMonth === 11) {
        currentYear--;
    }
    updateMonth(currentMonth);
    updateMonthContainer(currentMonth);
}


function nextMonth() {
    currentMonth = (currentMonth === 11) ? 0 : currentMonth + 1;
    if (currentMonth === 0) {
        currentYear++;
    }
    updateMonth(currentMonth);
    updateMonthContainer(currentMonth);
}

// Initial rendering
updateMonth(currentMonth);
updateMonthContainer(currentMonth);
