@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-alert />

            <div class="row row-cards">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">
                                        {{ __('Product Image') }}
                                    </h3>

                                    <img class="img-account-profile mb-2"
                                        src="{{ asset('assets/img/products/default.webp') }}" alt=""
                                        id="image-preview" />

                                    <div class="small font-italic text-muted mb-2">
                                        JPG or PNG no larger than 2 MB
                                    </div>

                                    <input type="file" accept="image/*" id="image" name="product_image"
                                        class="form-control @error('product_image') is-invalid @enderror"
                                        onchange="previewImage();">

                                    @error('product_image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <div>
                                        <h3 class="card-title">
                                            {{ __('Product Create') }}
                                        </h3>
                                    </div>

                                    <div class="card-actions">
                                        <a href="{{ route('products.index') }}" class="btn-action">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M18 6l-12 12"></path>
                                                <path d="M6 6l12 12"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row row-cards">
                                        <div class="col-md-12">
                                            <x-input name="name" id="name" value="{{ old('name') }}" />
                                        </div>
                                        {{-- @livewire('tables.subcategory-select-component', ['product' => $product]) --}}
                                        @livewire('tables.subcategory-component', ['product' => $product])

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Price" name="price" id="price" type="number"
                                                value="{{ old('price') }}" />
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Quantity" name="quantity" id="quantity"
                                                value="{{ old('quantity') }}" />
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="description" class="form-label">
                                                {{ __('Decription') }}
                                            </label>

                                            <textarea name="description" id="description" rows="5" class="form-control" placeholder="Description...">{{ old('description') }}</textarea>
                                        </div>

                                        {{-- <div class="col-sm-6 col-md-6">
                                            <x-input label="Manufacturer" name="manufacturer" id="manufacturer"
                                                value="{{ old('manufacturer') }}" />
                                        </div> --}}

                                        {{-- <div class="col-sm-6 col-md-6">
                                            <label for="device" class="form-label">
                                                Device
                                            </label>
                                            <select name="device" id="device" class="form-select">
                                                @foreach ($devices as $device)
                                                    <option value="{{ $device->id }}">{{ $device->name }}</option>
                                                @endforeach
                                            </select>
                                            <a href="{{ route('devices.create') }}" class="btn btn-primary btn-sm mt-2">Add
                                                a device</a>
                                        </div> --}}

                                        {{-- <div class="col-sm-6 col-md-6">
                                            <x-input label="SKU" name="sku" id="sku"
                                                value="{{ old('sku') }}" />
                                        </div> --}}

                                        {{-- <div class="col-sm-6 col-md-6">
                                            <x-input label="UPC Code" name="upc_code" id="upc_code"
                                                value="{{ old('upc_code') }}" />
                                        </div> --}}

                                        {{-- <div class="col-sm-6 col-md-6 mb-3">
                                            <label for="bar_code" class="form-label">
                                                Is Barcode
                                            </label>
                                            <select name="bar_code" id="bar_code" class="form-select">
                                                <option value="true">Yes</option>
                                                <option value="false">No</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Valuation method" name="valuation_method" id="valuation_method"
                                                value="{{ old('valuation_method') }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="New Stock Adjustment" name="new_stock_adjustment"
                                                id="new_stock_adjustment" value="{{ old('new_stock_adjustment') }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="New Inventory Item Cost"
                                                name="new_inventory_item_cost" id="new_inventory_item_cost" placeholder="0"
                                                value="{{ old('new_inventory_item_cost') }}" />
                                        </div> --}}

                                        {{-- <div class="col-sm-6 col-md-6">
                                            <x-input label="Tax Class" name="tax_class" id="tax_class"
                                                value="{{ old('tax_class') }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Tax inclusive" name="tax_inclusive" id="tax_inclusive"
                                                value="{{ old('tax_inclusive') }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Retail price" name="retail_price"
                                                id="retail_price" placeholder="0" value="{{ old('retail_price') }}" />
                                        </div> --}}

                                        {{-- <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Cost price" name="cost_price" id="cost_price"
                                                placeholder="0" value="{{ old('cost_price') }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Sale price" name="sale_price" id="sale_price"
                                                placeholder="0" value="{{ old('sale_price') }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Minimum price" name="minimum_price"
                                                id="minimum_price" placeholder="0" value="{{ old('minimum_price') }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="On hand quantity" name="on_hand_quantity"
                                                id="on_hand_quantity" placeholder="0"
                                                value="{{ old('on_hand_quantity') }}" />
                                        </div> --}}

                                        {{-- <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Stock warning" name="stock_warning"
                                                id="stock_warning" placeholder="0" value="{{ old('stock_warning') }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Reorder level" name="reorder_level"
                                                id="reorder_level" placeholder="0" value="{{ old('reorder_level') }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Manage serialized" name="manage_serialized"
                                                id="manage_serialized" value="{{ old('manage_serialized') }}" />
                                        </div> --}}

                                        {{-- <div class="col-sm-6 col-md-6">
                                            <x-input label="Condition" name="condition" id="condition"
                                                value="{{ old('condition') }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Supplier" name="supplier" id="supplier"
                                                value="{{ old('supplier') }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Physical location" name="physical_location"
                                                id="physical_location" placeholder="0"
                                                value="{{ old('physical_location') }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Warranty" name="warranty" id="warranty"
                                                placeholder="0" value="{{ old('warranty') }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Warranty time frame" name="warranty_time_frame"
                                                id="warranty_time_frame" value="{{ old('warranty_time_frame') }}" />
                                        </div> --}}

                                        {{-- <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="IMEI" name="imei" id="imei"
                                                placeholder="0" value="{{ old('imei') }}" />
                                        </div>


                                        <div class="col-sm-6 col-md-6 mb-3">
                                            <label for="display_pos" class="form-label">
                                                Display on point of sale
                                            </label>
                                            <select name="display_pos" id="display_pos" class="form-select">
                                                <option value="true">Yes</option>
                                                <option value="false">No</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 col-md-6 mb-3">
                                            <label for="display_widget" class="form-label">
                                                Display on widget
                                            </label>
                                            <select name="display_widget" id="display_widget" class="form-select">
                                                <option value="true">Yes
                                                </option>
                                                <option value="false">No</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Commision percentage"
                                                name="comission_percentage" id="comission_percentage" placeholder="0"
                                                value="{{ old('comission_percentage') }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Comission Amount" name="comission_amount"
                                                id="comission_amount" placeholder="0"
                                                value="{{ old('comission_amount') }}" />
                                        </div> --}}
                                    </div>
                                </div>

                                <div class="card-footer text-end">
                                    <x-button.save type="submit">
                                        {{ __('Save') }}
                                    </x-button.save>

                                    <a class="btn btn-warning" href="{{ url()->previous() }}">
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
@endsection

@pushonce('page-scripts')
    <script src="{{ asset('assets/js/img-preview.js') }}"></script>
@endpushonce
