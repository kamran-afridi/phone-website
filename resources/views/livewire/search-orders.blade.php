<div class="card mb-4 mb-xl-0">
    <div class="card-header d-flex justify-content-between">
        <div class="card-header-title">

            Search Product
        </div>
        <div class="card-header-actions">

            <button type="button" class="btn btn-sm  btn-primary"
                data-bs-toggle="modal" data-bs-target="#addManulProduct">
                Add Manual Product
            </button>
        </div>

    </div>

    <style>
        .abctable {
            max-height: 253px;
            overflow-x: auto;
            overflow-y: scroll;
        }

        .abctable::-webkit-scrollbar {
            width: 6px;
        }

        .abctable::-webkit-scrollbar-thumb {
            background-color: #636363;
            border-radius: 20px;
        }

        .abctable::-webkit-scrollbar-thumb {
            background-color: #636363;
            border-radius: 10px;
        }

        .abctable::-webkit-scrollbar-thumb:hover {
            background-color: #888888;
        }

        .abctable {
            scrollbar-width: thin;
            scrollbar-color: #636363 #ecf0f1;
        }

        .searchproducts {
            max-height: 253px;
            overflow-x: auto;
            overflow-y: scroll;
            background-color: #f1f1f1;
            border-radius: 5px;
            padding: 5px;
        }

        .searchproductcard:hover {
            background-color: #f0f0f0;
        }
    </style>
    <div class="card-body">
        <div class="col-lg-12">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
            @endif

            <div class="col-md-12 my-2 text-secondary">
                <input type="text" wire:model.live="search" class="form-control"
                    aria-label="Search product" placeholder="Search product">
            </div>
            <x-spinner.loading-spinner />
            <div class="col-md-12 searchproducts">
                @php
                // if (Session::get('customer_id')){
                // dd(Session::get('customer_id'));
                // }
                @endphp
                @forelse ($products as $product)
                <div class="card searchproductcard m-2 p-0 cursor-pointer"
                    wire:click="addCartItem({{ $product->id }}, '{{ $product->name }}', {{ Session::get('customer_id') === \App\Enums\CustomerType::Normal ? $product->sale_price : $product->whole_sale_price }}, '{{ $product->sku }}')"
                    style="cursor: pointer;">
                    <div class="card-body">
                        <p class="text-center">
                            <b>{{ $product->sku }}</b> {{ $product->name }} &nbsp;&nbsp;
                            @if (Session::get('customer_id') === \App\Enums\CustomerType::Normal)
                            <b>£{{ number_format($product->sale_price, 2) }}</b>
                            @else
                            <b>£{{ number_format($product->whole_sale_price, 2) }}</b>
                            @endif
                        </p>
                    </div>
                </div>
                @empty
                <p class="text-center my-2">No products found.</p>
                @endforelse
            </div>


            {{-- when enter to select  --}}
            {{-- <div class="col-md-12 my-2 text-secondary" x-data="{
                selectFirst() {
                    @this.call('addCartItem',
                        {{ $products->first()?->id ?? 'null' }}, '{{ $products->first()?->name ?? '' }}' ,
            {{ Session::get('customer_id') === \App\Enums\CustomerType::Normal ? $products->first()?->sale_price ?? 0 : $products->first()?->whole_sale_price ?? 0 }}, '{{ $products->first()?->sku ?? '' }}'
            );
            }
            }">
            <input type="text" wire:model.live="search" class="form-control" aria-label="Search product"
                placeholder="Search product" @keydown.enter.prevent="selectFirst()">
        </div>

        <div class="col-md-12 searchproducts">
            @forelse ($products as $product)
            <div class="card searchproductcard m-2 p-0 cursor-pointer"
                wire:click="addCartItem({{ $product->id }}, '{{ $product->name }}', {{ Session::get('customer_id') === \App\Enums\CustomerType::Normal ? $product->sale_price : $product->whole_sale_price }}, '{{ $product->sku }}')"
                style="cursor: pointer;">
                <div class="card-body">
                    <p class="text-center">
                        <b>{{ $product->sku }}</b> {{ $product->name }} &nbsp;&nbsp;
                        @if (Session::get('customer_id') === \App\Enums\CustomerType::Normal)
                        <b>£{{ number_format($product->sale_price, 2) }}</b>
                        @else
                        <b>£{{ number_format($product->whole_sale_price, 2) }}</b>
                        @endif
                    </p>
                </div>
            </div>
            @empty
            <p class="text-center my-2">No products found.</p>
            @endforelse
        </div> --}}

        <!-- The modal -->
        <div class="modal modal-lg" id="addManulProduct">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('manual.product.creation') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">
                                            {{ __('Product Details') }}
                                        </h3>
                                        <button type="button" class="close btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true"></span>
                                        </button>

                                        <div class="card-body">
                                            <div class="row row-cards">
                                                <div class="col-md-6">
                                                    <x-input name="name" id="name" value="{{ old('name') }}" />
                                                </div>
                                                <div class="col-6">
                                                    <x-input label="Whole Sale Price" name="whole_sale_price" id="whole_sale_price"
                                                        type="number" value="{{ old('whole_sale_price') }}" />
                                                </div>
                                                <div class="col-12 mt-1">
                                                    <x-input label="Quantity" name="quantity" id="quantity" type="number"
                                                        value="{{ old('quantity') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit">
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>