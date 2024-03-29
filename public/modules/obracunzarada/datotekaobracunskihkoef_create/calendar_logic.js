let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();

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


            $.each([
                {'label': 'Kalendarski broj dana', 'val': `${monthData.kalendarski_broj_dana}`},
                {'label': 'Prosečni godišnji fond sati', 'val': `${monthData.prosecni_godisnji_fond_sati}`},
                {'label': 'Mesečni fond sati', 'val': `${monthData.mesecni_fond_sati}`},
                {'label': 'Cena rada tekući', 'val': `${monthData.cena_rada_tekuci}`},
                {'label': 'Cena rada prethodni', 'val': `${monthData.cena_rada_prethodni}`},
                {'label': 'Vrednost akontacije', 'val': `${monthData.vrednost_akontacije}`},
            ], function(key, value) {

                if(value.val !=='undefined'){
                    list.append($('<li class="list-group-item">' +  value.label + ': ' + value.val + '</li>'));
                }else {
                    list.append($('<li class="list-group-item">' +  value.label + '</li>'));

                }
            });

            $(monthCard).append(list);



            if(monthData.status){

                $("<h1></h1>").attr({
                    'class': 'offset-1 col col-lg-5 mt-3 btn font-weight-bold',
                }).css('cursor','default').text('Izmena').appendTo(monthCard);

                $("<h1></h1>").attr({
                    'class': 'offset-1 col col-lg-5 mt-3 btn font-weight-bold',
                }).css('cursor','default').text('Obrada').appendTo(monthCard);

                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-info update-mesecna-poentaza offset-1 col-lg-5 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Ažuriranje obračunskih koeficijenata').appendTo(monthCard);


                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-success index-mesecna-obrada-priprema offset-1 col-lg-5 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Obrada plate').appendTo(monthCard);




                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-danger odobravanje-mesecna-poentaza offset-1 col-lg-5 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Priprema poentaže').appendTo(monthCard);

                $("<h1></h1>").attr({
                    'class': 'offset-1 col col-lg-5 mt-3 btn font-weight-bold EMPTY',
                }).text('Izveštaji obrada plata').css('cursor','default').appendTo(monthCard);



                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-primary index-mesecna-poentaza offset-1 col-lg-5 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-year': monthData.currYear,
                    'data-month': monthData.currMonth
                }).text('Unos poentaže po radniku').appendTo(monthCard);


                $("<h1></h1>").attr({
                    'class': 'offset-1 col col-lg-5 mt-3 btn font-weight-bold EMPTY',
                }).text('Poreska prijava').css('cursor','default').appendTo(monthCard);


                // Akontacije
                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-warning index-akontacija-mesecna-poentaza offset-1 col-lg-5 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Unos akontacije').appendTo(monthCard);

                $("<h1></h1>").attr({
                    'class': 'offset-1 col col-lg-5 mt-3 btn font-weight-bold EMPTY',
                }).text('Priprema podataka za banke').css('cursor','default').appendTo(monthCard);



                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-secondary index-fiksnap-mesecna-poentaza offset-1 col-lg-5 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Unos fiksnih plaćanja po radniku').appendTo(monthCard);

                $("<h1></h1>").attr({
                    'class': 'offset-1 col col-lg-5 mt-3 btn font-weight-bold EMPTY',
                }).text('Arhiva').css('cursor','default').appendTo(monthCard);



                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-dark index-krediti-mesecna-poentaza offset-1 col-lg-5 mt-3 border',
                    'data-month_id': monthData.month_id,
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Unos Kredita').appendTo(monthCard);


            }else{
                $('<button>').attr({
                    'type': 'button',
                    'class': 'btn btn-success create-mesecna-poentaza offset-1 col-lg-5 mt-3 border',
                    'data-month': monthData.currMonth,
                    'data-year': monthData.currYear
                }).text('Otvorite mesec').appendTo(monthCard);
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
