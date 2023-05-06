@extends("layouts.app")
@section("content")
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-1 mr-5">{{ __('labels.member_management') }}</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('members.index') }}" class="text-muted">{{ __('labels.members') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="" class="text-muted">{{ __('labels.profile') }}</a>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->

                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">{{ __('labels.member_profile') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table  display responsive  table-head-custom dataTable no-footer" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>{{ __('labels.name') }}</th>
                                    <th>{{ __('labels.email') }}</th>
                                    <th>{{ __('labels.phone') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->phone }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <section>
                            <caption>{{ __('labels.member_stats') }}</caption>
                            <table class="table  display responsive  table-head-custom dataTable no-footer" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Number of wins</th>
                                        <th>Number of losses</th>
                                        <th>Average score</th>
                                        <th>Highest score</th>
                                        <th>Highest score Date</th>
                                        <th>Scored against</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $stats['wins'] }}</td>
                                        <td>{{ $stats['losses'] }}</td>
                                        <td>{{ round($stats['averageScore']) }}</td>
                                        <td>{{ $stats['highest_score'] }}</td>
                                        <td>{{ $stats['date']?date('d/m/Y',strtotime($stats['date'])):'' }}</td>
                                        <td>{{ $stats['opponent'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
