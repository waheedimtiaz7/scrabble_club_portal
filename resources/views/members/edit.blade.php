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
                        <h5 class="text-dark font-weight-bold my-1 mr-5">{{ __('labels.member_management') }}</h5>
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('members.index') }}" class="text-muted">{{ __('labels.members') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="" class="text-muted">{{ __('labels.edit') }}</a>
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
                                <h3 class="card-title">{{ __('labels.update_member') }}</h3>
                            </div>
                            <form id="add_category_form" action="{{ route('members.update',['member'=>$member->id]) }}" method="post">
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label for="name">{{ __('labels.name') }}:</label>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                                   placeholder="{{ __('labels.name') }}" value="{{ $member->name }}" />

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="name">{{ __('labels.email') }}:</label>
                                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                                   value="{{ $member->email }}" />

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label for="banner">{{ __('labels.phone') }}</label>
                                            <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                                   placeholder="{{ __('labels.phone') }}" value="{{ $member->phone }}" />

                                            @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="joining_date">{{ __('labels.joining_date') }}</label>
                                            <input type="date" name="joining_date" id="joining_date" class="form-control @error('joining_date') is-invalid @enderror"
                                                   placeholder="{{ __('labels.joining_date') }}" value="{{ $member->joining_date }}" />

                                            @error('joining_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-6"></div>
                                        <div class="col-lg-8">
                                            <button type="submit" id="add_user_btn" class="btn btn-primary mr-2">{{ __('labels.submit') }}</button>
                                            <a href="{{ route('members.index') }}" class="btn btn-light-primary font-weight-bold">{{ __('labels.back') }}</a>
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
