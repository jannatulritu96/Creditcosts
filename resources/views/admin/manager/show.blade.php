@extends('admin.layouts.dataTable')
@section('content')
    <section class="content-header">
        <h1>
            Manager
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{route('manager.index')}}">Tables</a></li>
        </ol>
    </section>
    <section class="content">

        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle"
                             src="{{ asset('assets/dist/img/demo.jpg') }}" alt="{{$data->name}}">
                        <h3 class="profile-username text-center">{{$data->name}}</h3>
                        <p class="text-muted text-center">Manager</p>
                        <p class="text-muted text-center">{{$data->email}}</p>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#activity" data-toggle="tab">Total History</a></li>
                        <li><a href="#deposit" data-toggle="tab"  onclick="searchDeposit('{{ $data->id }}')" >Deposit History</a></li>
                        <li><a href="#timeline" data-toggle="tab" onclick="searchCost('{{ $data->id }}')" >Cost History</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                            <div class="post">
                                <div class="user-block">
                                    <section>
                                        <div class="box">
                                            <div class="box-header">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="form-group no-margin">
                                                                <select class="form-control" name="month" id="activity_month">
                                                                    <option value="">All Month</option>
                                                                    <option @if($month_key == '01') selected  @endif value="01">Jan </option>
                                                                    <option @if($month_key == '02') selected @endif value="02">Feb </option>
                                                                    <option @if($month_key =='03') selected @endif value="03">Mar </option>
                                                                    <option @if($month_key == '04') selected @endif value="04">Apr </option>
                                                                    <option @if($month_key == '05') selected @endif value="05">May </option>
                                                                    <option @if($month_key == '06') selected @endif value="06">Jun </option>
                                                                    <option @if($month_key == '07') selected @endif value="07">Jul </option>
                                                                    <option @if($month_key == '08') selected @endif value="08">Aug </option>
                                                                    <option @if($month_key == '09') selected @endif value="09">Sep </option>
                                                                    <option @if($month_key == '10') selected @endif value="10">Oct </option>
                                                                    <option @if($month_key == '11') selected @endif value="11">Nov </option>
                                                                    <option @if($month_key == '12') selected @endif value="12">Dec </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group no-margin">
                                                                <select class="form-control" name="year" id="activity_year">
                                                                    <option value="">All Year</option>
                                                                    <option @if($year_key == '2019') selected @endif  value="2019">2019 </option>
                                                                    <option @if($year_key == '2020') selected @endif  value="2020">2020 </option>
                                                                    <option @if($year_key == '2021') selected @endif  value="2021">2021 </option>
                                                                    <option @if($year_key == '2022') selected  @endif  value="2022">2022 </option>
                                                                    <option @if($year_key == '2023') selected  @endif  value="2023">2023 </option>
                                                                    <option @if($year_key == '2024') selected @endif  value="2024">2024 </option>
                                                                    <option @if($year_key == '2025') selected @endif  value="2025">2025 </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group no-margin">
                                                                <input type="date" name="date" id="activity_date" class="form-control" value="{{$date_key?$date_key:null}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group no-margin">
                                                                <button id="search" type="submit" onclick="searchTotalHistory('{{ $data->id }}')"
                                                                        class="btn btn-primary">Search
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <section class="content">
                                    <div class="row">
                                        <div id="history" style="display:none;position:absolute;top:42%;left:48%;padding:2px;z-index: 1;"><img src='{{ asset('img/demo_wait.gif') }}' width="64" height="64" /><br>Loading..</div>
                                        <div class="col-lg-4 col-xs-6">
                                            <!-- small box -->
                                            <div class="small-box bg-yellow">
                                                <div class="inner">
                                                    <h3><span id="totalCost">{{ $costs }}</span></h3>
                                                    <p>Total Cost</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-social-usd"></i>
                                                </div>
                                                <a href="{{ route('cost.index') }}" class="small-box-footer">More info
                                                    <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-xs-6">
                                            <!-- small box -->
                                            <div class="small-box bg-green">
                                                <div class="inner">
                                                    <h3><span id="totalDepo">{{ $deposite }}</span></h3>
                                                    <p>Total Deposite</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-stats-bars"></i>
                                                </div>
                                                <a href="#" class="small-box-footer" style="height: 22px;"></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-xs-6">
                                            <!-- small box -->
                                            <div class="small-box bg-aqua">
                                                <div class="inner">
                                                    <h3><span id="totalBal">{{ $current_balance}}</span></h3>
                                                    <p>Current balance</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-ios-pie"></i>
                                                </div>
                                                <a href="#" class="small-box-footer" style="height: 22px;"></a>
                                            </div>
                                        </div>
                                        <!-- ./col -->
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div class="tab-pane" id="deposit">
                            <div class="post">
                                <section class="content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-header">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="form-group no-margin">
                                                                    <select class="form-control" name="depo_month" id="depo_month">
                                                                        <option value="">All Month</option>
                                                                        <option @if($deposit_month_key == '01') selected @endif value="01">Jan </option>
                                                                        <option @if($deposit_month_key == '02') selected @endif value="02">Feb </option>
                                                                        <option @if($deposit_month_key =='03') selected @endif value="03">Mar </option>
                                                                        <option @if($deposit_month_key == '04') selected @endif value="04">Apr </option>
                                                                        <option @if($deposit_month_key == '05') selected @endif value="05">May </option>
                                                                        <option @if($deposit_month_key == '06') selected @endif value="06">Jun </option>
                                                                        <option @if($deposit_month_key == '07') selected @endif value="07">Jul </option>
                                                                        <option @if($deposit_month_key == '08') selected @endif value="08">Aug </option>
                                                                        <option @if($deposit_month_key == '09') selected @endif value="09">Sep </option>
                                                                        <option @if($deposit_month_key == '10') selected @endif value="10">Oct </option>
                                                                        <option @if($deposit_month_key == '11') selected @endif value="11">Nov </option>
                                                                        <option @if($deposit_month_key == '12') selected @endif value="12">Dec </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="form-group no-margin">
                                                                    <select class="form-control" name="depo_year" id="depo_year">
                                                                      <option value="">All Year</option>
                                                                        <option @if($deposit_year_key == '2019') selected @endif  value="2019">2019
                                                                        </option>
                                                                        <option @if($deposit_year_key == '2020') selected @endif  value="2020">2020
                                                                        </option>
                                                                        <option @if($deposit_year_key == '2021') selected @endif  value="2021">2021
                                                                        </option>
                                                                        <option  @if($deposit_year_key == '2022') selected @endif  value="2022">2022
                                                                        </option>
                                                                        <option @if($deposit_year_key == '2023') selected @endif  value="2023">2023
                                                                        </option>
                                                                        <option @if($deposit_year_key == '2024') selected @endif  value="2024">2024
                                                                        </option>
                                                                        <option @if($deposit_year_key == '2025') selected @endif  value="2025">2025
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group no-margin">
                                                                    <input type="date" name="depo_date" id="depo_date" class="form-control" value="{{$deposit_date_key?$deposit_date_key:null}}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group no-margin">
                                                                    <button id="search" type="submit" onclick="searchDeposit('{{ $data->id }}')" class="btn btn-primary">Search
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                    <div id="wait" style="display:none;position:absolute;top:50%;left:50%;padding:2px;"><img src='{{ asset('img/demo_wait.gif') }}' width="64" height="64" /><br>Loading..</div>
                                                    <table id="example1" class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">Deposit Date</th>
                                                            <th class="text-center">Category</th>
                                                            <th class="text-right">Balance</th>
                                                            <th class="text-center" width="120px">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="depositeSearchBody">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="timeline">
                            <div class="post">
                                <section class="content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-header">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="form-group no-margin">
                                                                    <select class="form-control" name="cost_month" id="cost_month">
                                                                        <option value="">All Month</option>
                                                                        <option @if($cost_month_key == '01') selected @endif value="01">Jan </option>
                                                                        <option @if($cost_month_key == '02') selected @endif value="02">Feb </option>
                                                                        <option @if($cost_month_key =='03') selected @endif value="03">Mar </option>
                                                                        <option @if($cost_month_key == '04') selected @endif value="04">Apr </option>
                                                                        <option @if($cost_month_key == '05') selected @endif value="05">May </option>
                                                                        <option @if($cost_month_key == '06') selected @endif value="06">Jun </option>
                                                                        <option @if($cost_month_key == '07') selected @endif value="07">Jul </option>
                                                                        <option @if($cost_month_key == '08') selected @endif value="08">Aug </option>
                                                                        <option @if($cost_month_key == '09') selected @endif value="09">Sep </option>
                                                                        <option @if($cost_month_key == '10') selected @endif value="10">Oct </option>
                                                                        <option @if($cost_month_key == '11') selected @endif value="11">Nov </option>
                                                                        <option @if($cost_month_key == '12') selected @endif value="12">Dec </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="form-group no-margin">
                                                                    <select class="form-control" name="cost_year" id="cost_year">
                                                                      <option value="">All Year</option>
                                                                        <option @if($cost_year_key == '2019') selected @endif  value="2019">2019
                                                                        </option>
                                                                        <option @if($cost_year_key == '2020') selected @endif  value="2020">2020
                                                                        </option>
                                                                        <option @if($cost_year_key == '2021') selected @endif  value="2021">2021
                                                                        </option>
                                                                        <option  @if($cost_year_key == '2022') selected @endif  value="2022">2022
                                                                        </option>
                                                                        <option @if($cost_year_key == '2023') selected @endif  value="2023">2023
                                                                        </option>
                                                                        <option @if($cost_year_key == '2024') selected @endif  value="2024">2024
                                                                        </option>
                                                                        <option @if($cost_year_key == '2025') selected @endif  value="2025">2025
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group no-margin">
                                                                    <input type="date" name="costs_date" id="costs_date" class="form-control" value="{{$cost_date_key?$cost_date_key:null}}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group no-margin">
                                                                    <button id="search" type="submit" onclick="searchCost('{{ $data->id }}')" class="btn btn-primary">Search
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                    <div id="cost" style="display:none;position:absolute;top:50%;left:50%;padding:2px; "><img src='{{ asset('img/demo_wait.gif') }}' width="64" height="64" /><br>Loading..</div>
                                                    <table id="example1" class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">Cost Date</th>
                                                            <th class="text-right">Balance</th>
                                                            <th class="text-center" width="120px">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="costSearchBody">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
         function deleteconfirm(id) {
            swal({
                title: "Delete?",
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    $.ajax({
                        type: 'GET',
                        url: "/depo/destroy/" + id,
                        dataType: 'JSON',
                        success: function (results) {

                            if (results.success === true) {
                                swal("Done!", results.message, "success").then(function () {

                                    window.location.reload()
                                })
                            } else {
                                swal("Error!", results.message, "error");
                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function (dismiss) {
                return false;
            })
        }

        function costDeleteconfirm(id) {
            swal({
                title: "Delete?",
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    $.ajax({
                        type: 'DELETE',
                        url: "<?php echo e(url('cost')); ?>/" + id,
                        data: {_token: '{{  @csrf_token() }}' },
                        dataType: 'JSON',
                        success: function (results) {

                            if (results.success === true) {
                                swal("Done!", results.message, "success").then(function () {

                                    window.location.reload()
                                })
                            } else {
                                swal("Error!", results.message, "error");
                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function (dismiss) {
                return false;
            })
        }


        function searchTotalHistory(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let year = $('#activity_year').val();
            let month = $('#activity_month').val();
            let date = $('#activity_date').val();

            // alert(date);
            let data = {
                _token: '{{  @csrf_token() }}',
                id: id,
                year: year,
                month: month,
                date: date
            };
            $('#history').css('display', 'block');

            $.ajax({
                type: 'post',
                url: "/history/search",
                data: data,
                dataType: 'JSON',
                success: function (results) {

                    if (results.status === 'success') {
                        $('#history').css('display', 'none');
                        // window.location.reload()
                        $('#totalDepo').html(results.data.deposite);
                        $('#totalCost').html(results.data.costs);
                        $('#totalBal').html(results.data.current_balance);
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });

        }

        function searchDeposit(id) {
            $.ajaxSetup({
                headers: {
                   'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let depo_month = $('#depo_month').val();
            let depo_year = $('#depo_year').val();
            let depo_date = $('#depo_date').val();
            let depo_category_id = $('#depo_category_id').val();
            // alert(depo_month);
            let data = {
                _token: '{{  @csrf_token() }}',
                id: id,
                depo_year: depo_year,
                depo_month: depo_month,
                depo_date: depo_date,
                category_id: depo_category_id
            };
            $('#wait').css('display', 'block');
            // console.log(data);
            $.ajax({
                type: 'post',
                url: "/deposit/search",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    let html = '';
                    let name = '';
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        let time = '';
                        let date = '';
                        for (let index = 0; index < results.data.length; index++ ){

                            if(results.data[index].category != null && results.data[index].category != ''){
                                name = results.data[index].category.name;
                            }
                            else{
                                name = '-';
                            }
                            if(results.data[index].deposit_date != null && results.data[index].deposit_date != ''){
                                time = results.data[index].deposit_date.split(' ')[0];
                                date = new Date(time);
                                date = date.toDateString().split(' ')[2]+" "+date.toDateString().split(' ')[1]+" "+date.toDateString().split(' ')[3]
                            }
                            else{
                                date = '-';
                            }
                            html += `<tr>
                                        <td class="text-center" >${date } </td>
                                        <td class="text-center" >${ name } </td>
                                        <td class="text-right">${results.data[index].amount  } /= </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default">Action</button>
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu pull-right" role="menu">
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a onclick="deleteconfirm('${results.data[index].id}')" href="javascript:void(0)"><i class="fa fa-fw fa-trash-o"></i> Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>`
                        }
                        $('#depositeSearchBody') .html(html);
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function searchCost(id) {
            $.ajaxSetup({
                headers: {
                   'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let cost_month = $('#cost_month').val();
            let cost_year = $('#cost_year').val();
            let costs_date = $('#costs_date').val();
            // alert(cost_month);
            let data = {
                _token: '{{  @csrf_token() }}',
                id: id,
                cost_year: cost_year,
                cost_month: cost_month,
                costs_date: costs_date
            };
            $('#cost').css('display', 'block');

            $.ajax({
                type: 'post', //delete method for resource route
                url: "/cost/search",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    let html = '';
                    let date = '';
                    if (results.status === 'success') {
                        $('#cost').css('display', 'none');
                        for (let index = 0; index < results.data.length; index++ ){
                            if(results.data[index].cost_date != null && results.data[index].cost_date != ''){
                                time = results.data[index].cost_date.split(' ')[0];
                                date = new Date(time);
                                date = date.toDateString().split(' ')[2]+" "+date.toDateString().split(' ')[1]+" "+date.toDateString().split(' ')[3]
                            }
                            else{
                                date = '-';
                            }
                            html +=    `<tr>
                                            <td class="text-center" > ${ date } </td>
                                            <td class="text-right">${results.data[index].amount  } /= </td>
                                            <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default">Action</button>
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu pull-right" role="menu">
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a onclick="costDeleteconfirm('${results.data[index].id}')" href="javascript:void(0)"><i class="fa fa-fw fa-trash-o"></i> Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        </tr>`
                        }
                        $('#costSearchBody').html(html);
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }
    </script>
@endsection
