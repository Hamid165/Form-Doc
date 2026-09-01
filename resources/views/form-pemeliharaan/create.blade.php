@extends('layouts.app')

@section('title', 'Buat Formulir Pemeliharaan')

@section('back_button')
<a href="{{ route('form-pemeliharaan.index') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors text-gray-500 hover:text-gray-700 shrink-0">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
</a>
@endsection

@section('content')
    @include('form-pemeliharaan.form', ['isEdit' => false])
@endsection
