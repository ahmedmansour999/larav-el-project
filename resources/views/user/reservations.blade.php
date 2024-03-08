<x-guest-layout>
    <div class="container mx-auto py-6">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Welcome Message -->
            <div class="p-6 bg-gray-100 border-b">
                <h2 class="text-2xl font-semibold text-gray-800">Welcome, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-600">Here are your reservations:</p>
            </div>
            
            <!-- Reservation Cards -->
            <div class="divide-y divide-gray-200">
                @foreach ($reservations as $reservation)
                    <div class="p-6 flex flex-col">
                        <div class="bg-gray-100 rounded-lg shadow-md overflow-hidden">
                            <div class="px-6 py-4">
                                <p class="text-gray-600 text-sm">Date: {{ $reservation->res_date }}</p>
                                <p class="text-gray-600 text-sm">Table Name: {{ $reservation->table->name }}</p>
                                <p class="text-gray-600 text-sm">Guests: {{ $reservation->guest_number }}</p>
                            </div>
                            <div class="px-6 py-4 bg-gray-200 flex justify-end">
                                <!-- Cancel Reservation Button -->
                                <form action="{{ route('reservation.cancel', $reservation->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Cancel Reservation
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-guest-layout>
