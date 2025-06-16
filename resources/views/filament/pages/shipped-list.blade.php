<x-filament::page>
    <h2 class="text-xl font-bold mb-4">Pending Shipped Orders</h2>

    <table class="w-full border text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Order Number</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Shipped Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($this->orders as $order)
                <tr>
                    <td class="border px-4 py-2">{{ $order->order_number }}</td>
                    <td class="border px-4 py-2">{{ $order->status }}</td>
                    <td class="border px-4 py-2">{{ $order->shipped_time }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-gray-500 p-4">No Orders Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-filament::page>
