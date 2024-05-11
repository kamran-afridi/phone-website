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
                                        <button type="button" class="btn btn-icon btn-outline-warning ms-2"
                                            data-bs-toggle="modal" data-bs-target="#editModal">
                                            <x-icon.pencil />
                                        </button>
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
    <div class="modal modal-lg" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">
                                        {{ __('Customer Image') }}
                                    </h3>

                                    <img class="img-account-profile rounded-circle mb-2"
                                        src="{{ asset('assets/img/demo/user-placeholder.svg') }}" alt=""
                                        id="image-preview" />

                                    <div class="small font-italic text-muted mb-2">JPG
                                        or PNG no larger than 2 MB</div>

                                    <input class="form-control @error('photo') is-invalid @enderror" type="file"
                                        id="image" name="photo" accept="image/*" onchange="previewImage();">

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
                                            <x-input name="email" label="Email address" :required="true" />
                                            <x-input name="shop_name" label="Shop Name" :required="true" />
                                            <x-input label="Phone Number" name="phone" type='tel'
                                                :required="true" />
                                            {{-- <input type="tel" pattern="[0-9]{11}" placeholder="Enter UK phone number"
												required> --}}
                                        </div>

                                        <div class="mb-3">
                                            <label for="address" class="form-label required">
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
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button class="btn btn-primary" type="submit">
                                        {{ __('Save') }}
                                    </button>

                                    <a class="btn btn-outline-warning" href="{{ route('customers.index') }}">
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
