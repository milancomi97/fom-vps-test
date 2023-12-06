@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>
        .main-footer {
            margin-top: 60vh;
        }

        #statusMessage {
            text-align: center;
            font-weight: 700;
        }

        #monthSlider {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
        }

        .month-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin: 10px 0;

        }

        .carousel-item {
            display: contents !important;
        }

    </style>
@endsection

@section('content')
    <div class="container mb-5">
        <div id="statusMessage"></div>
        <div class="container mb-5">
            <div id="monthSlider" class="border mb-5">
                <div class="row">
                    <div class="col-1">
                        <button class="btn btn-link" onclick="prevMonth()">&lt;</button>
                    </div>
                    <div class="col-10 text-center">
                        <h5 id="monthYear"></h5>
                    </div>
                    <div class="col-1 text-right">
                        <button class="btn btn-link" onclick="nextMonth()">&gt;</button>
                    </div>
                </div>
                <form>
                    @csrf
                </form>
                <div id="monthContainer" class="carousel slide " data-ride="carousel">


                    <div class="carousel-inner">
                        <div class="month-card">
                            <h5></h5>
                            <p>Status:</p>
                            <p>Rate: </p>
                            <p>User: </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('custom-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script>
        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();
        let databaseData = {!! $datotekaobracunskihkoeficijenata !!};

        function updateMonth(activeMonth) {

            const monthYearElement = document.getElementById('monthYear');
            monthYearElement.innerText = new Date(currentYear, activeMonth).toLocaleString('sr-Latn', {
                month: 'long',
                year: 'numeric'
            });
        }

        function updateMonthContainer(activeMonth) {

            const monthContainer = document.getElementById('monthContainer');
            monthContainer.innerHTML = '';

            // Add Month Cards dynamically
            for (let i = 0; i < 12; i++) {
                var currentActiveClass = i === activeMonth;
                if (currentActiveClass) {
                    const monthCard = document.createElement('div');
                    monthCard.classList.add('carousel-item');
                    monthCard.classList.add('active');

                    const monthData = getMonthData(i);

                    monthCard.innerHTML = `
        <div class="month-card ${currentActiveClass}">
          <h5>${monthData.month}</h5>
          <p>Status: ${monthData.status}</p>
          <p>Mesečni fond sati: ${monthData.mesecni_fond_sati}</p>
          <p>Rate: ${monthData.rate}</p>
          <p>User: ${monthData.user}</p>
          <button type="button" class='btn btn-success create-mesecna-poentaza' data-month='${monthData.currMonth}' data-year='${monthData.currYear}'>Kreiraj obračun</button>
        </div>
      `;

                    monthContainer.appendChild(monthCard);
                }

            }
        }

        function getMonthData(month) {
            var date = getDate(currentYear, month);

            var data = getFromDatabase(date)
            if (data) {
                debugger;
                return {
                    month: new Date(currentYear, month).toLocaleString('sr-Latn', {month: 'long'}),
                    status: data.status,
                    rate: 'Default Rate',
                    user: 'Default User',
                    mesecni_fond_sati: data.mesecni_fond_sati,
                    currYear: currentYear,
                    currMonth: month
                };
            } else {
                return {
                    month: new Date(currentYear, month).toLocaleString('sr-Latn', {month: 'long'}),
                    status: '0',
                    rate: 'Default Rate',
                    user: 'Default User',
                    currYear: currentYear,
                    currMonth: month
                };
            }
            // Replace this with your data fetching logic
            // For simplicity, using hardcoded data in this example
        }

        function getDate(currentYear, month) {
            let currentDate = new Date(currentYear, month);
            let year = currentDate.getFullYear();
            let months = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
            let day = currentDate.getDate().toString().padStart(2, '0');
            return `${year}-${months}-${day}`;
        }


        function getFromDatabase(date) {

            var currentMonthData = false;
            for (var obj of databaseData) {
                if (obj.datum === date) {
                    currentMonthData = obj;

                }
            }
            return currentMonthData
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

        $(document).ready(function () {
            // Attach a click event handler to the button
            $(document).on('click', 'body .create-mesecna-poentaza', function (e) {
                debugger;


                var year = $(this).data('year');
                var month = $(this).data('month')
                var _token = $('input[name="_token"]').val();

                debugger;
                $.ajax({
                    url: '{{ route('datotekaobracunskihkoeficijenata.store') }}', // Replace with your server URL
                    type: 'POST', // Use POST method to send data
                    data: {
                        year: year,
                        month: month,
                        _token: _token
                    },
                    success: function (response) {
                        debugger;
                        if (response.status) {
                            location.reload()
                        } else {
                            $("#statusMessage").text(response.message).addClass("text-danger");
                        }
                    },
                    error: function (response) {
                        debugger;
                        $("#statusMessage").text("Greska: " + response.message).addClass("error");
                    }
                });

            });
        });
    </script>
@endsection

