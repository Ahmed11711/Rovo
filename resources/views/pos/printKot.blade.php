<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOT Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .kot-container {
            width: 100%;
            max-width: 80mm; /* Matches 3-inch thermal printer width */
            margin: 0 auto;
            padding: 6.35mm;
            border: 1px solid #000;
        }

        .header {
            text-align: center;
            margin-bottom: 5mm;
        }

        .header h2 {
            margin: 0;
            font-size: 5mm;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            margin: 1mm 0;
            font-size: 4mm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5mm;
        }

        th, td {
            font-size: 4mm;
            padding: 2mm;
            text-align: left;
            border-bottom: 1px dashed #000;
        }

        th {
            font-weight: bold;
        }

        .footer {
            margin-top: 5mm;
            font-size: 4mm;
        }

        .footer p {
            margin: 1mm 0;
        }

        .footer p.italic {
            font-style: italic;
        }

        .modifiers {
            font-size: 10pt;
            color: #555;
        }

        @media print {
            body {
                background-color: #ffffff;
            }

            .kot-container {
                border: none;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="kot-container">
        <!-- Header -->
        <div class="header">
            <h2>Kitchen Order Ticket</h2>
             <div>@lang('modules.order.orderNumber') #{{ $kot->order->order_number }} @if($kot->order->table) <strong>({{ $kot->order->table->table_code }})</strong> @endif</div>
            @if($kot->order->table)
            <p>Table #: @lang @if($kot->order->table) <span class="text-skin-base font-bold">{{ $kot->order->table->table_code }}</span> @endif</p>
            @endif
            <p>Date: <span>{{ $kot->created_at->timezone(timezone())->format('d-m-Y') }}</span></p>
            <p>Time: <span>{{ $kot->created_at->timezone(timezone())->format('h:i A') }}</span></p>
        </div>

        <!-- Items -->
        <div>
            <table>
            <thead>
                <tr>
                <th>Item</th>
                <th style="text-align: right;">Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kot->items as $item)
                <tr>
                <td>
                    {{ $item->menuItem->item_name }}
                    @foreach ($item->modifierOptions as $modifier)
                    <div class="modifiers">• {{ $modifier->name }}</div>
                    @endforeach
                </td>

                <td style="text-align: right;">{{ $item->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>

        <!-- Footer -->

        <div class="footer">
            @if ($kot->note)
            <p>Special Instructions:</p>
            <p class="italic">{{$kot->note}}</p>
            @endif

        </div>
    </div>

     <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
