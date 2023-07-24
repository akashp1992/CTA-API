@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container py-8">
            @include('home.partials.statistics')
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            //
        });
    </script>
@stop

