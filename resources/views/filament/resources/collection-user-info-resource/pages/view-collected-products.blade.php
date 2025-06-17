<x-filament::page>
    <x-filament::card>
        <div>
            <p style="text-align: center;background-color:#ebebeb" class="mb-4 p-4">Collection Number #{{ $user->collection_number }} <br> Collection User {{ $user->user->name }} </p>
            <table class="w-full border text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">SL</th>
                        <th class="border px-4 py-2">Image</th>
                        <th class="border px-4 py-2">Colelct User</th>
                        <th class="border px-4 py-2">Product Name</th>
                        <th class="border px-4 py-2">Quantity</th>
                        <th class="border px-4 py-2">Total</th>
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
                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2">
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
                    <td class="border px-4 py-2">{{ $product->user->name }}</td>
                    <td class="border px-4 py-2">{{ $product->quantity }}</td>
                    <td class="border px-4 py-2">{{ $product->paid_price }}</td>
                    <td class="border px-4 py-2">{{ $lineTotal }}</td>
                </tr>
                
            @endforeach
            <tr class="border-t font-bold">
                <td class="border px-4 py-2 text-center" colspan="3">Total</td>
                <td class="border px-4 py-2">{{ $totalQuantity }}</td>
                <td class="border px-4 py-2">—</td>
                <td class="border px-4 py-2">{{ number_format($totalAmount, 2) }}</td>
            </tr>
        </tbody>
            </table>
        </div>
    </x-filament::card>
</x-filament::page>
