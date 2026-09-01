@extends('layouts.app')

@section('title', 'Buat Formulir Monitoring Grounding')

@section('content')

@include('form-monitoring-grounding.form', [
    'action' => route('form-monitoring-grounding.store'),
    'method' => 'POST'
])

@endsection
