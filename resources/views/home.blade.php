@extends('layouts.app')

@section('content')
    <noscript>
      <strong>We're sorry but Scaneroo doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>
    <div id="scaneroo" v-cloak>
        <div class="container-fluid">
            <router-view></router-view>
        </div>
    </div>
    <script src="{{ asset(mix('js/app.js')) }}"></script>

@endsection