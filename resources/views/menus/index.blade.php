<x-guest-layout>
    @if(session('message'))
    <script>
        $(function() {
            $('#messageModal').modal('show');
        });
    </script>
@endif
<!-- Modal -->
<div class="modal" tabindex="-1" role="dialog" id="messageModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="modal-message">{{ session('message') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <div class="container w-full px-5 py-6 mx-auto">
        <div class="grid lg:grid-cols-4 gap-y-6">
            @foreach ($menus as $menu)
                <div class="max-w-xs mx-1 mb-2 rounded-lg shadow-lg d-flex justify-content-between flex-column">
                    <img class="w-full h-48" src="{{ asset('images/'.$menu->image) }}" alt="Image" />
                    <div class="px-6 py-4">
                        <h4 class="mb-3 text-xl font-semibold tracking-tight text-green-600 uppercase">
                            {{ $menu->name }}</h4>
                        <p class="leading-normal text-gray-700">{{ $menu->description }}.</p>
                    </div>
                    <div class="flex items-center justify-between p-4">
                        <span class="text-xl text-green-600">${{ $menu->price }}</span>
                        <p class="text-xl text-green-600" ><a href="{{ route('menus.store' , $menu->id ) }}" class=" btn btn-primary">Order</a></p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-center  ">
        {{$menus->links()}}
    </div>
</x-guest-layout>
