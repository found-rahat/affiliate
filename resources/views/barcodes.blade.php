<!DOCTYPE html>
<html>
    <head>
        <title>Barcodes</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <style>
            body {
                font-family: Arial, sans-serif;
                padding: 20px;
            }

            .barcode-row {
                margin-right: 3px;
                text-align: center;
                border: 1px solid #ccc;
                padding: 20px 10px 10px 10px;
                margin-bottom: 15px;
                border-radius: 8px;
                background-color: #f9f9f9;
            }

            .barcode-id {
                font-weight: bold;
                font-size: 12px;
            }

            .barcode-img {
                width: 60px
            }
        </style>
    </head>

    <body>
        @foreach ($barcodes as $barcode)
            <div class="barcode-row" style="display: inline-block;">
                <img class="barcode-img" src="data:image/png;base64,{{ $barcode['barcode'] }}" alt="{{ $barcode['id'] }}">
                <div class="barcode-id">{{ $barcode['Product_id'] . '-' . $barcode['id'] }}</div>
            </div>
        @endforeach
    </body>

</html>
