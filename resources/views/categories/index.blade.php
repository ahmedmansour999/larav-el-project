<x-guest-layout>
    <div class="container w-full px-5 py-6 mx-auto">
        <div class="grid lg:grid-cols-4 gap-y-6">
            @foreach ($categories as $category)
                <div class="max-w-xs mx-2 mb-2 rounded-lg shadow-lg">
                    <img width="100%" style="max-height:180px " src="{{ asset('images/'.$category->image) }}" alt="menu Logo" width="100">

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
