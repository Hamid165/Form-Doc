@extends('layouts.app')

@section('title','Edit Form Permohonan Pemusnahan Aset')

@section('content')
    @include('form-pemusnahan.form',[
        'isEdit'=>true,
        'form_pemusnahan'=>$form_pemusnahan,
        'dataPemohons'=>$dataPemohons ?? collect(),
        'dataAsets'=>$dataAsets ?? collect()
    ])
@endsection
