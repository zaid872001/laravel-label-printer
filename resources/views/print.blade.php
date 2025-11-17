<!DOCTYPE html>
<html>

<head>
    <title>Stickers</title>

    <style>
        @page {
            size: 60mm 40mm;
            margin: 0;
        }
        body {
            margin-top: 120px;
            padding: 0;
        }
        .page-wrap {
            page-break-after: always;
            break-after: page;
        }
        .sticker {
            width: 60mm;
            height: 40mm;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }
        .sticker-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(90deg);
            transform-origin: center center;
            width: 40mm;
            box-sizing: border-box;
            padding: 3mm;
            text-align: center;
            font-family: Arial, "Helvetica Neue", sans-serif;
        }
        .content-inner {
            position: relative;
            top: 8mm;
        }
        .title-en {
            margin: 0 0 2mm 0;
            font-size: 8pt;
            font-weight: 700;
        }
        .title-ar {
            margin: 0 0 2mm 0;
            font-size: 8pt;
            direction: rtl;
        }
        .nutrition-card {
            margin: 0 auto 2mm auto;
            padding: 1mm 2mm;
            border: 0.3mm solid #000;
            border-radius: 2mm;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nutrition-item {
            flex: 1;
            text-align: center;
        }
        .nutrition-item:not(:last-child) {
            border-right: 0.18mm solid #000;
        }
        .nutrition-value {
            margin: 0;
            font-size: 8pt;
            font-weight: 700;
        }
        .nutrition-label {
            margin: 0;
            font-size: 6pt;
        }
        .barcode-wrapper {
            margin-top: 1mm;
        }
        .sn-barcode {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .sn-barcode svg {
            width: 100%;
            height: auto;
            max-height: 7mm;
        }
        .barcode-digits {
            margin-top: 0.6mm;
            font-size: 7pt;
            letter-spacing: 0.6mm;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .page-wrap {
                margin-top: 120px;
                page-break-inside: avoid;
                break-inside: avoid;
                display: block;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
</head>

<body>

    @foreach ($labels as $label)
        <div class="page-wrap">
            <div class="sticker">
                <div class="sticker-content">
                    <div class="content-inner">
                        <div class="title-en">
                            {{ $label['name_en'] ?? '' }}
                        </div>
                        <div class="title-ar">
                            {{ $label['name_ar'] ?? '' }}
                        </div>
                        <div class="nutrition-card">
                            <div class="nutrition-item">
                                <p class="nutrition-value">{{ $label['kcal'] ?? '' }}</p>
                                <p class="nutrition-label">Kcal</p>
                            </div>
                            <div class="nutrition-item">
                                <p class="nutrition-value">{{ $label['protein'] ?? '' }}</p>
                                <p class="nutrition-label">Pro</p>
                            </div>
                            <div class="nutrition-item">
                                <p class="nutrition-value">{{ $label['carb'] ?? '' }}</p>
                                <p class="nutrition-label">Carb</p>
                            </div>
                            <div class="nutrition-item">
                                <p class="nutrition-value">{{ $label['fat'] ?? '' }}</p>
                                <p class="nutrition-label">Fat</p>
                            </div>
                        </div>
                        <div class="barcode-wrapper">
                            <div class="sn-barcode">
                                <svg class="sn-barcode-svg" jsbarcode-value="{{ $label['barcode'] ?? '' }}"
                                    jsbarcode-format="CODE128" jsbarcode-height="50" jsbarcode-displayValue="false">
                                </svg>
                            </div>
                            <div class="barcode-digits">
                                {{ $label['barcode'] ?? '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        window.onload = function() {
            JsBarcode(".sn-barcode-svg").init();
            window.print();
        };
    </script>

</body>

</html>
