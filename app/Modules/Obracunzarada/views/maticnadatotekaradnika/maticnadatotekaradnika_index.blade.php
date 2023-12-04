@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
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
            <h1 class="text-center"> PRIKAZ MDR </h1>
            <div class="data">
                {!! $maticnadatotekaradnika!!}
            </div>




            <div class="container">
                <h1> Primer  1</h1>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Employee
                        </div>
                        <div class="panel-body">
                            <table class="table table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Fist Name</th>
                                    <th>Last Name</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Status</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr data-toggle="collapse" data-target="#demo1" class="accordion-toggle">
                                    <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                    <td>Carlos</td>
                                    <td>Mathias</td>
                                    <td>Leme</td>
                                    <td>SP</td>
                                    <td>new</td>
                                </tr>

                                <tr>
                                    <td colspan="12" class="hiddenRow">
                                        <div class="accordian-body collapse" id="demo1">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr class="info">
                                                    <th>Job</th>
                                                    <th>Company</th>
                                                    <th>Salary</th>
                                                    <th>Date On</th>
                                                    <th>Date off</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>

                                                <tbody>

                                                <tr data-toggle="collapse"  class="accordion-toggle" data-target="#demo10">
                                                    <td> <a href="#">Enginner Software</a></td>
                                                    <td>Google</td>
                                                    <td>U$8.00000 </td>
                                                    <td> 2016/09/27</td>
                                                    <td> 2017/09/27</td>
                                                    <td>
                                                        <a href="#" class="btn btn-default btn-sm">
                                                            <i class="glyphicon glyphicon-cog"></i>
                                                        </a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="12" class="hiddenRow">
                                                        <div class="accordian-body collapse" id="demo10">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <td><a href="#"> XPTO 1</a></td>
                                                                    <td>XPTO 2</td>
                                                                    <td>Obs</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>item 1</th>
                                                                    <th>item 2</th>
                                                                    <th>item 3 </th>
                                                                    <th>item 4</th>
                                                                    <th>item 5</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>item 1</td>
                                                                    <td>item 2</td>
                                                                    <td>item 3</td>
                                                                    <td>item 4</td>
                                                                    <td>item 5</td>
                                                                    <td>
                                                                        <a href="#" class="btn btn-default btn-sm">
                                                                            <i class="glyphicon glyphicon-cog"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Scrum Master</td>
                                                    <td>Google</td>
                                                    <td>U$8.00000 </td>
                                                    <td> 2016/09/27</td>
                                                    <td> 2017/09/27</td>
                                                    <td> <a href="#" class="btn btn-default btn-sm">
                                                            <i class="glyphicon glyphicon-cog"></i>
                                                        </a>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td>Back-end</td>
                                                    <td>Google</td>
                                                    <td>U$8.00000 </td>
                                                    <td> 2016/09/27</td>
                                                    <td> 2017/09/27</td>
                                                    <td> <a href="#" class="btn btn-default btn-sm">
                                                            <i class="glyphicon glyphicon-cog"></i>
                                                        </a>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td>Front-end</td>
                                                    <td>Google</td>
                                                    <td>U$8.00000 </td>
                                                    <td> 2016/09/27</td>
                                                    <td> 2017/09/27</td>
                                                    <td> <a href="#" class="btn btn-default btn-sm">
                                                            <i class="glyphicon glyphicon-cog"></i>
                                                        </a>
                                                    </td>
                                                </tr>


                                                </tbody>
                                            </table>

                                        </div>
                                    </td>
                                </tr>



                                <tr data-toggle="collapse" data-target="#demo2" class="accordion-toggle">
                                    <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                    <td>Silvio</td>
                                    <td>Santos</td>
                                    <td>São Paulo</td>
                                    <td>SP</td>
                                    <td> new</td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="hiddenRow"><div id="demo2" class="accordian-body collapse">Demo2</div></td>
                                </tr>
                                <tr data-toggle="collapse" data-target="#demo3" class="accordion-toggle">
                                    <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                    <td>John</td>
                                    <td>Doe</td>
                                    <td>Dracena</td>
                                    <td>SP</td>
                                    <td> New</td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="hiddenRow"><div id="demo3" class="accordian-body collapse">Demo3 sadasdasdasdasdas</div></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>




            <div class="container">
                <h1> Primer  2</h1>
                <table class="table table-bordered table-sm ">
                    <thead class="thead-dark">
                    <tr>
                        <th>Column</th>
                        <th>Column</th>
                        <th>Column</th>
                        <th>Column</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="clickable" data-toggle="collapse" data-target="#group-of-rows-1" aria-expanded="false" aria-controls="group-of-rows-1">
                        <td><i class="fa fa-folder"></i></td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                    </tr>
                    </tbody>
                    <tbody id="group-of-rows-1" class="collapse">
                    <tr class="table-warning">
                        <td><i class="fa fa-folder-open"></i> child row</td>
                        <td>data 1</td>
                        <td>data 1</td>
                        <td>data 1</td>
                    </tr>
                    <tr class="table-warning">
                        <td><i class="fa fa-folder-open"></i> child row</td>
                        <td>data 1</td>
                        <td>data 1</td>
                        <td>data 1</td>
                    </tr>
                    </tbody>
                    <tbody>
                    <tr class="clickable" data-toggle="collapse" data-target="#group-of-rows-2" aria-expanded="false" aria-controls="group-of-rows-2">
                        <td><i class="fa fa-folder"></i></td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                    </tr>
                    </tbody>
                    <tbody id="group-of-rows-2" class="collapse">
                    <tr class="table-warning">
                        <td><i class="fa fa-folder-open"></i> child row</td>
                        <td>data 2</td>
                        <td>data 2</td>
                        <td>data 2</td>
                    </tr>
                    <tr class="table-warning">
                        <td><i class="fa fa-folder-open"></i> child row</td>
                        <td>data 2</td>
                        <td>data 2</td>
                        <td>data 2</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')
@endsection

