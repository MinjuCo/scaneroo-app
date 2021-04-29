@extends('layouts.app')

@section('content')

    <div id="scaneroo" v-cloak>
        <div class="container-fluid">
            <router-view></router-view>
        </div>
    </div>
    <script src="{{ asset(mix('js/app.js')) }}"></script>

@endsection