<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Payment Receipt</title>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <style>
        * {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        .bg-grey {
            background-color: #F2F4F7;
        }

        .bg-white {
            background-color: #fff;
        }

        .border-radius-25 {
            border-radius: 0.25rem;
        }

        .p-25 {
            padding: 1.25rem;
        }

        .f-11 {
            font-size: 11px;
        }

        .f-12 {
            font-size: 12px;
        }

        .f-13 {
            font-size: 13px;
        }

        .f-14 {
            font-size: 13px;
        }

        .f-15 {
            font-size: 13px;
        }

        .f-21 {
            font-size: 17px;
        }

        .text-black {
            color: #28313c;
        }

        .text-grey {
            color: #616e80;
        }

        .font-weight-700 {
            font-weight: 700;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-capitalize {
            text-transform: capitalize;
        }

        .line-height {
            line-height: 15px;
        }

        .mt-1 {
            margin-top: 1rem;
        }

        .mb-0 {
            margin-bottom: 0px;
        }

        .b-collapse {
            border-collapse: collapse;
        }

        .heading-table-left {
            padding: 6px;
            border: 1px solid #DBDBDB;
            font-weight: bold;
            background-color: #f1f1f3;
            border-right: 0;
        }

        .heading-table-right {
            padding: 6px;
            border: 1px solid #DBDBDB;
            border-left: 0;
        }

        .paid {
            color: #28a745 !important;
            border: 1px solid #28a745;
            position: relative;
            padding: 3px 8px;
            font-size: 12px;
            border-radius: 0.25rem;
            width: 75px;
            text-align: center;
            margin-top: 50px;
        }

        .main-table-heading {
            border: 1px solid #DBDBDB;
            background-color: #f1f1f3;
            font-weight: 700;
        }

        .main-table-heading td {
            padding: 5px 8px;
            border: 1px solid #DBDBDB;
            font-size: 11px;
        }

        .main-table-items td {
            padding: 5px 8px;
            border: 1px solid #e7e9eb;
        }

        .total-box {
            border: 1px solid #e7e9eb;
            padding: 0px;
            border-bottom: 0px;
        }

        .total {
            padding: 10px 8px;
            border: 1px solid #e7e9eb;
            border-top: 0;
            font-weight: 700;
            border-left: 0;
            border-right: 0;
        }

        .total-amt {
            padding: 10px 8px;
            border: 1px solid #e7e9eb;
            border-top: 0;
            border-left: 0;
            border-right: 0;
            font-weight: 700;
        }

        .balance {
            font-size: 13px;
            font-weight: bold;
        }

        .balance-left {
            padding: 10px 8px;
            border: 1px solid #e7e9eb;
            border-top: 0;
            border-left: 0;
            border-right: 0;
        }

        .balance-right {
            padding: 10px 8px;
            border: 1px solid #e7e9eb;
            border-top: 0;
            border-left: 0;
            border-right: 0;
        }

        .centered {
            margin: 0 auto;
        }

        .rightaligned {
            margin-right: 0;
            margin-left: auto;
        }

        .leftaligned {
            margin-left: 0;
            margin-right: auto;
        }

        .page_break {
            page-break-before: always;
        }

        #logo {
            height: 40px;
        }

        .word-break {
            max-width: 175px;
            word-wrap: break-word;
        }

        .summary {
            padding: 11px 10px;
            border: 1px solid #e7e9eb;
            font-size: 11px;
        }

        .border-left-0 {
            border-left: 0 !important;
        }

        .border-right-0 {
            border-right: 0 !important;
        }

        .border-top-0 {
            border-top: 0 !important;
        }

        .border-bottom-0 {
            border-bottom: 0 !important;
        }

        .h3-border {
            border-bottom: 1px solid #AAAAAA;
        }
    </style>

</head>

<body class="content-wrapper">
    <table class="bg-white" border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
        <tbody>
            <!-- Table Row Start -->
            <tr>
                <td style="vertical-align: top;"><img src="{{ global_setting()->logo_url }}" id="logo" />
                    <p class="line-height mb-0 f-11 text-black">
                        {{ global_setting()->name }}
                    </p>
                </td>
                <td align="right" class="f-21 text-black text-uppercase">Payment Receipt<br>
                    <table class="text-black mt-1 f-11 b-collapse rightaligned">
                        <tr>
                            <td class="heading-table-left text-capitalize">Receipt#</td>
                            <td class="heading-table-right">{{ $invoice->id }}</td>
                        </tr>
                        <tr>
                            <td class="heading-table-left text-capitalize">Payment Date</td>
                            <td class="heading-table-right">
                                {{ $invoice->pay_date->format('D, d M, Y')}}
                            </td>
                        </tr>
                        <tr>
                            <td class="heading-table-left text-capitalize">Transaction ID</td>
                            <td class="heading-table-right">
                                {{ $invoice->transaction_id }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- Table Row End -->
            <tr>
                <td height="10"></td>
            </tr>
            <!-- Table Row Start -->
            <tr>
                <td class="f-12 text-black" style="vertical-align: top;">
                    <p class="line-height mb-0">
                        <span class="text-grey text-capitalize">@lang('modules.billing.billedTo')</span><br>
                        {{ $invoice->restaurant->name }}
                    </p>
                </td>
                <td align="right">
                    <div style="margin: 0 0 auto auto" class="text-uppercase bg-white paid rightaligned">
                        @lang('modules.billing.paid')
                    </div>
                </td>
            </tr>
            <!-- Table Row End -->
            <!-- Table Row Start -->
            <tr>
                <td height="10"></td>
            </tr>
            <!-- Table Row End -->
            <!-- Table Row Start -->

        </tbody>
    </table>

    <table width="100%" class="f-14 b-collapse">
        <tr>
            <td height="10" colspan="2"></td>
        </tr>
        <!-- Table Row Start -->
        <tr class="main-table-heading text-grey">
            <td width="40%">@lang('modules.package.description')</td>
            <td align="right">@lang('modules.package.packageName')</td>
            <td align="right">@lang('modules.package.packagePrice')</td>
            <td align="right">@lang('modules.package.amount') ({{ $invoice->globalCurrency->currency_code }})</td>
        </tr>
        <!-- Table Row End -->
        <!-- Table Row Start -->
        <tr class="f-12 main-table-items text-black">
            <td width="40%" class="border-bottom-0">
                {{ $invoice->package->description }}
            </td>
            <td align="right" width="10%" class="border-bottom-0">{{ $invoice->package->package_name }} ({{ $invoice->package_type }})</td>
            <td align="right" class="border-bottom-0">{{ $invoice->sub_total ?? 0 }}</td>
            <td align="right" class="border-bottom-0">{{ $invoice->sub_total ?? 0 }}</td>
        </tr>
        <!-- Table Row End -->

        <!-- Table Row Start -->
        <tr>
            <td class="total-box" align="right" colspan="3">
                <table width="100%" border="0" class="b-collapse">

                    <!-- Table Row Start -->
                    <tr align="right" class="text-grey">
                        <td width="50%" class="total">@lang('modules.billing.total')</td>
                    </tr>
                    <!-- Table Row End -->
                </table>
            </td>
            <td class="total-box" align="right">
                <table width="100%" class="b-collapse">
                    <!-- Table Row Start -->
                    <tr align="right" class="text-grey">
                        <td class="total-amt f-15">{{ $invoice->total }}</td>
                    </tr>
                    <!-- Table Row End -->

                </table>
            </td>
        </tr>
    </table>

    <div class="f-12 mt-1">
        @lang('modules.billing.paidVia') {{ $invoice->gateway_name }} - {{ $invoice->created_at->format('Y-m-d H:i:s') }}
    </div>

</body>

</html>
