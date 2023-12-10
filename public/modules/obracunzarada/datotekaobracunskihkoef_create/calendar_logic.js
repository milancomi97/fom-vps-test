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

            $('<h5>').text(monthData.month).appendTo(monthCard);
            $('<p>').text(`Status: ${monthData.status}`).appendTo(monthCard);
            $('<p>').text(`Mesečni fond sati: ${monthData.mesecni_fond_sati}`).appendTo(monthCard);
            $('<p>').text(`Rate: ${monthData.rate}`).appendTo(monthCard);
            $('<p>').text(`User: ${monthData.user}`).appendTo(monthCard);

            $('<button>').attr({
                'type': 'button',
                'class': 'btn btn-success create-mesecna-poentaza col-lg-3 mt-1 border',
                'data-month': monthData.currMonth,
                'data-year': monthData.currYear
            }).text('Otvorite mesec').appendTo(monthCard);

            $('<button>').attr({
                'type': 'button',
                'class': 'btn btn-primary index-mesecna-poentaza col-lg-3 mt-1 border',
                'data-month_id': monthData.month_id,
                'data-year': monthData.currYear,
                'data-month': monthData.currMonth
            }).text('Prikaz podataka').appendTo(monthCard);

            $('<button>').attr({
                'type': 'button',
                'class': 'btn btn-secondary check-mesecna-poentaza col-lg-3 mt-1 border',
                'data-month_id': monthData.month_id,
                'data-month': monthData.currMonth,
                'data-year': monthData.currYear
            }).text('Provera statusa/detalji').appendTo(monthCard);

            monthContainer.appendChild(monthCard);
        }

    }
}

function updateMonth(activeMonth) {

    const monthYearElement = document.getElementById('monthYear');
    monthYearElement.innerText = new Date(currentYear, activeMonth).toLocaleString('sr-Latn', {
        month: 'long',
        year: 'numeric'
    });
}

function getMonthData(month) {
    var date = getDate(currentYear, month);

    var data = getFromDatabase(date)
    var fullData = {};
    if (data) {
        fullData = {
            month: new Date(currentYear, month).toLocaleString('sr-Latn', {month: 'long'}),
            status: data.status,
            rate: 'Default Rate',
            user: 'Default User',
            mesecni_fond_sati: data.mesecni_fond_sati,
            month_id: data.id,
            currYear: currentYear,
            currMonth: month
        };
    } else {
        fullData = {
            month: new Date(currentYear, month).toLocaleString('sr-Latn', {month: 'long'}),
            status: '0',
            rate: 'Default Rate',
            user: 'Default User',
            currYear: currentYear,
            currMonth: month
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
