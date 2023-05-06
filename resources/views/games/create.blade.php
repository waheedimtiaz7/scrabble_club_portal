@extends("layouts.app")
@section("content")
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content" xmlns="http://www.w3.org/1999/html">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-1 mr-5">Games Management</h5>
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('games.index') }}" class="text-muted">Games</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="" class="text-muted">Add</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-custom gutter-b example example-compact">
                            <div class="card-header">
                                <h3 class="card-title">Add Game</h3>
                            </div>
                            <form id="add_category_form" action="{{ route('games.store') }}" method="post">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label for="date">Date:</label>
                                            <input type="date" name="date" id="date" class="form-control" placeholder="Date">
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="game_duration_in_minutes">Duration In minutes:</label>
                                            <input type="number" name="game_duration_in_minutes" id="game_duration_in_minutes"
                                                   class="form-control" value="Game duration in minutes">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label for="member_id">Members</label>
                                            <select name="member_id[]" class="form-control" id="member_id">
                                                @foreach($members as $member)
                                                    <option {{ in_array($member->id, $selected_members)?'selected':"" }} value="{{ $member->id }}">
                                                        {{ $member->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-6"></div>
                                        <div class="col-lg-8">
                                            <button type="submit" id="add_user_btn" class="btn btn-primary mr-2">Submit</button>
                                            <a href="{{ route('games.index') }}" class="btn btn-light-primary font-weight-bold">Back</a>
                                        </div>
                                    </div>
                                </div>
                                @csrf
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Card-->
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset("assets/js/pages/crud/validations/games.js") }}"></script>
    <script>
        $('#member_id').select2();
    </script>
@endpush
