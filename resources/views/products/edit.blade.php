@extends('layouts.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center mb-3">
                <div class="col">
                    <h2 class="page-title">
                        {{ __('Edit Product') }}
                    </h2>
                </div>
            </div>

            @include('partials._breadcrumbs', ['model' => $product])
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">

                <form action="{{ route('products.update', $product->uuid) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">
                                        {{ __('Product Image') }}
                                    </h3>

                                    <img class="img-account-profile mb-2"
                                        src="{{ $product->product_image ? asset('storage/' . $product->product_image) : asset('assets/img/products/default.webp') }}"
                                        alt="" id="image-preview">

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
                                <div class="card-body">
                                    <h3 class="card-title">
                                        {{ __('Product Details') }}
                                    </h3>

                                    <div class="row row-cards">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">
                                                    {{ __('Name') }}
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text" id="name" name="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    placeholder="Product name" value="{{ old('name', $product->name) }}">

                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- @livewire('tables.subcategory-select-component', ['product' => $product]) --}}
                                        @livewire('tables.subcategory-component', ['product' => $product])



                                        <div class="col-md-12 mb-3">
                                            <label for="description" class="form-label">
                                                {{ __('Decription') }}
                                            </label>

                                            <textarea name="description" id="description" rows="5" class="form-control" placeholder="Description...">{{ old('product_description', $product->product_description) }}</textarea>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Manufacturer" name="manufacturer" id="manufacturer"
                                                value="{{ old('manufacturer', $product->manufacturer) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Device" name="device" id="device"
                                                value="{{ old('device', $product->device) }}" />
                                        </div>
                                        {{-- 
                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="SKU" name="sku" id="sku"
                                                value="{{ old('sku', $product->sku) }}" />
                                        </div> --}}

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="UPC Code" name="upc_code" id="upc_code"
                                                value="{{ old('upc_code', $product->upc_code) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6 mb-3">
                                            <label for="bar_code" class="form-label">
                                                Is Barcode
                                            </label>
                                            <select name="bar_code" id="bar_code" class="form-select">
                                                <option value="true" {{ $product->is_barcode === 1 ? 'selected' : '' }}>
                                                    Yes
                                                </option>
                                                <option value="false" {{ $product->is_barcode === 0 ? 'selected' : '' }}>
                                                    No
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Valuation method" name="valuation_method" id="valuation_method"
                                                value="{{ old('valuation_method', $product->valuation_method) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="New Stock Adjustment" name="new_stock_adjustment"
                                                id="new_stock_adjustment"
                                                value="{{ old('new_stock_adjustment', $product->new_stock_adjustment) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="New Inventory Item Cost"
                                                name="new_inventory_item_cost" id="new_inventory_item_cost" placeholder="0"
                                                value="{{ old('new_inventory_item_cost', $product->new_inventory_item_cost) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Tax Class" name="tax_class" id="tax_class"
                                                value="{{ old('tax_class', $product->tax_class) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Tax inclusive" name="tax_inclusive" id="tax_inclusive"
                                                value="{{ old('tax_inclusive', $product->tax_inclusive) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Retail price" name="retail_price"
                                                id="retail_price" placeholder="0"
                                                value="{{ old('retail_price', $product->retail_price) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Cost price" name="cost_price" id="cost_price"
                                                placeholder="0" value="{{ old('cost_price', $product->cost_price) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Sale price" name="sale_price" id="sale_price"
                                                placeholder="0" value="{{ old('sale_price', $product->sale_price) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Minimum price" name="minimum_price"
                                                id="minimum_price" placeholder="0"
                                                value="{{ old('minimum_price', $product->minimum_price) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="On hand quantity" name="on_hand_quantity"
                                                id="on_hand_quantity" placeholder="0"
                                                value="{{ old('on_hand_quantity', $product->on_hand_quantity) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Stock warning" name="stock_warning"
                                                id="stock_warning" placeholder="0"
                                                value="{{ old('stock_warning', $product->stock_warning) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Reorder level" name="reorder_level"
                                                id="reorder_level" placeholder="0"
                                                value="{{ old('reorder_level', $product->re_order_level) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Manage serialized" name="manage_serialized"
                                                id="manage_serialized"
                                                value="{{ old('manage_serialized', $product->manage_serialized) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Condition" name="condition" id="condition"
                                                value="{{ old('condition', $product->condition) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Supplier" name="supplier" id="supplier"
                                                value="{{ old('supplier', $product->supplier) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Physical location" name="physical_location"
                                                id="physical_location" placeholder="0"
                                                value="{{ old('physical_location', $product->physical_location) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Warranty" name="warranty" id="warranty"
                                                placeholder="0" value="{{ old('warranty', $product->warranty) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input label="Warranty time frame" name="warranty_time_frame"
                                                id="warranty_time_frame"
                                                value="{{ old('warranty_time_frame', $product->warranty_time_frame) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="IMEI" name="imei" id="imei"
                                                placeholder="0" value="{{ old('imei', $product->imei) }}" />
                                        </div>


                                        <div class="col-sm-6 col-md-6 mb-3">
                                            <label for="display_pos" class="form-label">
                                                Display on point of sale
                                            </label>
                                            <select name="display_pos" id="display_pos" class="form-select">
                                                <option value="true"
                                                    {{ $product->display_on_point_of_sale ? 'selected' : '' }}>
                                                    Yes</option>
                                                <option value="false"
                                                    {{ $product->display_on_point_of_sale ? '' : 'selected' }}>
                                                    No</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 col-md-6 mb-3">
                                            <label for="display_widget" class="form-label">
                                                Display on widget
                                            </label>
                                            <select name="display_widget" id="display_widget" class="form-select">
                                                <option value="true"
                                                    {{ $product->display_on_widget ? 'selected' : '' }}>
                                                    Yes
                                                </option>
                                                <option value="false"{{ $product->display_on_widget ? '' : 'selected' }}>
                                                    No</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Commision percentage"
                                                name="comission_percentage" id="comission_percentage" placeholder="0"
                                                value="{{ old('comission_percentage', $product->comission_percentage) }}" />
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <x-input type="number" label="Comission Amount" name="comission_amount"
                                                id="comission_amount" placeholder="0"
                                                value="{{ old('comission_amount', $product->comission_amount) }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-end">
                                    <button class="btn btn-primary" type="submit">
                                        {{ __('Update') }}
                                    </button>

                                    <a class="btn btn-danger" href="{{ url()->previous() }}">
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
