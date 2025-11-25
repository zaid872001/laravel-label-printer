<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Daily Program Labels</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        @page {
            size: 100mm 150mm;
            margin: 2mm;
            /* small page margins */
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }

        .page-wrap {
            page-break-after: always;
        }

        .label {
            width: 100%;
            height: 100%;
            box-sizing: border-box;
        }

        /* inner horizontal margins for content (name, phone, table) */
        .label-inner {
            margin: 0 5mm;
            /* little space left & right */
        }

        /* date + page number */
        .date {
            position: absolute;
            left: 4mm;
            top: 2mm;
            font-size: 10pt;
        }

        .page-number {
            position: absolute;
            right: 4mm;
            top: 2mm;
            font-size: 11pt;
        }

        /* header (Bagit + program) */
        .header-row {
            text-align: center;
            margin-top: 6mm;
            margin-bottom: 2mm;
        }

        .brand-title {
            font-size: 22pt;
            font-weight: bold;
            margin: 0 0 5mm 0;
            /* space under Bagit */
            padding: 0;
        }

        .program-title {
            font-size: 11pt;
            margin: 0;
            padding: 0;
        }

        /* customer name + phone line */
        .customer-row {
            margin: 4mm 0;
            font-size: 12pt;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .customer-name {
            flex: 1;
        }

        .customer-phone {
            margin-left: 5mm;
            white-space: nowrap;
        }

        /* table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }

        th,
        td {
            border: 0.25mm solid #000;
            padding: 2mm;
            vertical-align: top;
        }

        th {
            font-weight: bold;
        }

        .col-kcal {
            width: 20mm;
            text-align: right;
        }

        .meal-name {
            font-weight: bold;
        }

        .meal-size {
            font-size: 9pt;
            margin-top: 1mm;
        }

        /* bottom Note / Total section */
        .note-header {
            text-align: left;
        }

        .total-header {
            text-align: right;
        }

        .note-cell {
            border-top: none;
        }

        .time-slot {
            margin-top: 1mm;
            font-size: 9pt;
        }

        .total-cell {
            border-top: none;
            text-align: right;
            font-size: 12pt;
            font-weight: bold;
        }

        .qr-block {
            margin-top: 4mm;
            text-align: center;
        }

        .qr-box {
            width: 24mm;
            height: 24mm;
            margin: 0 auto;
        }

        @media print {
            .page-wrap {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    @foreach ($labels as $i => $label)
        <div class="page-wrap">

            {{-- DATE + PAGE NUMBER --}}
            <div class="date">{{ $label['date'] }}</div>
            <div class="page-number">{{ $i + 1 }}</div>

            <div class="label">
                <div class="label-inner">

                    {{-- HEADER --}}
                    <div class="header-row">
                        <div class="brand-title">Bagit</div>
                        <div class="program-title">{{ $label['program_name'] }}</div>
                        @if (!empty($label['time_slot']))
                            <div class="time-slot">
                                {{ $label['time_slot'] }}
                            </div>
                        @endif
                    </div>

                    {{-- CUSTOMER NAME + PHONE --}}
                    <div class="customer-row">
                        <div class="customer-name">
                            {{ $label['name'] ?? '' }}
                        </div>
                        <div class="customer-phone">
                            @php
                                $phone = $label['phone'] ?? '';
                                $masked = $phone
                                    ? str_repeat('*', max(strlen($phone) - 4, 0)) . substr($phone, -4)
                                    : '';
                            @endphp

                            {{ $masked }}
                        </div>
                    </div>

                    {{-- TABLE --}}
                    <table>
                        <thead>
                            <tr>
                                <th>Meal Name</th>
                                <th class="col-kcal">Kcal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($label['meals'] as $meal)
                                <tr>
                                    <td>
                                        <div class="meal-name">{{ $meal['name'] }}</div>
                                        @if (!empty($meal['size']))
                                            <div class="meal-size">{{ $meal['size'] }}</div>
                                        @endif
                                    </td>
                                    <td class="col-kcal">{{ $meal['kcal'] }}</td>
                                </tr>
                            @endforeach

                            {{-- NOTE + TOTAL as in the photo --}}
                            <tr>
                                <th class="note-header">Note</th>
                                <th class="col-kcal total-header">Total</th>
                            </tr>
                            <tr>
                                <td class="note-cell">
                                    {{ $label['allergens'] ?? '' }}
                                </td>
                                <td class="total-cell">
                                    {{ $label['total_kcal'] ?? '' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @if (!empty($label['qr']))
                        <div class="qr-block">
                            <div class="qr-box" data-qr="{{ $label['qr'] }}"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>

<script>
    window.onload = function() {
        // Generate QR codes for each label
        document.querySelectorAll('.qr-box').forEach(function(el) {
            var value = el.getAttribute('data-qr');
            if (!value) return;

            new QRCode(el, {
                text: value,
                width: 80,
                height: 80,
                margin: 0
            });
        });

        window.print();
    };
</script>

</html>
