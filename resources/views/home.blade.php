@extends('layouts.app')

@section('content')

    @guest
        You must login to use LaraChatty v0.1
    @else
        <home-component :conversations="{{ $conversations }}" :authuser="{{ auth()->user() }}"></home-component>
    @endguest
              
@endsection
