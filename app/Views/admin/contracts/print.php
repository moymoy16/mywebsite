<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contract <?= htmlspecialchars($contract['contract_no']) ?></title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Georgia', serif;
            color: #222;
            max-width: 800px;
            margin: 40px auto;
            padding: 40px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #222;
            padding-bottom: 16px;
            margin-bottom: 32px;
        }
        .header h1 {
            font-size: 24px;
            letter-spacing: 2px;
            margin: 0;
        }
        .header small {
            color: #666;
        }
        .contract-no {
            text-align: right;
            font-size: 12px;
            color: #666;
            margin-bottom: 24px;
        }
        h2 {
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 28px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 6px;
        }
        dl { margin: 0; }
        dt { float: left; clear: left; width: 180px; font-weight: bold; color: #555; }
        dd { margin-left: 200px; margin-bottom: 8px; }
        .terms {
            background: #f7f7f7;
            border-left: 3px solid #444;
            padding: 16px 20px;
            font-style: italic;
            margin: 12px 0 28px;
        }
        .signatures {
            display: flex;
            justify-content: space-between;
            gap: 40px;
            margin-top: 60px;
        }
        .sig-box {
            flex: 1;
            border-top: 1px solid #222;
            padding-top: 8px;
            text-align: center;
            font-size: 13px;
        }
        .footer {
            margin-top: 40px;
            font-size: 11px;
            color: #888;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 12px;
        }
        @media print {
            body { margin: 0; padding: 20px; }
            .no-print { display: none; }
        }
        .no-print {
            text-align: center;
            margin-bottom: 24px;
        }
        .no-print button {
            padding: 10px 24px;
            font-size: 14px;
            cursor: pointer;
            background: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()">🖨️ Print this contract</button>
</div>

<div class="header">
    <h1>BORROWING CONTRACT</h1>
    <small>Item Loan Agreement</small>
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
<dl>
    <dt>Item Name</dt>
    <dd><?= htmlspecialchars($contract['item_name']) ?></dd>

    <dt>Category</dt>
    <dd><?= htmlspecialchars($contract['category']) ?></dd>

    <dt>Quantity</dt>
    <dd><?= (int)$contract['quantity'] ?> unit(s)</dd>
</dl>

<h2>Loan Schedule</h2>
<dl>
    <dt>Borrow Date</dt>
    <dd><?= htmlspecialchars($contract['borrow_date']) ?></dd>

    <dt>Due Date</dt>
    <dd><?= htmlspecialchars($contract['due_date']) ?></dd>
</dl>

<h2>Terms and Conditions</h2>
<div class="terms">
    <?= nl2br(htmlspecialchars($contract['terms'])) ?>
</div>

<p>
    I, <strong><?= htmlspecialchars($contract['student_name']) ?></strong>, agree to borrow the item
    listed above and to return it in the same condition on or before
    <strong><?= htmlspecialchars($contract['due_date']) ?></strong>.
    I understand that failure to return the item by the due date may result in penalties
    or suspension of borrowing privileges.
</p>

<div class="signatures">
    <div class="sig-box">
        <strong><?= htmlspecialchars($contract['student_name']) ?></strong><br>
        Borrower's Signature
    </div>
    <div class="sig-box">
        <strong>Administrator</strong><br>
        Authorized Personnel
    </div>
</div>

<div class="footer">
    This document serves as an official record of the borrowing agreement.
</div>

</body>
</html>