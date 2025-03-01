<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ restaurant()->name }} - Order #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        .receipt {
            width: 80mm;
            padding: 6.35mm;
            page-break-after: always;
        }

        .header {
            text-align: center;
            margin-bottom: 3mm;
        }

        .restaurant-logo {
            width: 20px;
            height: 20px;
            margin-top: 3px;
        }

        .restaurant-name {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 1mm;
        }

        .restaurant-info {
            font-size: 9pt;
            margin-bottom: 1mm;
        }

        .order-info {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 2mm 0;
            margin-bottom: 3mm;
            font-size: 9pt;
        }

        . {
            font-weight: bold;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3mm;
            font-size: 9pt;
        }

        .items-table th {
            text-align: left;
            padding: 1mm;
            border-bottom: 1px solid #000;
        }

        .items-table td {
            padding: 1mm 0;
            vertical-align: top;
        }

        .qty {
            width: 10%;
            text-align: center;
        }

        .description {
            width: 50%;
        }

        .price {
            width: 20%;
            text-align: right;
        }

        .amount {
            width: 20%;
            text-align: right;
        }

        .summary {
            font-size: 9pt;
            margin-top: 2mm;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            justify-content: space-between;
            gap: 5px 55px;
            margin-bottom: 1mm;

        }

        .total {
            font-weight: bold;
            font-size: 11pt;
            border-top: 1px solid #000;
            padding-top: 1mm;
            margin-top: 1mm;
        }

        .footer {
            text-align: center;
            margin-top: 3mm;

            font-size: 9pt;
            padding-top: 2mm;
            border-top: 1px dashed #000;
        }

        .qr_code {
            margin-top: 5mm;
            margin-bottom: 3mm;
        }

        .modifiers {
            font-size: 8pt;
            color: #555;
        }

        @media print {
            @page {
                margin: 0;
                size: 80mm auto;
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="header">
            <div class="restaurant-name">
                <span>
                    @if ($receiptSettings->show_restaurant_logo)
                        <img src="{{ restaurant()->logo_url }}" alt="{{ restaurant()->name }}" class="restaurant-logo">
                    @endif
                </span>

                </span>
                <span>{{ restaurant()->name }}</span>
            </div>

            <div class="restaurant-info">{{ restaurant()->address }}</div>
            <div class="restaurant-info">@lang('modules.customer.phone'): {{ restaurant()->phone_number }}</div>
            @if ($receiptSettings->show_tax)

                @foreach ($taxDetails as $taxDetail)
                    <div class="restaurant-info">{{ $taxDetail->tax_name }}: {{ $taxDetail->tax_id }}</div>
                @endforeach
            @endif

        </div>

        <div class="order-info">

            <div class="">
                <div class="summary-row">
                    <span>@lang('modules.order.orderNumber') #<span class="order-number">{{ $order->order_number }}</span></span>
                    <span
                        class="space_left">{{ $order->date_time->timezone(timezone())->translatedFormat('d M Y H:i') }}</span>
                </div>
                <div class="summary-grid">

                    @if ($receiptSettings->show_table_number && $order->table && $order->table->table_code)
                        <span>@lang('modules.settings.tableNumber') :<span class="">{{ $order->table->table_code }}</span></span>
                    @endif
                    @if ($receiptSettings->show_total_guest && $order->number_of_pax)
                        <span>@lang('modules.order.noOfPax') :<span class="">{{ $order->number_of_pax }}</span></span>
                    @endif
                </div>

                <div class="summary-row">
                    @if ($receiptSettings->show_waiter && $order->waiter && $order->waiter->name)
                        <span>@lang('modules.order.waiter') :<span class="">{{ $order->waiter->name }}</span></span>
                    @endif
                </div>
                <div class="summary-row">
                    @if ($receiptSettings->show_customer_name && $order->customer && $order->customer->name)
                        <span class="showData">@lang('modules.customer.customer') :<span
                                class="">{{ $order->customer->name }}</span></span>
                    @endif
                </div>


                @if ($receiptSettings->show_customer_address && $order->customer && $order->customer->delivery_address)
                    <div class="summary-row">
                        <span>@lang('modules.customer.customerAddress') :<span
                                class="">{{ $order->customer->delivery_address }}</span></span>
                    </div>
                @endif
            </div>

        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th class="qty">@lang('modules.order.qty')</th>
                    <th class="description">@lang('modules.menu.itemName')</th>
                    <th class="price">@lang('modules.order.price')</th>
                    <th class="amount">@lang('modules.order.amount')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td class="qty">{{ $item->quantity }}</td>
                        <td class="description">
                            {{ $item->menuItem->item_name }}

                            @if (isset($item->menuItemVariation))
                                <br><small>({{ $item->menuItemVariation->variation }})</small>
                            @endif
                            @foreach ($item->modifierOptions as $modifier)
                                <div class="modifiers">• {{ $modifier->name }}
                                    (+{{ currency_format($modifier->price) }})
                                </div>
                            @endforeach
                        </td>
                        <td class="price">{{ currency_format($item->price) }}</td>
                        <td class="amount">
                            {{ currency_format($item->amount) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <div class="summary-row">
                <span>@lang('modules.order.subTotal'):</span>
                <span>{{ currency_format($order->sub_total) }}</span>
            </div>

            @if (!is_null($order->discount_amount))
                <div class="summary-row">
                    <span>@lang('modules.order.discount') @if ($order->discount_type == 'percent')
                            ({{ rtrim(rtrim($order->discount_value, '0'), '.') }}%)
                        @endif
                    </span>
                    <span>-{{ currency_format($order->discount_amount) }}</span>
                </div>
            @endif

            @foreach ($order->charges as $item)
            <div class="summary-row">
                <span>{{ $item->charge->charge_name }}
                    @if ($item->charge->charge_type == 'percent')
                    ({{ $item->charge->charge_value }}%)
                    @endif
                </span>
                <span>
                    @if ($item->charge->charge_type == 'percent')
                    {{ currency_format(($item->charge->charge_value / 100) * ($order->sub_total - ($order->discount_amount ?? 0))) }}
                    @else
                    {{ currency_format($item->charge->charge_value) }}
                    @endif
                </span>
            </div>
            @endforeach

            @foreach ($order->taxes as $item)
                <div class="summary-row">
                    <span>{{ $item->tax->tax_name }} ({{ $item->tax->tax_percent }}%):</span>
                    <span>{{ currency_format(($item->tax->tax_percent / 100) * ($order->sub_total - ($order->discount_amount ?? 0))) }}</span>
                </div>
            @endforeach

            @if ($payment)
                <div class="summary-row">
                    <span>@lang('modules.order.balanceReturn'):</span>
                    <span>{{ currency_format($payment->balance) }}</span>

                </div>
            @endif

            <div class="summary-row total">
                <span>@lang('modules.order.total'):</span>
                <span>{{ currency_format($order->total) }}</span>
            </div>

        </div>

        <div class="footer">
            <p>@lang('messages.thankYouVisit')</p>

            <div>
                @if ($receiptSettings->show_payment_qr_code)
                    <p class="qr_code">@lang('modules.settings.payFromYourPhone')</p>
                    <img class="" src="{{ $receiptSettings->payment_qr_code_url }}" alt="QR Code">
                    <p class="">@lang('modules.settings.scanQrCode')</p>
                @endif
            </div>
        </div>


    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
