<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">
                {{ __('Products') }}
            </h3>
        </div>

        @if (auth()->user()->role === 'admin')
            <div class="card-actions">
                <x-action.create route="{{ route('products.create') }}" />
            </div>
        @endif
    </div>

    <div class="card-body border-bottom py-3">
        <div class="d-flex">
            <div class="text-secondary">
                Show
                <div class="mx-2 d-inline-block">
                    <select wire:model.live="perPage" class="form-select form-select-sm" aria-label="result per page">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                    </select>
                </div>
                entries
            </div>
            <div class="ms-auto text-secondary">
                Search:
                <div class="ms-2 d-inline-block">
                    <input type="text" wire:model.live="search" class="form-control form-control-sm"
                        aria-label="Search invoice">
                </div>
            </div>
        </div>
    </div>

    <x-spinner.loading-spinner />

    <div class="table-responsive">
        <table wire:loading.remove class="table table-bordered card-table table-vcenter text-nowrap datatable">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle text-center w-1">
                        {{ __('No.') }}
                    </th>
                    <th scope="col" class="align-middle text-center">
                        {{ __('Image') }}
                    </th>
                    <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('products.name')" href="#" role="button">
                            {{ __('Name') }}
                            @include('inclues._sort-icon', ['field' => 'products.name'])
                        </a>
                    </th>

                    <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('products.cost_price')" href="#" role="button">
                            {{ __('Cost Price') }}
                            @include('inclues._sort-icon', ['field' => 'products.cost_price'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('products.sale_price')" href="#" role="button">
                            {{ __('Sale Price') }}
                            @include('inclues._sort-icon', ['field' => 'products.sale_price'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('products.sale_price')" href="#" role="button">
                            {{ __('Whole Sale Price') }}
                            @include('inclues._sort-icon', ['field' => 'products.sale_price'])
                        </a>
                    </th>

                    @if (auth()->user()->role === 'admin')
                        <th scope="col" class="align-middle text-center">
                            {{ __('Action') }}
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td class="align-middle text-center">
                            {{ $loop->iteration }}
                        </td>
                        <td class="align-middle text-center">
                            <img style="width: 90px;"
                                src="{{ $product->product_image ? asset('storage/' . $product->product_image) : asset('assets/img/products/default.webp') }}"
                                alt="">
                        </td>
                        <td class="align-middle text-center">
                            {{ $product->name }}
                        </td>

                        <td class="align-middle text-center">
                            {{ $product->cost_price }}
                        </td>
                        <td class="align-middle text-center">
                            {{ $product->sale_price }}
                        </td>
                        <td class="align-middle text-center">
                            {{ $product->whole_sale_price }}
                        </td>
                        @if (auth()->user()->role === 'admin')
                            <td class="align-middle text-center" style="width: 10%">
                                <x-button.show class="btn-icon" route="{{ route('products.show', $product->uuid) }}" />
                                <x-button.edit class="btn-icon" route="{{ route('products.edit', $product->uuid) }}" />
                                <x-button.delete class="btn-icon"
                                    route="{{ route('products.destroy', $product->uuid) }}"
                                    onclick="return confirm('Are you sure to delete product {{ $product->name }} ?')" />
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td class="align-middle text-center" colspan="37">No results found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            {{-- Showing <span>{{ $products->firstItem() }}</span> --}}
            {{-- to <span>{{ $products->lastItem() }}</span> of <span>{{ $products->total() }}</span> entries --}}
        </p>

        <ul class="pagination m-0 ms-auto">
            {{-- {{ $products->links() }} --}}
        </ul>
    </div>
</div>
