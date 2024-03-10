<x-guest-layout>
    @if (count($menus) > 0)
        <!-- Order Form -->
        <form action="{{ route('order.store') }}" method="POST">
            @csrf
            @method('post')

            <!-- Display Selected Items -->
            <div class="container w-full px-5 py-6 mx-auto">
                <div class="grid lg:grid-cols-4 gap-y-6">
                    @php
                        $totalPrice = 0;
                    @endphp
                    @foreach ($menus as $menu)
                        <!-- Menu Card -->
                        <div class="max-w-xs mx-1 mt-2 rounded-lg shadow-lg d-flex justify-content-between flex-column">
                            <!-- Menu Information -->
                            <div class="img" style="position: relative;">
                                <img class="w-full h-48" src="{{ asset('images/'.$menu->image) }}" alt="Image"/>
                                @if ($menu->state == 0)
                                    <span class="bg-danger p-1 px-2 fw-bold text-white"
                                          style="position: absolute; top: 0; right:0">
                                        Pending
                                    </span>
                                @endif
                            </div>
                            <div class="px-6">
                                <h4 class="text-xl font-semibold tracking-tight text-green-600 uppercase">
                                    {{ $menu->name }}</h4>
                                <p class="leading-normal text-gray-700">{{ $menu->description }}.</p>
                            </div>
                            <!-- Item Price and Controls -->
                            @if ($menu->state == 0)
                                <div class="flex items-center justify-between px-4 py-1">
                                    <span class="text-xl text-green-600">${{ $menu->price * $menu->count }}</span>
                                    <p class="text-xl text-green-600">
                                        <a href="{{ route('menus.destroy', $menu->id) }}" class="btn btn-danger">Remove</a>
                                    </p>
                                </div>
                                <div class="W-100 d-flex mb-1 justify-content-around">
                                    <a class="btn btn-primary border border-0"
                                       href="{{ route('menus.increase', [$menu['id'], $menu['count']]) }}"><i
                                                class="fas fa-plus"></i></a>
                                    <p>{{$menu->count}}</p>
                                    <a class="btn btn-danger border border-0"
                                       href="{{ route('menus.decrease', [$menu['id'], $menu['count']]) }}"> <i
                                                class="fas fa-minus"></i> </a>
                                </div>
                                @php
                                    $totalPrice += $menu->price * $menu->count;
                                @endphp
                            @else
                                <div class="accepted bg-primary text-center p-3 fw-bold text-white">
                                    <i class="fas fa-clock"></i>  Being processed
                                </div>
                            @endif
                            <!-- Hidden Input for Selected Items -->
                            <input type="hidden" name="menus[]" value="{{ $menu->id }}">
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Hidden Input for Total Price -->
            <input type="hidden" name="total" value="{{ $totalPrice }}">
            <!-- Submit Button -->
            <div class="flex justify-center mt-4">
                <button type="button" class="btn bg-primary text-white fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Place Order
                </button>
            </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        @method('post')
                        <div class="mb-3">
                            <label for="orderTitle" class="form-label fw-bold">Order Name</label>
                            <input type="text" class="form-control" id="orderTitle" name="title" placeholder="Enter Order Title" required>
                        </div>
                        <div class="mb-3">
                            <label for="orderhint" class="form-label fw-bold">Order Note</label>
                            <input type="text" class="form-control" id="orderhint" name="notes" placeholder="Enter Hint " required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-danger  text-white fw-bold " data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-primary text-white fw-bold  ">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
        </form>
    @else
        <div class="alert alert-primary">There are no items in the cart.</div>
    @endif
</x-guest-layout>
