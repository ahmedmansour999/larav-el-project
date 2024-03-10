<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-content-between m-2 p-2">

                {{-- <form id="userForm" action="{{ route('admin.orders') }}" method="get">
                    <select id="userSelect" class="text-dark rounded-lg " name="userId" onchange="document.getElementById('userForm').submit()">
                        <option value="">Select User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </form> --}}

                <h1 class="text-dark fs-1 text-capitalize">All Orders</h1>
            </div>

            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow-md sm:rounded-lg">
                            <table class="min-w-full">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Title
                                        </th>
                                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Notes
                                        </th>
                                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Total Price
                                        </th>
                                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Client Name
                                        </th>
                                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Accept
                                        </th>
                                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Cancel
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-black">
                                                {{ $order->title }}
                                            </td>

                                            @if ($order->note)
                                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-black">
                                                    {{ $order->hint }}
                                                </td>
                                            @else
                                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-black">
                                                    No Hint
                                                </td>
                                            @endif

                                            <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-black">
                                                {{ $order->total }} Eg
                                            </td>
                                            <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-black">
                                              @foreach ($users as $user)
                                                @if ($user->id == $order->user_id)

                                                    <p> {{ $user->name }} </p>


                                                @endif
                                              @endforeach
                                            </td>

                                            <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-black">
                                                <form action="{{ route('order.accept', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn bg-primary text-white btn-primary">Accept</button>
                                                </form>
                                            </td>
                                            <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-black">
                                                <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn bg-danger text-white btn-danger">Cancel</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
