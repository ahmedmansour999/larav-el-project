<div>
    @if (session()->has('danger'))
        <div class="alert alert-danger m-5" role="alert">
            {{ session()->get('danger') }}
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success m-5" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif
    @if (session()->has('warning'))
        <div class="alert alert-warning m-5" role="alert">
            {{ session()->get('warning') }}
        </div>
    @endif
</div>



<x-guest-layout>
    <div class="container mx-auto py-6">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Welcome Message -->
            <div class="p-6 bg-gray-100 border-b bg-warning">
                <h2 class="text-2xl font-semibold  text-gray-800">Welcome, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-600">Here are your Orders:</p>
            </div>

            <div class="divide-y divide-gray-200">
                @foreach ($orders as $order)
                    @php
                        $totalPrice = 0;
                    @endphp
                    <div class="p-6 flex flex-col">
                        <form action="{{ route('order.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="bg-gray-100 rounded-lg shadow-md overflow-hidden">

                                <div class="px-6 py-4">
                                    <div class="d-flex flex-row justify-content-between align-items-center">
                                        <h1 class="text-gray-600  fw-bold fs-2 text-capitalize ">Order: {{ $order->title }}

                                            @if ($order->status == 0 )
                                                <span class="bg-warning p-2 fs-6 text-white" > Pending </span>
                                            @elseif($order->status == 1)

                                                <span class="bg-success p-2 fs-6 text-white" > Accepted </span>

                                            @elseif($order->status == 2)

                                                <span class="bg-danger p-2 fs-6 text-white" > canceled </span>

                                            @endif
                                        </h1>
                                        <p class="text-gray-600 text-sm">{{ $order->created_at }}</p>
                                    </div>
                                    <p class="text-gray-600 text-sm">Customer: {{ $order->title }}</p>
                                    @if ($order->notes)
                                        <p class="text-gray-600 text-sm">Hint: {{ $order->notes }}</p>
                                    @else
                                        <p class="text-gray-600 text-sm">Hint: Not Found</p>
                                    @endif
                                    <div class="container w-full px-5  mx-auto">
                                        <p class="text-xl d-flex justify-content-end">
                                            <button type="submit" class="btn bg-warning text-black fw-bold">Update</button>
                                        </p>
                                        <div class="grid lg:grid-cols-4 gap-y-6">
                                            @foreach ($order->menus as $menu)
                                                <div class="max-w-xs mx-1 mb-2 rounded-lg shadow-lg d-flex justify-content-between flex-column">
                                                    <!-- Menu Information -->
                                                    <div class="img" style="position: relative;">
                                                        <img class="w-full h-48" src="{{ asset('images/' . $menu->image) }}" alt="Image" />
                                                        @if ($menu->state == 0)
                                                            <span class="bg-danger p-1 px-2 fw-bold text-white" style="position: absolute; top: 0; right:0">
                                                                Pending
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="px-6">
                                                        <h4 class="text-xl font-semibold tracking-tight text-green-600 uppercase">{{ $menu->name }}</h4>
                                                        <p class="leading-normal text-gray-700 uppercase">{{ $menu->description }}.</p>
                                                    </div>
                                                    <!-- Item Price and Controls -->
                                                    @if ($menu->state == 0)
                                                        <div class="flex items-center justify-between px-4 py-1">
                                                            <span class="text-xl text-green-600">${{ $menu->price * $menu->count }}</span>
                                                            @if($order->status == 0)
                                                                <p class="text-xl text-green-600">
                                                                    <a href="{{ route('menus.destroy', $menu->id) }}" class="btn btn-danger">Remove</a>
                                                                </p>
                                                            @endif

                                                        </div>
                                                        @if($order->status == 0)
                                                            <div class="W-100 d-flex mb-1 justify-content-around">
                                                                <a class="btn btn-primary border border-0" href="{{ route('menus.increase', [$menu['id'], $menu['count']]) }}"><i class="fas fa-plus"></i></a>
                                                                <p>{{ $menu->count }}</p>
                                                                <a class="btn btn-danger border border-0" href="{{ route('menus.decrease', [$menu['id'], $menu['count']]) }}"><i class="fas fa-minus"></i></a>
                                                            </div>
                                                        @else
                                                        <div class="W-100 d-flex mb-1 justify-content-around">
                                                        <p  >Item Count = {{ $menu->count }}</p>
                                                        </div>
                                                        @endif

                                                    @else
                                                        <div class="accepted bg-primary text-center p-3 fw-bold text-white">
                                                            <i class="fas fa-clock"></i>  processed
                                                        </div>
                                                    @endif
                                                    <!-- Hidden Input for Selected Items -->
                                                    <input type="hidden" name="menus[]" value="{{ $menu->id }}">
                                                    <input type="hidden" name="menus[{{ $menu->id }}][count]" value="{{ $menu->count }}">
                                                    <div class="flex items-center justify-between p-4">
                                                        <span class="text-xl text-green-600">${{ $menu->price }}</span>
                                                    </div>
                                                </div>
                                                @php
                                                    $totalPrice += $menu->price * $menu->count;
                                                @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 justify-end">
                                        <input type="hidden" name="total" value="{{ $totalPrice }}">
                                        <p class="text-gray-600 text-lg fw-bold  bg-success p-2 text-white ">Total Price = ${{ $totalPrice }} Eg</p>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <div class="px-6 py-4 bg-gray-200 flex justify-end">
                            <form action="/session" method="POST" class="mx-2">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type='hidden' name="total" value="6">
                                <input type='hidden' name="productname" value="Asus Vivobook 17 Laptop - Intel Core 10th">
                                <button class="btn btn-warning bg-warning text-black fw-bold" type="submit" id="checkout-live-button"><i class="fa fa-money"></i> Checkout</button>
                            </form>
                            <!-- Cancel order Button -->
                            <form action="{{ route('order.destroy', $order->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Cancel Order</button>
                            </form>

                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-guest-layout>
