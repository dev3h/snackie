@extends('admin_layout')
@section('admin_content')
    @push('chart_css')
        <link rel="stylesheet" href="{{ asset('backend/css/chart.css') }}" />
        <link rel="stylesheet" href="{{ asset('backend/css/chartColumn.css') }}" />
    @endpush
    <div>
        <div class="row">
            @foreach ($statistics as $key => $value)
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="card">
                        <h5 class="card-header">{{ $value['title'] }}</h5>
                        <div class="card-body">
                            <h5 class="card-title">{{ $value['count'] }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                @include('pages.admin.dashboard.chart')
            </div>
            <div class="col-sm-12 col-lg-6">
                @include('pages.admin.dashboard.chart_column')
            </div>
        </div>
    </div>
    @push('chart_js')
        <script src="{{ asset('backend/js/highcharts.js') }}"></script>
        <script src="{{ asset('backend/js/series-label.js') }}"></script>
        <script src="{{ asset('backend/js/exporting.js') }}"></script>
        <script src="{{ asset('backend/js/export-data.js') }}"></script>
        <script src="{{ asset('backend/js/accessibility.js') }}"></script>
        <script src="{{ asset('backend/js/data.js') }}"></script>
        <script src="{{ asset('backend/js/drilldown.js') }}"></script>
    @endpush
@endsection
