<x-filament::page>
<p class="text-2xl font-bold mb-4">Collection Number #{{ $user->collection_number }}</p>
<p class="text-2xl font-bold mb-4">Collection User #{{ $user->user->name }}</p>

    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left">#</th>
                <th class="px-6 py-3 text-left">Image</th>
                <th class="px-6 py-3 text-left">Colelct User</th>
                <th class="px-6 py-3 text-left">Product Name</th>
                <th class="px-6 py-3 text-left">Quantity</th>
                <th class="px-6 py-3 text-left">Total</th>
            </tr>
        </thead>
        <tbody>

            @php
                $totalQuantity = 0;
                $totalAmount = 0;
            @endphp
            @foreach ($products as $index=>$product)
                @php
                    $lineTotal = $product->quantity * $product->paid_price;
                    $totalQuantity += $product->quantity;
                    $totalAmount += $lineTotal;
                
                @endphp
                <tr class="border-t">
                    <td class="px-6 py-2">{{ $index + 1 }}</td>
                    <td class="px-6 py-2">
                        @php
                            $images = is_array($product->adminProduct->image)
                                ? $product->adminProduct->image
                                : json_decode($product->adminProduct->image, true);
                        @endphp

                        @if(!empty($images[0]))
                            <img src="{{ asset('storage/' . $images[0]) }}" class="w-16 h-16 rounded-md">
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="px-6 py-2">{{ $product->user->name }}</td>
                    <td class="px-6 py-2">{{ $product->quantity }}</td>
                    <td class="px-6 py-2">{{ $product->paid_price }}</td>
                    <td class="px-6 py-2">{{ $lineTotal }}</td>
                </tr>
                
            @endforeach
            <tr class="border-t font-bold">
                <td class="px-6 py-2 text-right" colspan="2">Total</td>
                <td class="px-6 py-2">{{ $totalQuantity }}</td>
                <td class="px-6 py-2">—</td>
                <td class="px-6 py-2">{{ number_format($totalAmount, 2) }}</td>
            </tr>
        </tbody>
    </table>
</x-filament::page>
