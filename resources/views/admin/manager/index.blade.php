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
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header  with-border">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group no-margin">
                                        <input type="text" class="form-control" name="search" id="search" placeholder="Search" value="{{$search_key?$search_key:null}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group no-margin">
                                        <button id="search" type="submit" onclick="searchManager()" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:void(0)" onclick="CreateUserModal()"><button class="btn btn-sm btn-primary pull-right" style="float: left;">Create Manager</button></a>
                        </div>
                    </div>

                    <div class="box-body">
                        <div id="wait" style="display:none;position:absolute;top:100%;left:50%;padding:2px;"><img src='{{ asset('img/demo_wait.gif') }}' width="64" height="64" /><br>Loading..</div>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center" width="100px">SL</th>
                                <th class="text-left" width="390px">Manager Name</th>
                                <th class="text-left">Manager Email</th>
                                <th class="text-right">Deposit Balance</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="120px">Action</th>
                            </tr>
                            </thead>

                            <tbody id="managerSearchBody">

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
                        <h4 class="modal-title">Create Manager</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="margin-left: 5px;">
                            <label>Manager Name</label>
                            <input type="text" class="form-control"  id="create_name" name="name" placeholder="Name" style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label>Manager Email</label>
                            <input type="email" class="form-control" id="create_email" name="email" placeholder="E-mail" style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label>Password</label>
                            <input type="password" class="form-control"  id="create_password" autocomplete="off" name="password" placeholder="Password"  style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" placeholder="Confirm password" id="create_password_confirmation" name="password_confirmation" style="width: 98%;">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close </button>
                            <button type="button" id="create-user" onclick="create_user(event)"  class="btn btn-primary">Add Changes</button>
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
                        <h4 class="modal-title">Edit Manager</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="margin-left: 5px;">
                            <label>Manager Name</label>
                            <input type="text" class="form-control"  id="name" name="name" placeholder="Name" style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label>Manager Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label>Password</label>
                            <input type="password" class="form-control"  id="password" name="password" placeholder="Password"  style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" placeholder="Confirm password" id="password_confirmation" name="password_confirmation" style="width: 98%;">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close </button>
                            <button type="button" id="update_form" class="btn btn-primary">Add Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <!-- /.modal -->
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add balance to manager</h4>
                    </div>

                    <div class="modal-body">

                        <div class="form-group" style="margin-left: 5px;">
                            <label>Balance</label>
                            <input type="number" class="form-control" name="balance" id="balance" style="width: 98%;">
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Category</label>
                            <select class="form-control select2" style="width: 98%;" id="category_id" name="category_id">
                            </select>
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label>Deposit Date</label>
                            <input type="date" class="form-control" name="deposit_date" id="deposit_date" style="width: 98%;">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close
                        </button><button type="button" id="add_balance" onclick="updateBalance(event)" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        var id = null

        function CreateUserModal(){
            $('#modal-create').modal();
            $('#create_password').val('');
        };


        function create_user(event){
            event.preventDefault();
            $('#create-user').attr('disabled','disabled');
            var name = $('#create_name').val();
            var email = $('#create_email').val();
            var password = $('#create_password').val();
            var password_confirmation = $('#create_password_confirmation').val();
            var data = {
                name:name,
                email:email,
                password:password,
            }
            if(password != password_confirmation){
                $.toaster({ message : "password doesn't match...", title : 'Required', priority : 'danger' }, 1000);
                $('#create-user').removeAttr('disabled');
                return false;
            }
            if(name == '' || email == ''|| password == '' || password_confirmation == ''){
                $('#create-user').removeAttr('disabled');
                $.toaster({ message : 'Field is required!', title : 'Required', priority : 'danger' }, 1000);
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });

            $.ajax({
                method: "POST",
                url: "manager",
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

        function EditUserModal(id){
            console.log(id)
            $('#modal-edit').modal();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            $.ajax({
                type: 'GET',
                url: "/admin/manager/"+id+"/edit",
                dataType: 'JSON',
                success: function (results) {

                    if (results.status === 'success') {
                        // window.location.reload()
                        $('#name').val(results.data.name);
                        $('#email').val(results.data.email);
                        $('#password').val('');
                        $('#update_form').attr('onclick','update_user('+id+')');
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function update_user(id){
            $('#update_form').attr('disabled','disabled');
            var name = $('#name').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var password_confirmation = $('#password_confirmation').val();
            var data = {
                name:name,
                email:email,
                password:password
            }
            console.log(data)
            if(password != password_confirmation){

                $.toaster({ message : "password doesn't match...", title : 'Required', priority : 'danger' }, 1000);
                $('#update_form').removeAttr('disabled');
                return false;
            }
            if(name == '' || email == ''|| password == '' || password_confirmation == ''){

                $('#update_form').removeAttr('disabled');
                $.toaster({ message : 'Field is required!', title : 'Required', priority : 'danger' }, 1000);
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            $.ajax({
                method: "PUT",
                url: "/admin/manager/"+id,
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

        var user_id = null
        function OpenAddBalanceModel(id){
            user_id = id;
            console.log(user_id)
            $('#modal-default').modal();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            $.ajax({
                type: 'GET',
                url: "createBalance/"+id,
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 'success') {

                        let category = '';
                        for (let i = 0; i < results.data.categories.length; i++){
                            category += ` <option value="${ results.data.categories[i].id }" >${ results.data.categories[i].name }</option>`;
                        }
                        $('#category_id').html(category);

                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function updateBalance(event){
            event.preventDefault();
            $('#add_balance').attr('disabled','disabled');
            var balance = $('#balance').val();
            var category_id = $('#category_id').val();
            var deposit_date = $('#deposit_date').val();
            var data = {
                balance:balance,
                deposit_date:deposit_date,
                category_id:category_id,
                user_id:user_id

            }
            if(balance == '' ||category_id == '' || deposit_date == ''){

                $.toaster({ message : 'Field is required!', title : 'Required', priority : 'danger' }, 1000);
                $('#add_balance').removeAttr('disabled');
                return false;
            }
            console.log(data)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });

            $.ajax({

                method: "POST",
                url: "{{route('manager.balanceAdd')}}" ,

                data: data,

                success: function( response ) {
                    $.toaster({ message : 'Updated successfully', title : 'Success', priority : 'success' });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
            });
        }

        function disable(id){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let data = {id: id};
            $.ajax({

                method: "POST",
                url: "/admin/manager-disable/"+id,
                data: data,

                success: function( response ) {
                    $.toaster({ message : 'Disabled', title : 'Success', priority : 'success' });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
            });

        }

        function enable(id){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let data = {id: id};

            $.ajax({

                method: "POST",
                url: "/admin/manager-enable/"+id,
                data: data,
                success: function( response ) {
                    $.toaster({ message : 'Enabled', title : 'Success', priority : 'success' });
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
                        url: "/admin/manager/" + id,
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

        function searchManager(){


            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let search = $('#search').val();
            let data = {
                _token: '{{  @csrf_token() }}',
                search: search,
            };
            let status = '';
            $('#wait').css('display', 'block');
            $.ajax({
                type: 'post',
                url: "/manager/search",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    let html = '';
                    let action = '';

                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        for (let index = 0; index < results.data.length; index++ ){
                            if(results.data[index].status == 1){
                                status = '<span class="label label-success">Enable</span>';
                            }
                            else{
                                status = '<span class="label label-default">Disable</span>';
                            }
                            if(results.data[index].status == 1){

                                action = `<a href="javascript:void(0)" onclick="disable('${results.data[index].id}')"><i class="fa fa-fw fa-ban"></i> Disable</a>`;
                            }
                            else{
                                action = `<a href="javascript:void(0)" onclick="enable('${results.data[index].id}')"><i class="fa fa-fw fa-check"></i>Enable</a>`;
                            }
                            html += `<tr>
                                        <td class="text-center" > ${results.data[index].id } </td>
                                        <td class="text-left" ><a href="/admin/manager/${results.data[index].id }">${results.data[index].name }</a></td>
                                        <td class="text-left" > ${results.data[index].email } </td>
                                        <td class="text-right">${results.data[index].balance  } /= </td>
                                        <td class="text-center">
                                            ${ status }
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default">Action</button>
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu pull-right" role="menu">
                                                    <li><a href="javascript:void(0)" onclick="EditUserModal('${results.data[index].id}')"><i class="fa fa-fw fa-pencil-square-o"></i> Edit</a></li>
                                                    <li><a href="/admin/manager/${results.data[index].id}"><i class="fa fa-fw fa-search-plus"></i> View</a></li>
                                                    <li><a href="/cost?user_type=${results.data[index].id}"><i class="fa fa-fw fa-search-plus"></i>Cost History</a></li>
                                                <li class="divider"></li>
                                                <li><a href="javascript:void(0)" onclick="OpenAddBalanceModel('${results.data[index].id}')"><i class="fa fa-fw fa-plus"></i> Add Balance</a></li>
                                                <li class="divider"></li>
                                                <li> ${ action }</li>
                                                <li class="divider"></li>
                                                    <li>
                                                        <a onclick="deleteconfirm('${results.data[index].id}')" href="javascript:void(0)"><i class="fa fa-fw fa-trash-o"></i> Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>`
                        }
                        $('#managerSearchBody').html(html);
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }
        window.onload = function(){
            searchManager()
        }
    </script>
@endpush
