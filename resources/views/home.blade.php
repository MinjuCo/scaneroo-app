@extends('layouts.app')

@section('content')
    <noscript>
      <strong>We're sorry but Scaneroo doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>
    <div id="scaneroo" v-cloak>
        <div class="container-fluid p-0">
            <router-view></router-view>
        </div>
    </div>
    <script>
        window.default_locale = "{{ App::currentLocale() }}";
        window.fallback_locale = "{{ config('app.fallback_locale') }}";
        window.google_clientId = "{{ config('services.google.client_id') }}";
        window.google_redirect = "{{ config('services.google.redirect') }}";
        window.authenticated = "{{ Auth::check() }}";
    </script>
    <script src="{{ asset(mix('js/app.js')) }}"></script>

@endsection