@extends('layouts.app')

@section('title', 'Edit Formulir Monitoring Grounding')

@section('content')

@include('form-monitoring-grounding.form', [
    'action' => route('form-monitoring-grounding.update', $form->id),
    'method' => 'PUT'
])

@endsection
