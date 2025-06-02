@foreach ($customers as $customer)

    <head>
        <title>Purchase From Facebook</title>
    </head>
    <div
        style="background-color: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 24px; max-width: 800px; margin: 0 auto;">
        <!-- Header -->
        <table style="width: 100%; border-bottom: 1px solid #e5e7eb; padding-bottom: 16px;">
            <tr>
                <td>
                    <h1 style="font-size: 24px; font-weight: bold; color: #4a5568;">Invoice</h1>
                    <p style="color: #000000;">Invoice #{{ $customer->order_number }}</p>
                    <p style="color: #000000;">Date: {{ $customer->order_create_time }}</p>
                </td>
                <td style="text-align: right;">
                    <img src="/path-to-your-logo.png" alt="Company Logo" style="height: 64px;">
                </td>
            </tr>
        </table>

        <!-- Billing Information -->
        <table style="width: 100%; margin-top: 24px;">
            <tr>
                <td>
                    <h2 style="font-weight: bold; color: #4a5568;">Billed From</h2>
                    <p style="color: #000000;">{{ $customer->name }}</p>
                    <p style="color: #000000;">{{ $customer->address }}</p>
                    <p style="color: #000000;">{{ $customer->phone }}</p>
                </td>
                <td style="text-align: right;">
                    <h2 style="font-weight: bold; color: #4a5568;">Company</h2>
                    <p style="color: #000000;">Current Company</p>
                    <p style="color: #000000;">Current Address</p>
                    <p style="color: #000000;">Current Zipcode</p>
                    <p style="color: #000000;">Email: Current Email</p>
                </td>
            </tr>
        </table>

        <!-- Invoice Items -->
        <table style="width: 100%; margin-top: 24px; border-collapse: collapse; border: 1px solid #e2e8f0;">
        <thead>
            <tr style="background-color: #f7fafc;">
                <th style="border: 1px solid #e2e8f0; padding: 8px; text-align: left; color: #4a5568;">Description</th>
                <th style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #4a5568;">Quantity</th>
                <th style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #4a5568;">Unit Price</th>
                <th style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #4a5568;">Total</th>
            </tr>
        </thead>
        <tbody>
           @foreach ($customer->orderLists as $order)
                <tr>
                    <td style="border: 1px solid #e2e8f0; padding: 8px; color: #000000;">
                        {{ $order->adminProduct->product_name ?? '-' }}
                    </td>
                    <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #000000;">
                        {{ $order->item_quentity }}
                    </td>
                    <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #000000;">
                        {{ number_format($order->unit_price, 2) }}
                    </td>
                    <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #000000;">
                        {{ number_format($order->item_quentity * $order->unit_price, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
         <tfoot>
            <tr style="background-color: #f7fafc;">
                <td colspan="3" style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; font-weight: bold; color: #000000;">Subtotal</td>
                <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #000000;">{{ number_format($customer->total_paid,2) }}</td>
            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; font-weight: bold; color: #000000;">Discount</td>
                <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #000000;">{{ $customer->discount ?? 0 }}</td>
            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; font-weight: bold; color: #000000;">Pre Payment</td>
                <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #000000;">{{ $customer->pre_payment ?? 0 }}</td>
            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; font-weight: bold; color: #000000;">Delivery Fee</td>
                <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #000000;">{{ $customer->shipping_fee }}</td>
            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; font-weight: bold; color: #000000;">Total</td>
                <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #000000;">{{ number_format($customer->total_paid + $customer->shipping_fee - $customer->pre_payment - $customer->discount, 2) }}</td>
            </tr>
        </tfoot> 
    </table>

        {{-- <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #e2e8f0; padding: 8px;">Product Title</th>
                    <th style="border: 1px solid #e2e8f0; padding: 8px; text-align: right;">Quantity</th>
                    <th style="border: 1px solid #e2e8f0; padding: 8px; text-align: right;">Unit Price</th>
                    <th style="border: 1px solid #e2e8f0; padding: 8px; text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customer->orderLists as $order)
                    <tr>
                        <td style="border: 1px solid #e2e8f0; padding: 8px;">{{ $order->adminProduct->product_name ?? '-' }}
                        </td>
                        <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right;">
                            {{ $order->item_quentity }}</td>
                        <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right;">
                            {{ number_format($order->unit_price, 2) }}</td>
                        <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right;">
                            {{ number_format($order->item_quentity * $order->unit_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}


        <!-- Footer -->
        <div style="margin-top: 24px; text-align: center; color: #a0aec0;">
            <p>Thank you for your business!</p>
            <p>If you have any questions about this invoice, please contact us at info@company.com.</p>
        </div>
    </div>
@endforeach
