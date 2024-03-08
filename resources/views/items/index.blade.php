<x-guest-layout>
    <h1 class="text-center FS-1 mt-5 ">{{ $user['name'] }}</h1>
    <div class="container w-full px-5 py-6 mx-auto">
        <div class="payment">
            <div>
                @php
                $totalPrice = 0;
            @endphp

                @foreach ($menus as $menu)
                    @php
                        $subtotal = $menu->price * $menu->count;
                        $totalPrice += $subtotal;
                    @endphp


                @endforeach

                <p class="bg-warning p-2 float-end">Total Price: ${{ $totalPrice }}</p>
            </div>
            <form action="/session" method="POST">
                <a href="{{ url('/') }}" class="btn btn-danger"> <i class="fa fa-arrow-left"></i> Continue Shopping</a>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type='hidden' name="total" value="6">
                <input type='hidden' name="productname" value="Asus Vivobook 17 Laptop - Intel Core 10th">
                <button class="btn btn-success" type="submit" id="checkout-live-button"><i class="fa fa-money"></i> Checkout</button>
       </form>
        </div>
        <div class="grid lg:grid-cols-4 gap-y-6">
            @foreach ($menus as $menu)
                <div class="max-w-xs mx-4 mb-2 rounded-lg shadow-lg">
                    <img class="w-full h-48" src="{{ asset('images/'.$menu->image) }}" alt="Image" />
                    <div class="px-6 py-4">
                        <h4 class="mb-3 text-xl font-semibold tracking-tight text-green-600 uppercase">
                            {{ $menu->name }}</h4>
                        <p class="leading-normal text-gray-700">{{ $menu->description }}.</p>
                    </div>
                    <div class="flex items-center justify-between p-4">
                        <span class="text-xl text-green-600">${{ $menu->price * $menu->count }}</span>
                        <p class="text-xl text-green-600" ><a href="{{ route('menus.destroy' , $menu->id ) }}" class=" btn btn-danger">Remove</a></p>
                    </div>
                    <div class="W-100 d-flex my-2 justify-content-around">
                        <a class="btn btn-primary  border border-0 "  href="{{ route( 'menus.increase' , [$menu['id'] , $menu['count'] ]) }}"><i class="fas fa-plus"></i></a>
                        <p>{{$menu->count}}</p>
                        <a class="btn btn-danger   border border-0 " href="{{ route( 'menus.decrease' , [$menu['id'] , $menu['count'] ]) }}"> <i class="fas fa-minus"></i> </a>
                    </div>
                </div>
                @endforeach
            </div>


    </div>
</x-guest-layout>

