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
                            <th scope="col">Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="text-center">
                                    {{ $product->name }}
                                </td>
                                <td class="text-center">
                                    {{ $product->quantity }}
                                </td>
                                <td class="text-center">
                                    {{ number_format($product->cost_price, 2) }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <form action="{{ route('pos.addCartItem', $product) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <input type="hidden" name="name" value="{{ $product->name }}">
                                            <input type="hidden" name="sale_price" value="{{ $product->cost_price }}">

                                            <button type="submit" class="btn btn-icon btn-outline-primary">
                                                <x-icon.cart />
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-icon btn-outline-warning ms-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="{{ '#' . $product->name . $product->id }}">
                                            <x-icon.pencil />
                                        </button>
                                    </div>
                                </td>
                                <div class="modal modal-lg" id="{{ $product->name . $product->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            @livewire('product-modal', ['product' => $product])
                                        </div>
                                    </div>
                                </div>
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
