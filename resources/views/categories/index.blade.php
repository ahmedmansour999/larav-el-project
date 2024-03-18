<x-guest-layout>
    <div class="container w-full px-5 py-6 mx-auto">
        <h1 class=" fw-bold fs-1 text-dark text-uppercase " style="color: #eee" >Categories</h1>
        <div class="grid lg:grid-cols-4 gap-y-6">
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
            @foreach ($categories as $category)
                <div class="max-w-xs mx-2 mb-2 rounded-lg shadow-lg">
                    <img width="100%" style="max-height:150px " src="{{ asset('images/'.$category->image) }}" alt="menu Logo" width="100">

                    <div class="px-6 py-4">

                        <a href="{{ route('categories.show', $category->id) }}">
                            <h4
                                class="mb-3 text-xl font-semibold tracking-tight text-green-600 hover:text-green-400 uppercase">
                                {{ $category->name }}</h4>
                        </a>
                        <hr>
                        <a href="{{ route('categories.show', $category->id) }}">
                            <span class="fw-bold text-red-600" style="max-height:100px ; min-height:80px" >Description</span>
                            <p
                                class=" ">
                                {{ $category->description }}</p>
                        </a>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
    <div class="d-flex justify-center  ">
        {{$categories->links()}}
    </div>
</x-guest-layout>
