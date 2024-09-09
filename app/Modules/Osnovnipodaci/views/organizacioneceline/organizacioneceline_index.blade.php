@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>
        .error {
            border: 1px solid red;
        }

        .infoAcc {
            margin-bottom: 0;
        }

        #errorContainer {
            color: red;
            text-align: center;
            font-size: 2em;
            margin-bottom: 2em;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="content">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <!-- /.content -->
            <h1 class="text-center"> Troškovna mesta</h1>
            @if(count($data) > 0)
                <table class="table table-bordered table-striped mt-5">
                    <thead>
                    <tr>
                        <th>Sifra troskovnog mesta</th>
                        <th>Naziv Troskovnog Mesta</th>
                        <th>Poenteri</th>
                        <th>Odgovorna lica</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item->sifra_troskovnog_mesta }}</td>
                            <td>{{ $item->naziv_troskovnog_mesta }}</td>


                            <td>
                            @foreach($item->poenteri_ids as $userId)
                                    <p style="display:block;width:100%;"> {{$radniciFullData[$userId]->maticni_broj}} {{$radniciFullData[$userId]->prezime}}  {{$radniciFullData[$userId]->ime}}  </p>
                                @endforeach
                            </td>
                            <td>
                            @foreach($item->odgovorna_lica_ids as $userId)
                                    <p style="display:block;width:100%;"> {{$radniciFullData[$userId]->maticni_broj}} {{$radniciFullData[$userId]->prezime}}  {{$radniciFullData[$userId]->ime}} </p>
                                @endforeach
                            </td>

                            <td>{{ $item->active ? 'Yes' : 'No' }}</td>
                            <td>
                                <!-- Edit button -->
                                <a href="{{ route('organizacioneceline.edit', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">Izmeni</a>

                                <!-- Delete button -->
{{--                                <form action="{{ route('organizacioneceline.edit', ['id' => $item->id]) }}" method="post" style="display:inline;">--}}
{{--                                    @csrf--}}
{{--                                    @method('DELETE')--}}
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
{{--                                </form>--}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>No data available.</p>
            @endif
        </div>
        <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')
@endsection

