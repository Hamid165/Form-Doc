@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <div class="mb-6">
        <a href="{{ route('form-secure-operation.index') }}" class="flex items-center text-sm text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Formulir Secure Operation
        </a>
    </div>

    <!-- Panggil form universal -->
    @include('form-secure-operation.form', [
        'action' => route('form-secure-operation.store'),
        'method' => 'POST',
        'form' => new \App\Models\FormSecureOperation\SecureOperationIncident()
    ])
</div>
@endsection