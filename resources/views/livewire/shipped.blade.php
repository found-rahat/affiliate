<div>
    <audio id="confirmSound" src="{{ asset('sounds/confirm.mp3') }}" preload="auto"></audio>
    <audio id="dublicateSound" src="{{ asset('sounds/dublicate.mp3') }}" preload="auto"></audio>
    <audio id="not_confirmSound" src="{{ asset('sounds/not_confirm.mp3') }}" preload="auto"></audio>
    <audio id="not_foundSound" src="{{ asset('sounds/not_found.mp3') }}" preload="auto"></audio>
    <audio id="setcodeSound" src="{{ asset('sounds/setcode.mp3') }}" preload="auto"></audio>


    @php
        $latestProvider = \App\Models\ShippingProvider::where('status', 'Pending')
            ->where('user_name', Auth::user()->name)
            ->latest()
            ->first();
    @endphp

    @if (!$latestProvider)
        <div class="p-6 max-w-md mx-auto">
            <div class="flex gap-2"> <!-- Added flex container with gap -->
                <select name="Provider" id="Provider" wire:model="selectedProvider"
                    class="flex-1 border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Select a Provider --</option>
                    <option value="Sundarban">Sundarban Courier Service</option>
                    <option value="RedX">RedX</option>
                    <option value="eCourier">eCourier</option>
                    <option value="Pathao">Pathao Courier</option>
                    <option value="Fastrack">Fastrack Courier</option>
                    <option value="Other">Other</option>
                </select>
                <button wire:click="submitProvider"
                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm bg-blue-600 text-black hover:bg-blue-700 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    type="submit"> Choose Provider </button>
            </div>
        </div>
    @endif
    @if ($latestProvider)

        <div class="p-6 max-w-md mx-auto">
            <h2 class="text-lg font-semibold text-center mb-4">Scan Shipped Order to Update</h2>
            <input type="text" id="orderInput" wire:model="orderNumber" wire:keydown.enter="submitOrderNumber"
                placeholder="Scan Order Number"
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
        
        <div id="print-area" class="w-full"
            style="background-color: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 24px; margin: 0 auto;">
            <h2 style="text-align: center;background-color:#ebebeb" class="mb-4 p-4">Curior Provider:
                {{ $latestProvider?->provider_name ?? 'None' }}<br>{{ $latestProvider?->created_at ?? 'None' }}</h2>

            <table class="w-full border text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">SL</th>
                        <th class="border px-4 py-2">Order Number</th>
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Phone Number</th>
                        <th class="border px-4 py-2">Address</th>
                        <th class="border px-4 py-2">Collect Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($this->orders as $order)
                        @php
                            $paid = $order->total_paid;
                            $pre_payment = $order->pre_payment;
                            $discount = $order->discount;
                            $cost = $order->shipping_fee;
                            $total = $paid + $cost - $pre_payment - $discount;
                        @endphp
                        <tr>
                            <td class="border px-4 py-2">{{ $i }}</td>
                            <td class="border px-4 py-2">{{ $order->order_number }}</td>
                            <td class="border px-4 py-2">{{ $order->name }}</td>
                            <td class="border px-4 py-2">{{ $order->phone }}</td>
                            <td class="border px-4 py-2">{{ Str::limit($order->address ?? 'N/A', 30) }}</td>
                            <td class="border px-4 py-2">{{ $total }}</td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
            <!-- Footer -->
            <div style="margin-top: 24px; text-align: center; color: #000000;">
                <p>Thank you for your business!</p>
                <p>If you have any questions about this invoice, please contact us at info@company.com.</p>
            </div>
        </div>

        <div class="p-4" style="display: flex; justify-content: center; gap: 10px;">
            <button wire:click="shippedList"
                style="border-radius:5px;background-color:rgb(5, 143, 255); padding: 10px; color:white">
                Confirm
            </button>
            <button onclick="printSection('print-area')"
                style="border-radius:5px;background-color:rgb(217, 217, 217); padding: 10px; color:rgb(0, 0, 0)">
                🖨️ Print Product list
            </button>
            
        </div>
    @endif





    {{-- old list --}}

    {{-- <div class="p-6 max-w-md mx-auto">
        <h2 class="text-lg font-semibold text-center mb-4">Scan Shipped Order to Update</h2>
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
    </div> --}}
    {{-- @if ($pendingOrders)
        <table class="w-full table-auto border border-collapse border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">SL</th>
                    <th class="border px-4 py-2">Product id</th>
                    <th class="border px-4 py-2">Order Number</th>
                    <th class="border px-4 py-2">Customer Info</th>
                    <th class="border px-4 py-2">Total Payment</th>
                    <th class="border px-4 py-2">Product Title</th>
                    <th class="border px-4 py-2">Images</th>
                    <th class="border px-4 py-2">Match Images</th>
                    <th class="border px-4 py-2">Product Code</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $id = 1; @endphp
                @forelse ($pendingOrders as $order)
                    @foreach ($order['items'] as $index => $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $id }}</td>
                            <td class="border px-4 py-2"> {{ $item['product_id'] }} </td>
                            @if ($index === 0)
                                <td rowspan="{{ count($order['items']) }}" class="border px-4 py-2">
                                    {{ $order['order_number'] ?? 'N/A' }}

                                </td>
                            @endif
                            @if ($index === 0)
                                <td rowspan="{{ count($order['items']) }}" class="border px-4 py-2">
                                    {!! 'N: ' . $order['name'] . '<br>' . 'A: ' . $order['address'] . '<br>' . 'P: ' . $order['phone'] !!}

                                </td>
                            @endif
                            @php
                                $totalPaid = $order['total_paid'];
                                $shipping_cost = $order['shipping_fee'];
                                $pre_payment = $order['pre_payment'] ?? 0;
                                $discount = $order['discount'] ?? 0;

                                $total_collection = $totalPaid + $shipping_cost - $pre_payment - $discount;
                            @endphp
                            @if ($index === 0)
                                <td rowspan="{{ count($order['items']) }}" class="border px-4 py-2">
                                    {!! 'C: ' .
                                        $totalPaid .
                                        '<br>' .
                                        'F: ' .
                                        $shipping_cost .
                                        '<br>' .
                                        'P: ' .
                                        $pre_payment .
                                        '<br>' .
                                        'D: ' .
                                        $discount .
                                        '<br>' .
                                        'T: ' .
                                        $total_collection !!}
                                </td>
                            @endif
                            <td class="border px-4 py-2">{{ Str::limit($item['product']['product_name'] ?? 'N/A', 30) }}
                            </td>
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
                                    <img src="{{ asset('storage/' . $matchedProductImages[$item['id']]) }}"
                                        height="70" width="70" class="rounded shadow border" alt="Product Image">
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

        <div class="p-4" style="display: flex; justify-content: center; gap: 10px;">
            <button wire:click="clearAll"
                style="border-radius:5px;background-color:rgb(217, 217, 217); padding: 10px; color:rgb(0, 0, 0)">
                Clear
            </button>

                        
                <button wire:click="shippedList"
                    style="border-radius:5px;background-color:rgb(5, 143, 255); padding: 10px; color:white">
                    Confirm to Next page
                </button>
               

            <button wire:click="PackingList"
                style="border-radius:5px;background-color:rgb(5, 143, 255); padding: 10px; color:white">
                Confirm
            </button>
        </div>

    @endif --}}

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

            Livewire.on('reloadPage', () => {
                location.reload();
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

        window.addEventListener('reload-page', event => {
            location.reload();
        });
    </script>


    <script>
        function printSection(sectionId) {
            const printContent = document.getElementById(sectionId).innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;

            // Prevent JS reload bugs after restoring body
            location.reload();
        }
    </script>
</div>
