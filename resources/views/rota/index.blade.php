@extends('layouts.tabler')

@section('content')
<div class="page-body">
    @if(!$rota)
        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'superAdmin')
            <x-empty
                title="No Rota found"
                message="Try adjusting your search or filter to find what you're looking for."
                button_label="{{ __('Add your first Rota') }}"
                button_route="{{ route('rota.create') }}"
            />
        @elseif (auth()->user()->role == 'user')
            <div class="d-flex justify-content-center align-items-center">
                <h4>No record found!</h4>
            </div>
        @endif
    @else
        <div class="container-xl">

            {{---
            <div class="card">
                <div class="card-body">
                    <livewire:power-grid.customers-table/>
                </div>
            </div>
            ---}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <h3 class="mb-1">Success</h3>
                    <p>{{ session('success') }}</p>

                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif
            @livewire('rota-table')
            {{-- @livewire('livewire.rota-table') --}}
        </div>
    @endif
</div>
@endsection
