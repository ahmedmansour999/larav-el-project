<x-guest-layout>

    @if ($orders != null)


        @foreach ($orders as $order)

            <p>

                {{ $order }}

            </p>

        @endforeach


    @endif


</x-guest-layout>








