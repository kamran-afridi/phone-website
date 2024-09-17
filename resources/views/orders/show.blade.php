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
                            <div class="dropdown">
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
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="align-middle text-center">No.</th>
                                    <th scope="col" class="align-middle text-center">Photo</th>
                                    <th scope="col" class="align-middle text-center">SKU</th>
                                    <th scope="col" class="align-middle text-center">Product Name</th>
                                    <th scope="col" class="align-middle text-center">Quantity</th>
                                    <th scope="col" class="align-middle text-center">Price</th>
                                    <th scope="col" class="align-middle text-center">Sub Total</th>
                                    <th scope="col" class="align-middle text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->details as $item)
                                    <tr>
                                        <td class="align-middle text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="align-middle text-center">
                                            <div style="max-height: 80px; max-width: 80px;">
                                                <img class="img-fluid"
                                                    src="{{ $item->product->product_image ? asset('storage/' . $item->product->product_image) : asset('assets/img/products/default.webp') }}">
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ $item->product->sku }}
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ $item->product->name }}
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ number_format($item->unitcost, 2) }}
                                            {{-- {{ number_format($item->product->sale_price, 2) }} --}}
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ number_format($item->total, 2) }}
                                        </td>
                                        <td class="align-middle text-center">

                                            @if (auth()->user()->role == 'admin')
                                                @if ($order->details->count() > 1)
                                                    <form action="{{ route('orders.deleteitems', $item->id) }}"
                                                        class="d-inline-block" method="POST">
                                                        @method('delete')
                                                        @csrf
                                                        <input name="Product_id" value="{{ $item->product->id }}"
                                                            type="hidden" />
                                                        <input name="uuid" value="{{ $order->uuid }}"
                                                            type="hidden" />
                                                        <input name="order_id" value="{{ $order->id }}"
                                                            type="hidden" />

                                                        <button type="submit" class="btn btn-icon btn-outline-danger "
                                                            onclick="return confirm('Are you sure you want to delete this record?')">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-trash" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('orders.cancel', $order) }}"
                                                        class="d-inline-block" method="POST">
                                                        @method('delete')
                                                        @csrf
                                                        <input name="Product_id" value="{{ $item->product->id }}"
                                                            type="hidden" />
                                                        <input name="uuid" value="{{ $order->uuid }}"
                                                            type="hidden" />
                                                        <input name="order_id" value="{{ $order->id }}"
                                                            type="hidden" />
                                                        <button type="submit" class="btn btn-icon btn-outline-danger "
                                                            onclick="return confirm('Please delete this order from the main order page')">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-trash" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                                <button type="button"
                                                    class="btn btn-primary btn btn-outline-warning btn-icon"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="{{ '#' . $item->product->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-pencil" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4">
                                                        </path>
                                                        <path d="M13.5 6.5l4 4"></path>
                                                    </svg>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- The modal -->
                                    <div class="modal modal-lg" id="{{ $item->product->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('orders.edit_submited_order', $item->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('put')
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h3 class="card-title">
                                                                        {{ __('Product Details') }}
                                                                    </h3>
                                                                    <button type="button" class="close btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true"></span>
                                                                    </button>

                                                                    <div class="row row-cards">
                                                                        <div class="col-md-12">
                                                                            <input name="Product_id"
                                                                                value="{{ $item->product->id }}"
                                                                                type="hidden" />
                                                                            <input name="uuid"
                                                                                value="{{ $order->uuid }}"
                                                                                type="hidden" />
                                                                            <input name="order_id"
                                                                                value="{{ $order->id }}"
                                                                                type="hidden" />
                                                                            <x-input name="SKU" label="SKU"
                                                                                value='{{ $item->product->sku }}'
                                                                                :required="true" :disabled="true" />
                                                                            <x-input name="product_name"
                                                                                label="product_name"
                                                                                value='{{ $item->product->name }}'
                                                                                :required="true" :disabled="true" />
                                                                            <x-input name="quantity" label="QUANTITY"
                                                                                value='{{ $item->quantity }}'
                                                                                :required="true" />
                                                                            <x-input name="unitcost" label="unitcost"
                                                                                value='{{ $item->unitcost }}'
                                                                                :required="true" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer text-end">

                                                                    <a class="btn btn-danger" href="#"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        Cancel
                                                                    </a>
                                                                    <button class="btn btn-primary" type="submit">
                                                                        {{ __('Upadte') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <tr>
                                    <td colspan="7" class="text-end">
                                        Payed amount
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('orders.update_order_payment', $order->uuid) }}"
                                            method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="input-group" style="min-width: 170px;">
                                                <input type="number" class="form-control" name="pay" required
                                                    value="{{ $order->pay }}" step="any">
                                                <input type="hidden" class="form-control" name="order_id"
                                                    value="{{ $order->id }}">

                                                <div class="input-group-append text-center">
                                                    <button type="submit" class="btn btn-icon btn-success border-none"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="Sumbit">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-check" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M5 12l5 5l10 -10" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-end">Due</td>
                                    <td class="text-center">{{ number_format($order->due, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-end">VAT</td>
                                    <td class="text-center">{{ number_format($order->vat, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-end">Total</td>
                                    <td class="text-center">{{ number_format($order->total, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-end">Status</td>
                                    <td class="text-center">
                                        <x-status dot
                                            color="{{ $order->order_status === \App\Enums\OrderStatus::COMPLETE ? 'green' : ($order->order_status === \App\Enums\OrderStatus::PENDING ? 'orange' : '') }}"
                                            class="text-uppercase">
                                            {{ $order->order_status->label() }}
                                        </x-status>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">Note:</td>
                                    <td colspan="7" class="text-center">
                                        <textarea name="note" id="notesSelect" rows="3" class="form-control form-control-solid"
                                            spellcheck="false">{{ old('note', $order->note) }}</textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
