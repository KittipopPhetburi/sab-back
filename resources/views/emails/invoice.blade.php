<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งหนี้/ใบกำกับภาษี</title>
    <style>
        body {
            font-family: 'Sarabun', 'TH Sarabun New', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1e40af;
            margin: 0;
            font-size: 28px;
        }
        .doc-number {
            color: #64748b;
            font-size: 16px;
            margin-top: 10px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background-color: #eff6ff;
            padding: 10px 15px;
            border-left: 4px solid #3b82f6;
            font-weight: bold;
            font-size: 18px;
            color: #1e40af;
            margin-bottom: 15px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-label {
            font-weight: 600;
            color: #64748b;
        }
        .info-value {
            color: #1e293b;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .items-table th {
            background-color: #3b82f6;
            color: white;
            padding: 12px;
            text-align: left;
        }
        .items-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        .items-table tr:hover {
            background-color: #f8fafc;
        }
        .total-section {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 16px;
        }
        .total-row.grand-total {
            border-top: 2px solid #3b82f6;
            margin-top: 10px;
            padding-top: 15px;
            font-weight: bold;
            font-size: 20px;
            color: #1e40af;
        }
        .notes {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin-top: 20px;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #64748b;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>{{ $invoice['documentType'] === 'invoice' ? 'ใบแจ้งหนี้/ใบกำกับภาษี' : 'ใบเสร็จรับเงิน/ใบกำกับภาษี' }}</h1>
            <div class="doc-number">เลขที่เอกสาร: {{ $invoice['docNumber'] }}</div>
            <div class="doc-number">วันที่: {{ $invoice['docDate'] }}</div>
        </div>

        <div class="section">
            <div class="section-title">ข้อมูลลูกค้า</div>
            <div class="info-row">
                <span class="info-label">ชื่อลูกค้า:</span>
                <span class="info-value">{{ $invoice['customer']['name'] }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">รหัสลูกค้า:</span>
                <span class="info-value">{{ $invoice['customer']['code'] }}</span>
            </div>
            @if(!empty($invoice['customer']['address']))
            <div class="info-row">
                <span class="info-label">ที่อยู่:</span>
                <span class="info-value">{{ $invoice['customer']['address'] }}</span>
            </div>
            @endif
        </div>

        @if(!empty($invoice['shippingAddress']))
        <div class="section">
            <div class="section-title">ข้อมูลการจัดส่ง</div>
            <div class="info-row">
                <span class="info-label">ที่อยู่จัดส่ง:</span>
                <span class="info-value">{{ $invoice['shippingAddress'] }}</span>
            </div>
            @if(!empty($invoice['shippingPhone']))
            <div class="info-row">
                <span class="info-label">เบอร์โทรติดต่อ:</span>
                <span class="info-value">{{ $invoice['shippingPhone'] }}</span>
            </div>
            @endif
        </div>
        @endif

        <div class="section">
            <div class="section-title">รายการสินค้า/บริการ</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ลำดับ</th>
                        <th>รายละเอียด</th>
                        <th style="width: 150px; text-align: right;">จำนวนเงิน (บาท)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice['items'] as $index => $item)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ $item['description'] }}</td>
                        <td style="text-align: right;">{{ number_format($item['amount'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="total-section">
            <div class="total-row">
                <span>ยอดรวม:</span>
                <span>{{ number_format($invoice['subtotal'], 2) }} บาท</span>
            </div>
            <div class="total-row">
                <span>ส่วนลด ({{ $invoice['discount'] }}%):</span>
                <span>{{ number_format($invoice['discountAmount'], 2) }} บาท</span>
            </div>
            <div class="total-row">
                <span>ยอดหลังหักส่วนลด:</span>
                <span>{{ number_format($invoice['afterDiscount'], 2) }} บาท</span>
            </div>
            <div class="total-row">
                <span>ภาษีมูลค่าเพิ่ม ({{ $invoice['vatRate'] }}%):</span>
                <span>{{ number_format($invoice['vat'], 2) }} บาท</span>
            </div>
            <div class="total-row grand-total">
                <span>ยอดรวมทั้งสิ้น:</span>
                <span>{{ number_format($invoice['grandTotal'], 2) }} บาท</span>
            </div>
        </div>

        @if(!empty($invoice['notes']))
        <div class="notes">
            <strong>หมายเหตุ:</strong><br>
            {!! nl2br(e($invoice['notes'])) !!}
        </div>
        @endif

        <div class="footer">
            <p>เอกสารนี้สร้างโดยระบบ SAP อัตโนมัติ</p>
            <p>หากมีข้อสงสัยกรุณาติดต่อ: kupalmma@gmail.com</p>
        </div>
    </div>
</body>
</html>
