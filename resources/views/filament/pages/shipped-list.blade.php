<x-filament::page>

    
    @php
        $latestProvider = \App\Models\ShippingProvider::where('status', 'Pending')->latest()->first();
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
        <div class="text-right px-6 mt-4">
        <button onclick="printSection('print-area')" style="float: right; border-radius:5px;background-color:rgb(61, 255, 67); padding: 10px; color:rgb(0, 0, 0)">
            🖨️ Print Product list
        </button>
    </div>
    <div id="print-area" class="w-full"
        style="background-color: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 24px; margin: 0 auto;">
        <h2 style="text-align: center;background-color:#ebebeb" class="mb-4 p-4">Curior Provider:
            {{ $latestProvider?->provider_name ?? 'None' }}</h2>
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
                        <td class="border px-4 py-2">{{ '0' . $order->phone }}</td>
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
    @endif
    



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

</x-filament::page>
