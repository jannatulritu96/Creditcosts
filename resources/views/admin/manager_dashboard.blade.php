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
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#activity" data-toggle="tab">Total History</a></li>
                        <li><a href="#deposit" data-toggle="tab" onclick="managerSearchDeposit()">Deposit History</a></li>
                        <li><a href="#timeline" data-toggle="tab" onclick="managerSearchCost()">Cost History</a></li>
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
                                                                <button id="search" type="submit" onclick="managerSearchTotalHistory()"
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
                                        <div id="history" style="display:none;width:69px;height:89px;position:absolute;top:42%;left:48%;padding:2px;z-index: 1;"><img src='{{ asset('img/demo_wait.gif') }}' width="64" height="64" /><br>Loading..</div>
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
                                                    <h3><span id="totalDepo">{{ $managerDeposit }}</span></h3>
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
                                                                    <button id="search" type="submit" onclick="managerSearchDeposit()" class="btn btn-primary">Search
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                    <div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;"><img src='{{ asset('img/demo_wait.gif') }}' width="64" height="64" /><br>Loading..</div>
                                                    <table id="example1" class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">Deposit Date</th>
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
                                                                    <button id="search" type="submit" onclick="managerSearchCost()" class="btn btn-primary">Search
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                    <div id="cost" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px; "><img src='{{ asset('img/demo_wait.gif') }}' width="64" height="64" /><br>Loading..</div>
                                                    <table id="example1" class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">Cost Date</th>
                                                            <th class="text-right">Balance</th>
                                                            <th class="text-center" width="120px">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="costSearchBody">
                                                        @foreach($cost as $co)
                                                            <tr>
                                                                <td class="text-center"
                                                                >{{isset($co->cost_date) ? date("j F, Y", strtotime($co->cost_date)):'-'}}</td>
                                                                <td class="text-right">{{isset($co->amount) ? $co->amount:'-'}} /= </td>
                                                            </tr>
                                                        @endforeach()
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
    <section class="content">
        <!-- /.modal -->
        <div class="modal fade" id="modal-edit">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit cost</h4>
                    </div>

                    <div class="modal-body">

                        @if(Auth::user()->role == 1)

                            <div class="form-group" style="margin-left: 5px;">
                                <label for="exampleInputEmail1">User</label>
                                <select class="form-control select2" id="user_id" style="width: 98%;" name="user_id">
                                </select>
                            </div>
                        @endif
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Category</label>
                            <select class="form-control select2" style="width: 98%;" id="category_id" name="category_id">
                                <option value="">-- Select Category --</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="name" class="form-control" id="title" name="title" placeholder="Title" style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Description</label>
                            <input type="name" class="form-control" id="description" name="description" placeholder="Description" style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label>Cost Date</label>
                            <input type="date" class="form-control" id="cost_date" name="cost_date" style="width: 98%;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close </button>
                        <button type="button" id="send_form" onclick="update_cost(id)" class="btn btn-primary">Add Changes</button>
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
                        type: 'DELETE', //delete method for resource route
                        url: "deposit/" + id,    //for resource route destory not needed
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
        function OpenCostEditModel(id){
            console.log(id)
            $('#modal-edit').modal();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            $.ajax({
                type: 'GET',
                url: "cost/"+id+"/edit",
                dataType: 'JSON',
                success: function (results) {

                    if (results.status === 'success') {
                        let user = '';
                        let selecteds = '';
                        for (let i = 0; i < results.data.users.length; i++){
                            if (results.data.users[i].id === results.data.cost.user_id){
                                selecteds = 'selected';
                            }
                            user += ` <option value="${ results.data.users[i].id }" ${ selecteds }>${ results.data.users[i].name }</option>`;
                            selecteds = '';
                        }
                        $('#user_id').html(user);

                        let category = '';
                        for (let i = 0; i < results.data.categories.length; i++){
                            if (results.data.categories[i].id === results.data.cost.category_id){
                                selecteds = 'selected';
                            }
                            category += ` <option value="${ results.data.categories[i].id }" ${ selecteds }>${ results.data.categories[i].name }</option>`;
                            selecteds = '';
                        }
                        $('#category_id').html(category);

                        $('#title').val(results.data.cost.title);
                        $('#description').val(results.data.cost.description);
                        $('#amount').val(results.data.cost.amount);
                        $('#cost_date').val(results.data.cost.cost_date.split(' ')[0]);
                     // console.log(results.data.cost.cost_date.split(' ')[0])
                        $('#send_form').attr('onclick','update_cost('+id+')');
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function update_cost(id){
            $('#send_form').attr('disabled','disabled');
            var user_id = $('#user_id').val();
            var category_id = $('#category_id').val();
            var title = $('#title').val();
            var description = $('#description').val();
            var amount = $('#amount').val();
            var cost_date = $('#cost_date').val();

            var data = {
                user_id:user_id,
                category_id:category_id,
                title:title,
                description:description,
                amount:amount,
                cost_date:cost_date
            }

            if(user_id == '' || category_id == ''|| title == '' || description == '' || amount == '' || cost_date == ''){

                $.toaster({ message : 'Field is required!', title : 'Required', priority : 'danger' }, 1000);
                $('#send_form').removeAttr('disabled')

                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            $.ajax({
                method: "PUT",
                url: "/cost/"+id, //resource route
                data: data,
                dataType: 'JSON',
                success: function( response ) {
                    $.toaster({ message : 'Updated successfully', title : 'Success', priority : 'success' });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }

            });
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

        function managerSearchTotalHistory() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let year = $('#activity_year').val();
            let month = $('#activity_month').val();
            let date = $('#activity_date').val();

            // alert(year);
            let data = {
                _token: '{{  @csrf_token() }}',
                year: year,
                month: month,
                date: date
            };
            $('#history').css('display', 'block');
            // console.log(data);

            $.ajax({
                type: 'post',
                url: "/manager/history/search",
                data: data,
                dataType: 'JSON',
                success: function (results) {

                    if (results.status === 'success') {
                        $('#history').css('display', 'none');
                        // window.location.reload()
                        $('#totalDepo').html(results.data.managerDeposit);
                        $('#totalCost').html(results.data.costs);
                        $('#totalBal').html(results.data.current_balance);
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });

        }

        function managerSearchDeposit() {
            $.ajaxSetup({
                headers: {
                   'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let depo_month = $('#depo_month').val();
            let depo_year = $('#depo_year').val();
            let depo_date = $('#depo_date').val();
            // alert(depo_month);
            let data = {
                _token: '{{  @csrf_token() }}',
                depo_year: depo_year,
                depo_month: depo_month,
                depo_date: depo_date
            };
            $('#wait').css('display', 'block');
            $.ajax({
                type: 'post',
                url: "/manager/deposit/search",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    let html = '';
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        let time = '';
                        let date = '';
                        for (let index = 0; index < results.data.length; index++ ){
                            if(results.data[index].deposit_date != null && results.data[index].deposit_date != ''){
                                time = results.data[index].deposit_date.split(' ')[0];
                                date = new Date(time);
                                date = date.toDateString().split(' ')[2]+" "+date.toDateString().split(' ')[1]+" "+date.toDateString().split(' ')[3]
                            }
                            else{
                                date = '-';
                            }
                            html += `<tr>
                                        <td class="text-center" > ${ date }  </td>
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

        function managerSearchCost() {

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
                cost_year: cost_year,
                cost_month: cost_month,
                costs_date: costs_date
            };
            $('#cost').css('display', 'block');

            $.ajax({
                type: 'post',
                url: "/manager/cost/search",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    let html = '';
                    if (results.status === 'success') {
                        $('#cost').css('display', 'none');
                        let time = '';
                        let date = '';
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
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="OpenCostEditModel('${results.data[index].id}')"><i class="fa fa-fw fa-pencil-square-o"></i> Edit</a>
                                                    </li>
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
