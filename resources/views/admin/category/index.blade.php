@extends('admin.layouts.dataTable')
@section('content')
    <section class="content-header">
        <h1>
            Category
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{route('category.index')}}">Tables</a></li>
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
                                        <button type="submit" onclick="searchCategoryPage()" class="btn btn-primary">
                                            Search
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:void(0)" onclick="CreateCategory()">
                                <button class="btn btn-sm btn-primary pull-right" style="float: left;">Create
                                    Category
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="wait" style="display:none;position:absolute;top:50%;left:50%;padding:2px;"><img
                                src='{{ asset('img/demo_wait.gif') }}' width="64" height="64"/><br>Loading..
                        </div>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center" width="100px">SL</th>
                                <th class="text-left">Name</th>
                                <th class="text-right">Deposit Amount</th>
                                <th class="text-right">Cost Amount</th>
                                <th class="text-right">Balance</th>
                                <th class="text-center" width="120px">Action</th>
                            </tr>
                            </thead>
                            <tbody id="categoryBody">

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
                        <h4 class="modal-title">Create category</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="name" class="form-control" id="create_name" name="name" placeholder="Name"
                                   style="width: 98%;">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" id="create" onclick="create_category(event)" class="btn btn-primary">
                                Add Changes
                            </button>
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
                        <h4 class="modal-title">Edit category</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="name" class="form-control" id="name" name="name" placeholder="Name"
                                   style="width: 98%;">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" id="send_form" onclick="update_category(id)" class="btn btn-primary">
                                Add Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')

    <script>
        var id = null;

        // Create modal
        function CreateCategory() {
            $('#modal-create').modal();
        };

        function create_category(event) {
            event.preventDefault();
            $('#create').attr('disabled', 'disabled');
            var name = $('#create_name').val();
            var data = {
                name: name
            }

            console.log(data)

            if(name == ''){

                $.toaster({ message : 'Field is required!', title : 'Required', priority : 'danger' }, 1000);
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
                url: "category/store" ,
                data: data,
                success: function (response) {

                    $.toaster({ message : 'Created successfully', title : 'Success', priority : 'success' }, 1000);
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);

                }

            });
        }

        // edit modal
        function categoryEditModal(id) {
            console.log(id)
            $('#modal-edit').modal();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            $.ajax({
                type: 'GET',
                url: "category/edit/" + id,
                dataType: 'JSON',
                success: function (results) {

                    if (results.status === 'success') {
                        $('#name').val(results.data.category.name);

                        $('#send_form').attr('onclick', 'update_category(' + id + ')');
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });

        }

        function update_category(id) {
            $('#send_form').attr('disabled', 'disabled');
            var name = $('#name').val();
            var data = {
                name: name
            }
            if(name == ''){
                $.toaster({ message : 'Field is required!', title : 'Required', priority : 'danger' }, 1000);
                $('#send_form').removeAttr('disabled');
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            $.ajax({
                method: "POST",
                url: "/category/update/" + id,
                data: data,
                dataType: 'JSON',
                success: function (response) {

                    $.toaster({message: 'Updated successfully', title: 'Success', priority: 'success'});
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
                        type: 'GET',
                        url: "<?php echo e(url('category/destroy')); ?>/" + id,
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

        function searchCategoryPage() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let month = $('#month').val();
            let year = $('#year').val();
            // alert(month);
            let data = {
                _token: '{{  @csrf_token() }}',
                month: month,
                year: year,
            };

            $('#wait').css('display', 'block');
            // console.log(data);
            $.ajax({
                type: 'post',
                url: "/category/page/search",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    let html = '';
                    let design = '';
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        // console.log(results.data.categories);

                        for (let index = 0; index < results.data.categories.length; index++) {
                            if (results.data.categories[index].balanceAmount - results.data.categories[index].costAmount <= 0 && (results.data.categories[index].balanceAmount > 0 || results.data.categories[index].costAmount > 0)) {
                                design = '<tr class="bg-danger">';
                            } else {
                                design = '<tr>';
                            }

                            html += ` ${design}
                                        <td class="text-center" > ${results.data.categories[index].id} </td>
                                        <td class="text-left" ><a href="/cost?category_type=${results.data.categories[index].id}">${results.data.categories[index].name}</a></td>
                                        <td class="text-right" > ${results.data.categories[index].balanceAmount} /= </td>
                                        <td class="text-right">${results.data.categories[index].costAmount} /= </td>
                                        <td class="text-right">${results.data.categories[index].balanceAmount - results.data.categories[index].costAmount}  /=</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default">Action</button>
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu pull-right" role="menu">

                                                    <li><a href="javascript:void(0)" onclick="categoryEditModal('${results.data.categories[index].id}')"><i class="fa fa-fw fa-pencil-square-o"></i> Edit</a></li>

                                                    <li class="divider"></li>
                                                    <li>
                                                        <a onclick="deleteconfirm('${results.data.categories[index].id}')" href="javascript:void(0)"><i class="fa fa-fw fa-trash-o"></i> Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>`
                        }
                        $('#categoryBody').html(html);
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        window.onload = function(){
            searchCategoryPage()
        }


    </script>
@endpush

