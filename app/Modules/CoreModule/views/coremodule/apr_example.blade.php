@extends('coremodule::adminlte.layout.app')

@section('custom-styles')
    <style>
        .error {
            border: 1px solid red;
        }

        .infoAcc{
            margin-bottom:0;
        }
        #errorContainer{
            color:red;
            text-align: center;
            font-size: 2em;
            margin-bottom: 2em;
        }
    </style>
@endsection

@section('content')
    <h1>TEST 1  VIEW FROM SECOND MODULE</h1>

    <div class="content-wrapper" style="height: auto">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <!-- /.content -->
        <div class="container">
            <div class="form-group">
                <label for="pib">Unesi matični broj firme:</label>
                <input type="text" id="pib" class="form-control" placeholder="MATICNI BROJ FIRME">
            </div>
        <button  class="btn btn-primary" id="submitBtn">Pošalji zahtev NBS</button>
        <div class="nbsResponse">
        </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



@section('custom-scripts')
<script>

  var pibValue = '109876187';

  $(document).ready(function() {
      $("#submitBtn").click(function () {
          var pibValue = $("#pib").val();
          $.ajax({
              url: '/getNbsData',
              method: 'GET',
              data: {
                  pib: pibValue
              },
              success: function (response) {


                  var data = response;
                  const container =$(".nbsResponse")[0];

                  for (const key in data) {
                      console.log(key)
                      console.log(data[key])

                          const h1Element = document.createElement("h1");
                          h1Element.textContent = 'Račun broj:' +  key


                      container.appendChild(h1Element);

                          // Set attributes for h1 element
                          for (const attr in data[key]) {
                              const pElement = document.createElement("p");
                              pElement.classList.add("infoAcc");

                              if(attr =='InitializationDate' || attr =='ChangeDate'|| attr =='UpdateDate'){
                                  var dateValue = new Date(data[key][attr]);
                                  pElement.textContent = attr + ' : ' + dateValue.getDay() +'.'+(dateValue.getMonth()+1) +'.'+dateValue.getFullYear();

                              }else {
                                  pElement.textContent = attr + ' : ' + data[key][attr];

                              }
                              container.appendChild(pElement);

                          }


                  }

              }
          })
      });
  });

</script>


@endsection

