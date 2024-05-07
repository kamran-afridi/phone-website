<div class="card mb-4 mb-xl-0">
    <div class="card-header">
        List Product
        <div class="ms-auto text-secondary">
            Search:
            <div class="ms-2 d-inline-block">
                <input type="text" wire:model.live="search" class="form-control form-control-sm"
                    aria-label="Search invoice">
            </div>
        </div>
    </div>


    <div class="card-body">
        <div class="col-lg-12">
            <x-spinner.loading-spinner />
            <div class="table-responsive">
                <table wire:loading.remove class="table table-striped table-bordered align-middle">
                    <thead class="thead-light">
                        <tr>
                            {{-- - <th scope="col">No.</th> - --}}
                            <th scope="col">Name</th>
                            <th scope="col">Quantity</th>
                            {{-- <th scope="col">Unit</th> --}}
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                {{-- -
						<td>
							<div style="max-height: 80px; max-width: 80px;">
								<img class="img-fluid"  src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/img/products/default.webp') }}">
							</div>
						</td>
						- --}}
                                <td class="text-center">
                                    {{ $product->name }}
                                </td>
                                <td class="text-center">
                                    {{ $product->quantity }}
                                </td>
                                {{-- <td class="text-center">
							{{ $product->unit->name }}
						</td> --}}
                                <td class="text-center">
                                    {{ number_format($product->price, 2) }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <form action="{{ route('pos.addCartItem', $product) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <input type="hidden" name="name" value="{{ $product->name }}">
                                            <input type="hidden" name="sale_price" value="{{ $product->price }}">

                                            <button type="submit" class="btn btn-icon btn-outline-primary">
                                                <x-icon.cart />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="6" class="text-center">
                                    Data not found!
                                </th>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
