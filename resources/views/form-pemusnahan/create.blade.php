@extends('layouts.app')

@section('title','Tambah Form Permohonan Pemusnahan Aset')

@section('content')
    @include('form-pemusnahan.form',[
        'isEdit'=>false,
        'form_pemusnahan'=>null,
        'dataPemohons'=>$dataPemohons ?? collect(),
        'dataAsets'=>$dataAsets ?? collect()
    ])
@endsection
