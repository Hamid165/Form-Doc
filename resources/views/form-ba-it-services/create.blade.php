@extends('layouts.app')
@section('content')
@include('form-ba-it-services.form', [
    'action' => route('ba-it.store'),
    'baItService' => new \App\Models\FormBaItServices\BaItService()
])
@endsection