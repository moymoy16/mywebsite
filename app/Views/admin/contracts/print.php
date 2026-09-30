<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contract <?= htmlspecialchars($contract['contract_no']) ?></title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Georgia', serif;
            color: #1a1a2e;
            max-width: 800px;
            margin: 40px auto;
            padding: 40px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #1e3a8a;
            padding-bottom: 20px;
            margin-bottom: 32px;
            position: relative;
        }
        .header::before {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: #fbbf24;
            margin: 0 auto 12px;
            border-radius: 2px;
        }
        .header h1 {
            font-size: 24px;
            letter-spacing: 3px;
            margin: 0;
            color: #1e3a8a;
        }
        .header small {
            color: #666;
            letter-spacing: 1px;
            font-size: 11px;
            text-transform: uppercase;
        }
        .contract-no {
            text-align: right;
            font-size: 12px;
            color: #666;
            margin-bottom: 24px;
        }
        .contract-no strong { color: #1e3a8a; }
        h2 {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #1e3a8a;
            margin-top: 28px;
            margin-bottom: 12px;
            border-bottom: 1px solid #c0c0c0;
            padding-bottom: 6px;
        }
        dl { margin: 0; }
        dt {
            float: left;
            clear: left;
            width: 180px;
            font-weight: bold;
            color: #555;
            font-size: 13px;
        }
        dd { margin-left: 200px; margin-bottom: 8px; font-size: 14px; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        table thead tr {
            border-bottom: 2px solid #1e3a8a;
            background: #f8fafc;
        }
        table th {
            text-align: left;
            padding: 8px 6px;
            color: #1e3a8a;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        table th:last-child,
        table td:last-child { text-align: right; }
        table td {
            padding: 8px 6px;
            font-size: 13px;
            border-bottom: 1px solid #e2e8f0;
        }

        .terms {
            background: #f8fafc;
            border-left: 4px solid #fbbf24;
            padding: 16px 20px;
            font-style: italic;
            margin: 12px 0 28px;
            font-size: 14px;
        }
        .signatures {
            display: flex;
            justify-content: space-between;
            gap: 60px;
            margin-top: 70px;
        }
        .sig-box {
            flex: 1;
            border-top: 1px solid #1a1a2e;
            padding-top: 8px;
            text-align: center;
            font-size: 13px;
        }
        .sig-box strong {
            display: block;
            margin-bottom: 4px;
        }
        .footer {
            margin-top: 50px;
            font-size: 11px;
            color: #888;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            padding-top: 16px;
            font-style: italic;
        }
        @media print {
            body { margin: 0; padding: 20px; }
            .no-print { display: none; }
        }
        .no-print {
            text-align: center;
            margin-bottom: 32px;
        }
        .no-print button {
            padding: 12px 28px;
            font-size: 14px;
            cursor: pointer;
            background: #1e3a8a;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: transform .15s ease, background .15s ease;
        }
        .no-print button:hover {
            background: #172e6f;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()">🖨️ Print this contract</button>
</div>

<div class="header">
    <h1>BORROWING CONTRACT</h1>
    <small>Philippine Christian University</small>
</div>

<div class="contract-no">
    Contract No: <strong><?= htmlspecialchars($contract['contract_no']) ?></strong><br>
    Date Issued: <?= htmlspecialchars($contract['created_at']) ?>
</div>

<h2>Borrower Information</h2>
<dl>
    <dt>Full Name</dt>
    <dd><?= htmlspecialchars($contract['student_name']) ?></dd>

    <dt>Email</dt>
    <dd><?= htmlspecialchars($contract['student_email']) ?></dd>

    <?php if (!empty($contract['student_id'])): ?>
        <dt>Student ID</dt>
        <dd><?= htmlspecialchars($contract['student_id']) ?></dd>
    <?php endif; ?>
</dl>

<h2>Item Details</h2>
<table>
    <thead>
        <tr>
            <th>Item</th>
            <th>Category</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contract['items'] ?? [] as $bi): ?>
            <tr>
                <td><?= htmlspecialchars($bi['item_name'] ?? '—') ?></td>
                <td><?= htmlspecialchars($bi['category'] ?? '—') ?></td>
                <td><?= (int)($bi['quantity'] ?? 0) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Loan Schedule</h2>
<dl>
    <dt>Borrow Date</dt>
    <dd><?= htmlspecialchars($contract['borrow_date'] ?? '—') ?></dd>

    <dt>Due Date</dt>
    <dd><?= htmlspecialchars($contract['due_date'] ?? '—') ?></dd>
</dl>

<h2>Terms and Conditions</h2>
<div class="terms">
    <?= nl2br(htmlspecialchars($contract['terms'] ?? 'No terms were specified.')) ?>
</div>

<p style="font-size: 14px;">
    I, <strong><?= htmlspecialchars($contract['student_name']) ?></strong>, agree to borrow the item(s)
    listed above and to return them in the same condition on or before
    <strong><?= htmlspecialchars($contract['due_date'] ?? '') ?></strong>.
    I understand that failure to return the item(s) by the due date may result in penalties
    or suspension of borrowing privileges.
</p>

<div class="signatures">
    <div class="sig-box">
        <strong><?= htmlspecialchars($contract['student_name']) ?></strong>
        Borrower's Signature
    </div>
    <div class="sig-box">
        <strong>Administrator</strong>
        Authorized Personnel
    </div>
</div>

<div class="footer">
    This document serves as an official record of the borrowing agreement.<br>
    Philippine Christian University — PCU Borrow System
</div>

</body>
</html>