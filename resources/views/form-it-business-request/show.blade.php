@extends('layouts.app')

@section('title', 'Detail Formulir IT Business Request')

@section('content')

<!-- We can reuse the form.blade.php but make it readonly -->
@include('form-it-business-request.form', [
    'action' => '#',
    'method' => 'GET',
    'form' => $form,
    'formTemplate' => $formTemplate
])

<style>
    /* Prevent interaction and hide submit buttons for show view */
    .a4-container input, 
    .a4-container textarea, 
    .a4-container select {
        pointer-events: none;
        background-color: transparent !important;
        border-color: transparent !important;
    }
    .btn-submit {
        display: none !important;
    }
    .btn-kembali {
        background-color: #3b82f6; /* blue-500 instead of red for 'Kembali' */
    }
    .btn-kembali:hover {
        background-color: #2563eb;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Change text of Batal to Kembali
        const backBtn = document.querySelector('.btn-kembali');
        if(backBtn) {
            backBtn.textContent = 'Kembali';
        }
    });
</script>
@endsection
