@extends('admin.layouts.dataTable')
@section('content')
    <section class="content-header">
        <h1>
            Cost
        </h1>
        <h3 style="color: red;margin-left: 100px;margin-top: -26px">Total : <span id="total_cost">0</span>/=</h3>

        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{route('cost.index')}}">Tables</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group no-margin">
                                        <input type="text" class="form-control" name="search" id="search" placeholder="Search"
                                               value="{{$search_key?$search_key:null}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control" name="category_type" id="category_type">
                                            <option value="">All Category</option>
                                            @foreach($categories as $cat)
                                                <option @if($type_key == $cat->id) selected
                                                        @endif value="{{$cat->id}}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group no-margin">
                                        <select class="form-control" name="month" id="month">
                                            <option value="">Month</option>
                                            <option @if($month_key == '01') selected @endif value="01">Jan</option>
                                            <option @if($month_key == '02') selected @endif value="02">Feb</option>
                                            <option @if($month_key =='03') selected @endif value="03">Mar</option>
                                            <option @if($month_key == '04') selected @endif value="04">Apr</option>
                                            <option @if($month_key == '05') selected @endif value="05">May</option>
                                            <option @if($month_key == '06') selected @endif value="06">Jun</option>
                                            <option @if($month_key == '07') selected @endif value="07">Jul</option>
                                            <option @if($month_key == '08') selected @endif value="08">Aug</option>
                                            <option @if($month_key == '09') selected @endif value="09">Sep</option>
                                            <option @if($month_key == '10') selected @endif value="10">Oct</option>
                                            <option @if($month_key == '11') selected @endif value="11">Nov</option>
                                            <option @if($month_key == '12') selected @endif value="12">Dec</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group no-margin">
                                        <select class="form-control" name="year" id="year">
                                            <option value="">Year</option>
                                            <option @if($year_key == '2019') selected @endif  value="2019">2019</option>
                                            <option @if($year_key == '2020') selected @endif  value="2020">2020</option>
                                            <option @if($year_key == '2021') selected @endif  value="2021">2021</option>
                                            <option @if($year_key == '2022') selected @endif  value="2022">2022</option>
                                            <option @if($year_key == '2023') selected @endif  value="2023">2023</option>
                                            <option @if($year_key == '2024') selected @endif  value="2024">2024</option>
                                            <option @if($year_key == '2025') selected @endif  value="2025">2025</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group no-margin">
                                        <input type="date"  name="date" id="date"  placeholder="Select Date" class="form-control" value="{{$date_key?$date_key:null}}">
                                    </div>
                                </div>
                                @if(Auth::user()->role == 1)
                                    <div class="col-md-2">
                                        <div class="form-group no-margin">
                                            <select class="form-control" name="user_type" id="user_type">
                                                <option value="">All User</option>
                                                @foreach($user as $user)
                                                    <option @if($user_key == $user->id) selected
                                                            @endif value="{{$user->id}}">{{ $user->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-2">
                                    <div class="form-group no-margin">
                                        <button type="submit" onclick="searchCostPage()" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:void(0)" onclick="CreateCostModal()"><button class="btn btn-sm btn-primary pull-right" style="float: left;">Create Cost</button></a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="wait" style="display:none;position:absolute;top:100%;left:50%;padding:2px;"><img src='{{ asset('img/demo_wait.gif') }}' width="64" height="64" /><br>Loading..</div>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center" width="100px">SL</th>
                                <th class="text-left" width="390px">Name</th>
                                <th class="text-center">Title</th>
                                <th class="text-right">Amount</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Category</th>
                                <th class="text-center" width="120px">Action</th>
                            </tr>
                            </thead>
                            <tbody id="costPageSearchBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <!-- /.modal -->
        <div class="modal fade" id="modal-create">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create cost</h4>
                    </div>

                    <div class="modal-body">

                        @if(Auth::user()->role == 1)

                            <div class="form-group" style="margin-left: 5px;">
                                <label for="exampleInputEmail1">User</label>
                                <select class="form-control select2" id="create_user_id" style="width: 98%;" name="user_id">
                                </select>
                            </div>
                        @endif
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Category</label>
                            <select class="form-control select2" style="width: 98%;" id="create_category_id" name="category_id">
                            </select>
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="name" class="form-control" id="create_title" name="title" placeholder="Title" style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Description</label>
                            <input type="name" class="form-control" id="create_description" name="description" placeholder="Description" style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Amount</label>
                            <input type="number" class="form-control" id="create_amount" name="amount" style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label>Cost Date</label>
                            <input type="date" class="form-control" id="create_cost_date" name="cost_date" style="width: 98%;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close </button>
                        <button type="button" id="create" onclick="create_cost(event)"  class="btn btn-primary">Add Changes</button>
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
@endsection

@push('script')
    <script>
        var id = null

        function CreateCostModal(){
            $('#modal-create').modal();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            $.ajax({
                    type: 'GET',
                    url: "cost/create",
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.status === 'success') {
                            let user = '';
                            for (let i = 0; i < results.data.users.length; i++){

                            user += ` <option value="${ results.data.users[i].id }" >${ results.data.users[i].name }</option>`;
                        }
                        $('#create_user_id').html(user);

                        let category = '';
                        for (let i = 0; i < results.data.categories.length; i++){

                            category += ` <option value="${ results.data.categories[i].id }" >${ results.data.categories[i].name }</option>`;
                        }
                        $('#create_category_id').html(category);

                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        };

        function create_cost(event){
            event.preventDefault();
            $('#create').attr('disabled','disabled');
            var create_user_id = $('#create_user_id').val();
            var create_category_id = $('#create_category_id').val();
            var create_title = $('#create_title').val();
            var create_description = $('#create_description').val();
            var create_amount = $('#create_amount').val();
            var create_cost_date = $('#create_cost_date').val();
            var data = {
                user_id:create_user_id,
                category_id:create_category_id,
                title:create_title,
                description:create_description,
                amount:create_amount,
                cost_date:create_cost_date
            }
            // console.log(data)
            if(create_user_id == '' || create_category_id == ''|| create_title == '' || create_description == '' || create_amount == '' || create_cost_date == ''){
                $.toaster({ message : 'Field is required!', title : 'Required', priority : 'danger' });
                $('#create').removeAttr('disabled');
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            $.ajax({
                method: "POST",
                url: "/cost", //resource route
                data: data,
                dataType: 'JSON',
                success: function( response ) {
                    $.toaster({ message : 'Created successfully', title : 'Success', priority : 'success' });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }

            });
        }


        function OpenEditCostModel(id){
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

        function searchCostPage() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let search = $('#search').val();
            let category_type = $('#category_type').val();
            let month = $('#month').val();
            let year = $('#year').val();
            let date = $('#date').val();
            let user_type = $('#user_type').val();
            let data = {
                _token: '{{  @csrf_token() }}',
                search: search,
                category_type: category_type,
                month: month,
                year: year,
                date: date,
                user_type: user_type
            };

            $('#wait').css('display', 'block'); // wait for loader

            console.log(data);
            $.ajax({
                type: 'post',
                url: "/cost/page/search",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    let html = '';
                    let name = '';
                    let date = '';
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        for (let index = 0; index < results.data.length; index++ ){
                            if(results.data[index].rel_category != null && results.data[index].rel_category != ''){
                                name = results.data[index].rel_category.name;
                            }
                            else{
                                name = '-';
                            }
                            if(results.data[index].cost_date != null && results.data[index].cost_date != ''){
                                time = results.data[index].cost_date.split(' ')[0];
                                date = new Date(time);
                                date = date.toDateString().split(' ')[2]+" "+date.toDateString().split(' ')[1]+" "+date.toDateString().split(' ')[3]
                            }
                            else{
                                date = '-';
                            }

                            html += `<tr>
                                        <td class="text-center" > ${ results.data[index].id } </td>
                                        <td class="text-left" > ${ results.data[index].rel_user.name } </td>
                                        <td class="text-center" > ${ results.data[index].title } </td>
                                        <td class="text-right">${ results.data[index].amount  } /= </td>
                                        <td class="text-center">${ date  } </td>
                                        <td class="text-center" > ${ name } </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default">Action</button>
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu pull-right" role="menu">
                                                    <li><a href="javascript:void(0)" onclick="OpenEditCostModel('${results.data[index].id}')"><i class="fa fa-fw fa-pencil-square-o"></i> Edit</a></li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a onclick="deleteconfirm('${results.data[index].id}')" href="javascript:void(0)"><i class="fa fa-fw fa-trash-o"></i> Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>`
                        }
                        $('#costPageSearchBody').html(html);
                        $('# ').html(results.total);
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        window.onload = function(){
            searchCostPage()
        }

    </script>
@endpush
