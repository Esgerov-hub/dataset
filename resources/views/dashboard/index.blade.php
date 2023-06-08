@extends('dashboard.layouts.app')
@section('dashboard.title')
    Index
@endsection
@section('dashboard.css')
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
@endsection
@section('dashboard.content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">DataSet</h4>
                    </div>
                </div>
            </div>
            @if (Session::get('errors'))
                <div class="col-12 mt-1">
                    <div class="alert alert-danger" role="alert">
                        <div class="alert-body">{{ Session::get('errors') }}</div>
                    </div>
                </div>
            @endif
            @if (Session::get('messages'))
                <div class="col-12 mt-1">
                    <div class="alert alert-success" role="alert">
                        <div class="alert-body">{{ Session::get('messages') }}</div>
                    </div>
                </div>
            @endif
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body border-bottom">
                            <div class="col-xxl-2 col-lg-4">
                                <a href="{{ route('dashboard.export') }}" class="btn btn-soft-secondary w-100"><i class="mdi mdi-download align-middle"></i> Export</a>
                            </div>
                        </div>
                        <div class="card-body border-bottom">
                            <form action="{{ route('dashboard.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-xxl-4 col-lg-6">
                                        <input type="file" class="form-control " name="file" id="fileInput" value="{{ old('file') }}" >
                                    </div>
                                    <div class="col-xxl-2 col-lg-4">
                                        <button type="submit" class="btn btn-soft-secondary w-100"><i class="mdi mdi-content-save align-middle"></i> Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!--end card-->
                </div><!--end col-->

            </div><!--end row-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body border-bottom">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 card-title flex-grow-1">Lists</h5>
                            </div>
                        </div>
                        <div class="card-body border-bottom">
                            <form action="" method="get" enctype="multipart/form-data">
                                <div class="row g-3">
                                    <div class="col-xxl-4 col-lg-6">
                                        <input type="search" name="search" class="form-control" id="searchInput" placeholder="Search" value="{{ old('search') }}">
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <input type="date" name="start_date" class="form-control" id="searchInput" placeholder="Search" value="{{ old('start_date') }}">
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <input type="date" name="end_date" class="form-control" id="searchInput" placeholder="Search" value="{{ old('end_date') }}">
                                    </div>
                                    <div class="col-xxl-2 col-lg-4">
                                        <button type="submit" class="btn btn-soft-secondary w-100"><i class="mdi mdi-search-web align-middle"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered align-middle nowrap">
                                    <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Firstname</th>
                                        <th scope="col">Lastname</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Birtday</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($users) && $users != null)
                                        @foreach($users as $i => $user)
                                            <tr>
                                        <th scope="row">{{ ++$i }}</th>
                                        <td>{!! $user->category !!}</td>
                                        <td>{!! $user->firstname !!}</td>
                                        <td>{!! $user->lastname !!}</td>
                                        <td>{!! $user->email !!}</td>
                                        <td>{!! $user->gender !!}</td>
                                        <td>{!! $user->birthday !!}</td>
                                    </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            {{$users->links()}}
{{--                            <div class="row justify-content-between align-items-center">--}}

{{--                                <div class="col-auto">--}}
{{--                                    <div class="card d-inline-block ms-auto mb-0">--}}
{{--                                        <div class="card-body p-2">--}}
{{--                                            <nav aria-label="Page navigation example" class="mb-0">--}}

{{--                                                <ul class="pagination mb-0">--}}
{{--                                                    <li class="page-item">--}}
{{--                                                        <a class="page-link" href="javascript:void(0);" aria-label="Previous">--}}
{{--                                                            <span aria-hidden="true">&laquo;</span>--}}
{{--                                                        </a>--}}
{{--                                                    </li>--}}
{{--                                                    <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>--}}
{{--                                                    <li class="page-item active"><a class="page-link" href="javascript:void(0);">2</a></li>--}}
{{--                                                    <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>--}}
{{--                                                    <li class="page-item"><a class="page-link" href="javascript:void(0);">...</a></li>--}}
{{--                                                    <li class="page-item"><a class="page-link" href="javascript:void(0);">12</a></li>--}}
{{--                                                    <li class="page-item">--}}
{{--                                                        <a class="page-link" href="javascript:void(0);" aria-label="Next">--}}
{{--                                                            <span aria-hidden="true">&raquo;</span>--}}
{{--                                                        </a>--}}
{{--                                                    </li>--}}
{{--                                                </ul>--}}
{{--                                            </nav>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <!--end col-->--}}
{{--                            </div>--}}
                            <!--end row-->
                        </div>
                    </div><!--end card-->
                </div><!--end col-->

            </div><!--end row-->


        </div> <!-- container-fluid -->
    </div>
@endsection
@section('dashboard.js')
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/job-list.init.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
