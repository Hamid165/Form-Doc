@extends('layouts.app')
@section('content')
@include('form-ba-it-services.form', [
    'action' => '#',
    'mode' => 'show',
    'baItService' => $baItService
])
@endsection