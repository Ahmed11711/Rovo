@component('mail::layout')

@slot('header')
@component('mail::header', ['url' => route('shop_restaurant', ['hash' => $settings->hash])])
{{ $settings->name }}
@endcomponent
@endslot

## {{ __('email.sendOrderBill.dear') }} {{ $order->customer->name }},

{{ __('email.sendOrderBill.thankYouForDining') }} **{{ $settings->name }}**! {{ __('email.sendOrderBill.excitedToServe')}}

## {{ __('email.sendOrderBill.orderSummary') }}

**{{ __('email.sendOrderBill.order') }}**: #{{ $order->order_number }}
@component('mail::table')
| {{ __('modules.menu.itemName') }}           | {{ __('modules.order.qty') }}      | {{ __('modules.order.price') }}     |
|:-------------- |:-------------:| ---------:|
@foreach ($items as $item)
| **{{ $item->menuItem->item_name }}** @if ($item->modifierOptions->isNotEmpty()) @foreach ($item->modifierOptions as $modifier) <br> &nbsp;• {{ $modifier->name }} @if ($modifier->price > 0) (+{{ currency_format($modifier->price, $settings->currency_id) }}) @endif @endforeach @endif | {{ $item->quantity }} | {{ currency_format(($item->price + $item->modifierOptions->sum('price')) * $item->quantity, $settings->currency_id) }} |
@endforeach
| **{{ __('modules.order.subTotal') }}**   |               | **{{ currency_format($subtotal, $settings->currency_id) }}** |
@if (!is_null($order->discount_amount))
| **{{ __('modules.order.discount') }}** @if ($order->discount_type == 'percent') **({{ rtrim(rtrim($order->discount_value, '0'), '.') }}%)** @endif |     | **-{{ currency_format($order->discount_amount, $settings->currency_id) }}** |
@endif
@foreach ($chargesWithAmount as $charge)
| **{{ $charge['name'] }}** @if ($charge['type'] == 'percent') **({{ rtrim(rtrim($charge['rate'], '0'), '.') }}%)** @endif |     | **{{ currency_format($charge['amount'], $settings->currency_id) }}** |
@endforeach
@foreach ($taxesWithAmount as $tax)
| **{{ $tax['name'] }} ({{ $tax['rate'] }}%)** |     | **{{ currency_format($tax['amount'], $settings->currency_id) }}** |
@endforeach
| **{{ __('modules.order.total') }}**      |               | **{{ currency_format($totalPrice, $settings->currency_id) }}** |
@endcomponent

**{{ __('app.date') }}**: {{ $order->date_time->translatedFormat('F j, Y, g:i a') }}

{{ __('email.sendOrderBill.satisfactionMessage') }}

@lang('app.regards'),<br>
{{ $settings->name }}

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
    © {{ date('Y') }} {{ $settings->name }}. All rights reserved.
@endcomponent
@endslot
@endcomponent
