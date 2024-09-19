@extends('layouts.tabler')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">
                            {{ __('Order Details') }}
                        </h3>
                    </div>
                    <div class="card-actions btn-actions">
                        @if ($order->order_status === \App\Enums\OrderStatus::PENDING)
                            <div class="dropdown">{{-- hellow --}}
                                <a href="#" class="btn-action dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"><!-- Download SVG icon from http://tabler-icons.io/i/dots-vertical -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                        <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                        <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    </svg>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <form action="{{ route('orders.update', $order->uuid) }}" method="POST">
                                        @csrf
                                        @method('put')

                                        <button type="submit" class="dropdown-item text-success"
                                            onclick="return confirm('Are you sure you want to approve this order?')">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-check" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 12l5 5l10 -10" />
                                            </svg>

                                            {{ __('Approve Order') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <x-action.close route="{{ route('orders.index') }}" />
                    </div>
                </div>

                <div class="card-body">
                    <div class="row row-cards mb-3">

                        @include('partials.session')
                        <div class="col">
                            <label for="order_date" class="form-label required">
                                {{ __('Order Date') }}
                            </label>
                            <input type="text" id="order_date" class="form-control"
                                value="{{ $order->order_date->format('d-m-Y') }}" disabled>
                        </div>

                        <div class="col">
                            <label for="invoice_no" class="form-label required">
                                {{ __('Invoice No.') }}
                            </label>
                            <input type="text" id="invoice_no" class="form-control" value="{{ $order->invoice_no }}"
                                disabled>
                        </div>

                        <div class="col">
                            <label for="customer" class="form-label required">
                                {{ __('Customer') }}
                            </label>
                            <input type="text" id="customer" class="form-control" value="{{ $order->customer->name }}"
                                disabled>
                        </div>

                        <div class="col">
                            <label for="payment_type" class="form-label required">
                                {{ __('Payment Type') }}
                            </label>
                            <select class="form-control" id="payment_type" name="payment_type" required>
                                <option value="Cash" {{ $order->payment_type === 'Cash' ? 'selected' : '' }}>
                                    Cash</option>
                                <option value="Bank" {{ $order->payment_type === 'Bank' ? 'selected' : '' }}>Bank
                                    Transfer
                                </option>
                                <option value="Credit" {{ $order->payment_type === 'Credit' ? 'selected' : '' }}>Credit
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        @livewire('OrderproductDetail', ['order' => $order])

                    </div>
                </div>

                <div class="card-footer d-flex">
                    @if ($order->order_status === \App\Enums\OrderStatus::PENDING)
                        <div class="col">
                            <form action="{{ route('orders.update', $order->uuid) }}" method="POST">
                                @method('put')
                                @csrf

                                <button type="submit" class="btn btn-success"
                                    onclick="return confirm('Are you sure you want to complete this order?')">
                                    {{ __('Complete Order') }}
                                </button>
                            </form>
                        </div>
                    @endif
                    <div class="col  text-end">
                        <form action="{{ route('orders.update_payment_status', $order->uuid) }}" method="POST">
                            @method('put')
                            @csrf
                            <!-- Hidden Input Field to Store Payment Type -->
                            <input type="hidden" id="hidden_payment_type" name="hidden_payment_type"
                                value="{{ $order->payment_type }}">
                            <!-- Hidden Input Field to Store Payment Type -->
                            <input type="hidden" id="hidden_notes" name="hidden_notes" value="">
                            <button type="submit" class="btn btn-success"
                                onclick="return confirm('Are you sure you want to change the payemnt type of this order?')">
                                {{ __('Change Payment Status') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the select dropdown and hidden input field
            const paymentTypeSelect = document.getElementById('payment_type');
            const notesSelect = document.getElementById('notesSelect');
            const hiddenPaymentType = document.getElementById('hidden_payment_type');
            const hidden_notes = document.getElementById('hidden_notes');

            // Add an event listener for changes in the select dropdown
            paymentTypeSelect.addEventListener('change', function() {
                // Update the hidden field with the selected value
                hiddenPaymentType.value = paymentTypeSelect.value;
                hidden_notes.value = notesSelect.value;
            });
        });
    </script>
@endsection
