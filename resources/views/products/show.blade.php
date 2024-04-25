@extends('layouts.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center mb-3">
                <div class="col">
                    <h2 class="page-title">
                        {{ $product->name }}
                    </h2>
                </div>
            </div>

            @include('partials._breadcrumbs')
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">
                                    {{ __('Product Image') }}
                                </h3>

                                <img style="width: 90px;" id="image-preview"
                                    src="{{ $product->product_image ? asset('storage/' . $product->product_image) : asset('assets/img/products/default.webp') }}"
                                    alt="" class="img-account-profile mb-2">
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    Product Code
                                </div>
                                <div class="row row-cards">
                                    <div class="col-md-6">
                                        <label class="small mb-1">
                                            Product code
                                        </label>

                                        <div class="form-control">
                                            {{ $product->code }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 align-middle">
                                        <label class="small mb-1">
                                            Barcode
                                        </label>

                                        <div class="mt-1">
                                            {!! $barcode !!} 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}


                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    {{ __('Product Details') }}
                                </h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered card-table table-vcenter text-nowrap datatable">
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>{{ $product->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td>{{ $product->product_description }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-secondary">Manufacturer</span></td>
                                            <td>{{ $product->manufacturer }}</td>
                                        </tr>
                                        <tr>
                                            <td>Device</td>
                                            <td>{{ $product->device }}</td>
                                        </tr>
                                        <tr>
                                            <td>SKU</td>
                                            <td>{{ $product->sku }}</td>
                                        </tr>
                                        <tr>
                                            <td>UPC Code</td>
                                            <td>{{ $product->upc_code }}</td>
                                        </tr>
                                        <tr>
                                            <td>Is barcode</td>
                                            <td>{{ $product->is_barcode }}</td>
                                        </tr>
                                        <tr>
                                            <td>Valuation method</td>
                                            <td>{{ $product->valuation_method }}</td>
                                        </tr>
                                        <tr>
                                            <td>New stock adjustment</td>
                                            <td>{{ $product->new_stock_adjustment }}</td>
                                        </tr>
                                        <tr>
                                            <td>New inventory item cost</td>
                                            <td>{{ $product->new_inventory_item_cost }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tax inclusive</td>
                                            <td>{{ $product->tax_inclusive }}</td>
                                        </tr>
                                        <tr>
                                            <td>Retail price</td>
                                            <td>{{ $product->retail_price }}</td>
                                        </tr>
                                        <tr>
                                            <td>Cost price</td>
                                            <td>{{ $product->cost_price }}</td>
                                        </tr>
                                        <tr>
                                            <td>Sale price</td>
                                            <td>{{ $product->sale_price }}</td>
                                        </tr>
                                        <tr>
                                            <td>Minimum price</td>
                                            <td>{{ $product->minimum_price }}</td>
                                        </tr>
                                        <tr>
                                            <td>On hand quantity</td>
                                            <td>{{ $product->on_hand_quantity }}</td>
                                        </tr>
                                        <tr>
                                            <td>Stock warning</td>
                                            <td>{{ $product->stock_warning }}</td>
                                        </tr>
                                        <tr>
                                            <td>Re order level</td>
                                            <td>{{ $product->re_order_level }}</td>
                                        </tr>
                                        <tr>
                                            <td>Manage serialized</td>
                                            <td>{{ $product->manage_serialized }}</td>
                                        </tr>
                                        <tr>
                                            <td>Condition</td>
                                            <td>{{ $product->condition }}</td>
                                        </tr>
                                        <tr>
                                            <td>Supplier</td>
                                            <td>{{ $product->supplier }}</td>
                                        </tr>
                                        <tr>
                                            <td>Physical location</td>
                                            <td>{{ $product->physical_location }}</td>
                                        </tr>
                                        <tr>
                                            <td>Warranty</td>
                                            <td>{{ $product->warranty }}</td>
                                        </tr>
                                        <tr>
                                            <td>Warranty time frame</td>
                                            <td>{{ $product->warranty_time_frame }}</td>
                                        </tr>
                                        <tr>
                                            <td>IMEI</td>
                                            <td>{{ $product->imei }}</td>
                                        </tr>
                                        <tr>
                                            <td>Display on point of sale</td>
                                            <td>{{ $product->display_on_point_of_sale }}</td>
                                        </tr>
                                        <tr>
                                            <td>Display on widget</td>
                                            <td>{{ $product->display_on_widget }}</td>
                                        </tr>
                                        <tr>
                                            <td>Comission percentage</td>
                                            <td>{{ $product->comission_percentage }}</td>
                                        </tr>
                                        <tr>
                                            <td>Comission amount</td>
                                            <td>{{ $product->comission_amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer text-end">
                                <a class="btn btn-info" href="{{ url()->previous() }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l14 0" />
                                        <path d="M5 12l6 6" />
                                        <path d="M5 12l6 -6" />
                                    </svg>
                                    {{ __('Back') }}
                                </a>
                                <a class="btn btn-warning" href="{{ route('products.edit', $product->uuid) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                        <path d="M13.5 6.5l4 4" />
                                    </svg>
                                    {{ __('Edit') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
