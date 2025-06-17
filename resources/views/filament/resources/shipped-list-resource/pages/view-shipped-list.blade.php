<x-filament::page>
    <div class="text-right px-6 mt-4">
        <button onclick="printSection('print-area')"
            style="float: right; border-radius:5px;background-color:#000000; padding: 10px; color:rgb(255, 255, 255)">
            🖨️ Print</button>
    </div>
    <x-filament::card>
        @php
            $latestProvider = \App\Models\ShippingProvider::where('id', $record->id)->latest()->first();
        @endphp

        <div id='print-area'>


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
                        <th class="border px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @forelse($customerOrders as $order)
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
                            <td class="border px-4 py-2">{{ Str::limit($order->address ?? 'N/A', 20) }}</td>
                            <td class="border px-4 py-2">{{ $total }}</td>
                            <td class="border px-4 py-2">{{ $order->status }}</td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-filament::card>
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
