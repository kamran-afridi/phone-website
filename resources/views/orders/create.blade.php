@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 class="card-title">
                                    {{ __('New Order') }}
                                </h3>
                            </div>
                            <div class="card-actions btn-actions">
                                <x-action.close route="{{ route('orders.index') }}" />
                            </div>
                        </div>
                        <form action="{{ route('invoice.create') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row gx-3 mb-3">
                                    @include('partials.session')
                                    <div class="col-md-4">
                                        <label for="purchase_date" class="small my-1">
                                            {{ __('Date') }}
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input name="purchase_date" id="purchase_date" type="date"
                                            class="form-control example-date-input @error('purchase_date') is-invalid @enderror"
                                            value="{{ old('purchase_date') ?? now()->format('Y-m-d') }}" required>

                                        @error('purchase_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="small mb-1" for="customer_id">
                                            {{ __('Customer') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <button type="button" class="btn btn-sm mb-1 btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#myModal">
                                            Add customer
                                        </button>

                                        <select
                                            class="form-select form-control-solid @error('customer_id') is-invalid @enderror"
                                            id="customer_id" name="customer_id">
                                            <option selected="" disabled="">
                                                Select a customer:
                                            </option>

                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('customer_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <!-- The modal -->
                                        <div class="modal modal-lg" id="myModal">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('customers.store') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <h3 class="card-title">
                                                                            {{ __('Customer Image') }}
                                                                        </h3>

                                                                        <img class="img-account-profile rounded-circle mb-2"
                                                                            src="{{ asset('assets/img/demo/user-placeholder.svg') }}"
                                                                            alt="" id="image-preview" />

                                                                        <div class="small font-italic text-muted mb-2">JPG
                                                                            or PNG no larger than 2 MB</div>

                                                                        <input
                                                                            class="form-control @error('photo') is-invalid @enderror"
                                                                            type="file" id="image" name="photo"
                                                                            accept="image/*" onchange="previewImage();">

                                                                        @error('photo')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-8">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <h3 class="card-title">
                                                                            {{ __('Customer Details') }}
                                                                        </h3>

                                                                        <div class="row row-cards">
                                                                            <div class="col-md-12">
                                                                                <x-input name="name" :required="true" />
                                                                                <x-input name="email"
                                                                                    label="Email address"
                                                                                    :required="true" />
                                                                                <x-input name="shop_name" label="Shop Name"
                                                                                    :required="true" />
                                                                                <x-input label="Phone Number" name="phone"
                                                                                    type='tel' :required="true" />
                                                                                {{-- <input type="tel" pattern="[0-9]{11}" placeholder="Enter UK phone number"
																					required> --}}
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="address"
                                                                                    class="form-label required">
                                                                                    Address
                                                                                </label>

                                                                                <textarea name="address" id="address" rows="3"
                                                                                    class="form-control form-control-solid @error('address') is-invalid @enderror">{{ old('address') }}</textarea>

                                                                                @error('address')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}
                                                                                    </div>
                                                                                @enderror
                                                                            </div>


                                                                            {{-- <div class="col-sm-6 col-md-6">
																			<label for="bank_name" class="form-label">
																				Bank Name
																			</label>
									
																			<select class="form-select form-control-solid @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name">
																				<option selected="" disabled="">Select a bank:</option>
																				<option value="BRI" @if (old('bank_name') == 'BRI')selected="selected"@endif>BRI</option>
																				<option value="BNI" @if (old('bank_name') == 'BNI')selected="selected"@endif>BNI</option>
																				<option value="BCA" @if (old('bank_name') == 'BCA')selected="selected"@endif>BCA</option>
																				<option value="BSI" @if (old('bank_name') == 'BSI')selected="selected"@endif>BSI</option>
																				<option value="Mandiri" @if (old('bank_name') == 'Mandiri')selected="selected"@endif>Mandiri</option>
																			</select>
									
																			@error('bank_name')
																			<div class="invalid-feedback">
																				{{ $message }}
																			</div>
																			@enderror
																		</div> --}}


                                                                            {{-- <div class="col-sm-6 col-md-6">
																			<x-input label="Account holder" name="account_holder" />
																		</div>
									
																		<div class="col-sm-6 col-md-6">
																			<x-input label="Account number" name="account_number" />
																		</div> --}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-footer text-end">
                                                                        <button class="btn btn-primary" type="submit">
                                                                            {{ __('Save') }}
                                                                        </button>

                                                                        <a class="btn btn-outline-warning"
                                                                            href="{{ route('customers.index') }}">
                                                                            {{ __('Cancel') }}
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <label class="small mb-1" for="reference">
                                            {{ __('Reference') }}
                                        </label>

                                        <input type="text" class="form-control" id="reference" name="reference"
                                            value="ORD" readonly>

                                        @error('reference')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">{{ __('Product') }}</th>
                                                <th scope="col" class="text-center">{{ __('Quantity') }}</th>
                                                <th scope="col" class="text-center">{{ __('Price') }}</th>
                                                <th scope="col" class="text-center">{{ __('SubTotal') }}</th>
                                                <th scope="col" class="text-center">
                                                    {{ __('Action') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($carts as $item)
                                                <tr>
                                                    <td>
                                                        {{ $item->name }}
                                                    </td>
                                                    <td style="min-width: 170px;">
                                                        <form></form>
                                                        <form action="{{ route('pos.updateCartItem', $item->rowId) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" name="qty"
                                                                    required value="{{ old('qty', $item->qty) }}">
                                                                <input type="hidden" class="form-control"
                                                                    name="product_id" value="{{ $item->id }}">

                                                                <div class="input-group-append text-center">
                                                                    <button type="submit"
                                                                        class="btn btn-icon btn-success border-none"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="" data-original-title="Sumbit">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="icon icon-tabler icon-tabler-check"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" stroke-width="2"
                                                                            stroke="currentColor" fill="none"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                                fill="none" />
                                                                            <path d="M5 12l5 5l10 -10" />
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $item->price }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $item->subtotal }}
                                                    </td>
                                                    <td class="text-center">
                                                        <form action="{{ route('pos.deleteCartItem', $item->rowId) }}"
                                                            method="POST">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-icon btn-outline-danger "
                                                                onclick="return confirm('Are you sure you want to delete this record?')">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-trash"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M4 7l16 0" />
                                                                    <path d="M10 11l0 6" />
                                                                    <path d="M14 11l0 6" />
                                                                    <path
                                                                        d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <td colspan="5" class="text-center">
                                                    {{ __('Add Products') }}
                                                </td>
                                            @endforelse

                                            <tr>
                                                <td colspan="4" class="text-end">
                                                    Total Product
                                                </td>
                                                <td class="text-center">
                                                    {{ Cart::count() }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end">Subtotal</td>
                                                <td class="text-center">
                                                    {{ Cart::subtotal() }}
                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <td colspan="4" class="text-end">Tax</td>
                                                <td class="text-center">
                                                    {{ Cart::tax() }}
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <td colspan="4" class="text-end">Total</td>
                                                <td class="text-center">
                                                    {{ Cart::total() }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="card-footer text-end">
                                <button type="submit"
                                    class="btn btn-success add-list mx-1 {{ Cart::count() > 0 ? '' : 'disabled' }}">
                                    {{ __('Create Invoice') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="col-lg-5">
                    @livewire('search-orders', ['products' => $products])
                </div>

            </div>
        </div>
    </div>
@endsection

@pushonce('page-scripts')
    <script src="{{ asset('assets/js/img-preview.js') }}"></script>
@endpushonce
