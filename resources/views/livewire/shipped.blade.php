<div>
    <audio id="confirmSound" src="{{ asset('sounds/confirm.mp3') }}" preload="auto"></audio>
    <audio id="dublicateSound" src="{{ asset('sounds/dublicate.mp3') }}" preload="auto"></audio>
    <audio id="not_confirmSound" src="{{ asset('sounds/not_confirm.mp3') }}" preload="auto"></audio>
    <audio id="not_foundSound" src="{{ asset('sounds/not_found.mp3') }}" preload="auto"></audio>
    <audio id="setcodeSound" src="{{ asset('sounds/setcode.mp3') }}" preload="auto"></audio>
    <div class="p-6 max-w-md mx-auto">
        <h2 class="text-lg font-semibold text-center mb-4">Scan Order to Auto Update</h2>

        <input type="text" id="orderInput" wire:model="orderNumber" wire:keydown.enter="submitOrderNumber"
            placeholder="Scan Order Number" @if ($disableOrderInput) disabled @endif
            class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">

        @if (session()->has('success'))
            <div class="mt-3 text-green-600 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mt-3 text-red-600 text-sm">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <table class="w-full table-auto border border-collapse border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">product id</th>
                <th class="border px-4 py-2">customer id</th>
                <th class="border px-4 py-2">Order List Id</th>
                <th class="border px-4 py-2">Order Number</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Image</th>
                <th class="border px-4 py-2">match</th>
                <th class="border px-4 py-2">Product Code</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @php $id = 1; @endphp
            @forelse ($pendingOrders as $order)
                @foreach ($order['items'] as $index => $item)
                    <tr>
                        <td class="border px-4 py-2">{{ $item['product_id'] }}</td>
                        <td class="border px-4 py-2">{{ $order['id'] }}</td>
                        <td class="border px-4 py-2">{{ $item['id'] }}</td>
                        <td class="border px-4 py-2">{{ $order['order_number'] ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $item['product']['product_name'] ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">
                            @php
                                $product = $item['product'];
                                $images = [];
                                if (!empty($product['image'])) {
                                    $images = is_string($product['image'])
                                        ? json_decode($product['image'], true)
                                        : $product['image'];
                                }
                            @endphp
                            @if (is_array($images))
                                <div class="flex gap-2">
                                    @foreach ($images as $img)
                                        <img src="{{ asset('storage/' . $img) }}" height="70" width="70"
                                            class="rounded shadow border" alt="Product Image">
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td class="border px-4 py-2">

                            @php
                                $stockItem = \App\Models\CollectProductStockList::find($item['product_code']);

                                $adminProduct =
                                    $stockItem && $stockItem['admin_product_id']
                                        ? \App\Models\AdminProduct::find($stockItem['admin_product_id'])
                                        : null;

                                $imagess = [];

                                if (!empty($adminProduct['image'])) {
                                    $imagess = is_string($adminProduct['image'])
                                        ? json_decode($adminProduct['image'], true)
                                        : $adminProduct['image'];
                                }
                            @endphp
                            @if (isset($matchedProductImages[$item['id']]) && $matchedProductImages[$item['id']])
                                <img src="{{ asset('storage/' . $matchedProductImages[$item['id']]) }}" height="70"
                                    width="70" class="rounded shadow border" alt="Product Image">
                            @elseif (is_array($imagess) && count($imagess))
                                <div class="flex gap-2">
                                    @foreach ($imagess as $img)
                                        <img src="{{ asset('storage/' . $img) }}" height="70" width="70"
                                            class="rounded shadow border" alt="Product Image">
                                    @endforeach
                                </div>
                            @else
                                No Image!
                            @endif
                        </td>
                        <td class="border px-4 py-2">
                            @if ($item['product_code'] == null)
                                <input type="text" id="productInput-{{ $item['id'] }}"
                                    wire:model="productIds.{{ $item['id'] }}"
                                    wire:keydown.enter="SubmitProductIdlist({{ $item['id'] }})"
                                    placeholder="Scan Product Code"
                                    class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @else
                                {{ $item['product_code'] }}
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $order['status'] ?? 'N/A' }}</td>
                        @if ($index === 0)
                            <td class="border px-4 py-2 font-semibold text-green-600"
                                rowspan="{{ count($order['items']) }}">
                                <button wire:click="removeOrder({{ $order['id'] }})" class=""
                                    style="border-radius:5px;background-color:red; padding: 10px; color:white">
                                    Remove
                                </button>
                            </td>
                        @endif
                    </tr>
                    @php $id++; @endphp
                @endforeach
            @empty
                <tr>
                    <td colspan="11" class="text-center text-red-500 py-4">
                        No pending orders found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        document.addEventListener('livewire:init', () => {

            //confirm sound play-------------
            Livewire.on('play-confirm-sound', () => {
                const sound = document.getElementById('confirmSound');
                sound.currentTime = 0; // Rewind to start
                sound.play().catch(e => console.log("Sound play failed:", e));
            });
            //dublicate sound play-------------
            Livewire.on('play-dublicate-sound', () => {
                const sound = document.getElementById('dublicateSound');
                sound.currentTime = 0; // Rewind to start
                sound.play().catch(e => console.log("Sound play failed:", e));
            });
            //not confirm sound play-------------
            Livewire.on('play-not_confirm-sound', () => {
                const sound = document.getElementById('not_confirmSound');
                sound.currentTime = 0; // Rewind to start
                sound.play().catch(e => console.log("Sound play failed:", e));
            });

            //not found sound play-------------
            Livewire.on('play-not_found-sound', () => {
                const sound = document.getElementById('not_foundSound');
                sound.currentTime = 0; // Rewind to start
                sound.play().catch(e => console.log("Sound play failed:", e));
            });

            //Set Product code sound play-------------
            Livewire.on('play-set_product_code-sound', () => {
                const sound = document.getElementById('setcodeSound');
                sound.currentTime = 0; // Rewind to start
                sound.play().catch(e => console.log("Sound play failed:", e));
            });


            Livewire.on('focus-input', (data) => {
                setTimeout(() => {
                    const input = document.getElementById(`productInput-${data.id}`);
                    if (input) {
                        input.focus();
                        input.select();
                    }
                }, 50);
            });

            Livewire.on('focus-order-input', () => {
                setTimeout(() => {
                    const input = document.getElementById('orderInput');
                    if (input) {
                        input.focus();
                        input.select();
                    }
                }, 50);
            });
        });
    </script>
</div>
