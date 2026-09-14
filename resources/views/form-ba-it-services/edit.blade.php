@extends('layouts.app')
@section('content')
@include('form-ba-it-services.form', [
    'action' => route('ba-it.update', $baItService->id),
    'method' => 'PUT',
    'baItService' => $baItService
])
@endsection