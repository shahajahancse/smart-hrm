<!DOCTYPE html>
<html lang="en">

<head>
  <title>Payslip</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap Icons CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f3f4f6;
      color: #374151;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 750px;
      background: #ffffff;
      margin: auto;
      padding: 25px 30px;
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.07);
    }

    .company-info {
      text-align: center;
      margin-bottom: 25px;
      border-bottom: 2px dashed #1652f9ff;
      padding-bottom: 12px;
    }

    .company-info h2 {
      margin: 0;
      font-size: 22px;
      color: #1652f9ff;
    }

    .company-info small {
      color: #6b7280;
      font-size: 13px;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .header h3 {
      margin: 0;
      font-size: 20px;
    }

    .header span {
      font-size: 14px;
      color: #6b7280;
    }

    .info-row {
      display: flex;
      justify-content: space-between;
      margin: 8px 0;
      font-size: 14px;
    }

    .info-label {
      font-weight: 600;
      color: #444;
    }

    .info-value {
      flex: 1;
      text-align: right;
    }

    .section-title {
      margin: 20px 0 10px;
      font-weight: 600;
      font-size: 15px;
      display: flex;
      align-items: center;
      color: #1652f9ff;
    }

    .section-title i {
      margin-right: 8px;
      font-size: 16px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
      margin-bottom: 10px;
    }

    th,
    td {
      border: 1px solid #e5e7eb;
      padding: 6px 8px;
      text-align: center;
    }

    th {
      background-color: #f9fafb;
      color: #111827;
      font-weight: 600;
    }

    .net-pay {
      text-align: right;
      margin-top: 20px;
      font-weight: bold;
      font-size: 18px;
      color: #1652f9ff;
    }

    .btn-print {
      display: inline-block;
      margin-top: 15px;
      background-color: #1652f9ff;
      color: white;
      padding: 8px 16px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-size: 14px;
    }

    .btn-print i {
      margin-right: 5px;
    }

    @media print {
      .btn-print {
        display: none;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Company Info -->
    <div class="company-info">
      <h2><i class="bi bi-buildings"></i>Mysoft Heaven (BD) Ltd</h2>
      <small><i class="bi bi-geo-alt"></i>Shapla House 363/H/2 North Pirerbag, Raisa & Shikder Tower, Level-5, 3/8, Kamal Soroni, Mirpur, Dhaka-1207 </small><br>
      <small><i class="bi bi-telephone"></i> +880-123456789</small><br>
      <small><i class="bi bi-envelope"></i> info@abc.com</small>
    </div>

    <!-- Payslip Header -->
    <div class="header">
      <h3><i class="bi bi-receipt-cutoff"></i> Employee Payslip</h3>
      <span>For the month of <?= $salary_month ?></span>
    </div>

    <!-- Employee Info -->
    <div class="info-row">
      <span class="info-label"><i class="bi bi-person-badge"></i> EMP ID:</span>
      <span class="info-value"><?= $values[0]->employee_id ?></span>
    </div>
    <div class="info-row">
      <span class="info-label"><i class="bi bi-person"></i> Name:</span>
      <span class="info-value"><?= $values[0]->first_name ?> <?= $values[0]->last_name ?></span>
    </div>
    <div class="info-row">
      <span class="info-label"><i class="bi bi-award"></i> Designation:</span>
      <span class="info-value"><?= $values[0]->designation_name ?></span>
    </div>
    <div class="info-row">
      <span class="info-label"><i class="bi bi-credit-card-2-front"></i> Account No:</span>
      <span class="info-value"><?= $values[0]->account_number ?></span>
    </div>

    <!-- Working Status -->
    <div class="section-title"><i class="bi bi-calendar-check"></i> Working Status</div>
    <table>
      <thead>
        <tr>
          <th>Status</th>
          <th>Days</th>
          <th>Status</th>
          <th>Days</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Present</td>
          <td><?= $values[0]->present ?></td>
          <td>Earn Leave</td>
          <td><?= $values[0]->earn_leave ?></td>
        </tr>
        <tr>
          <td>Absent</td>
          <td><?= $values[0]->absent ?></td>
          <td>Sick Leave</td>
          <td><?= $values[0]->sick_leave ?></td>
        </tr>
        <tr>
          <td>Holiday</td>
          <td><?= $values[0]->holiday ?></td>
          <td>Weekend</td>
          <td><?= $values[0]->weekend ?></td>
        </tr>
        <tr>
          <td>Extra Present</td>
          <td><?= $values[0]->extra_p ?></td>
          <td colspan="2"></td>
        </tr>
      </tbody>
    </table>

    <!-- Pay Summary -->
    <div class="section-title"><i class="bi bi-wallet2"></i> Pay Summary</div>
    <table>
      <thead>
        <tr>
          <th>Earnings</th>
          <th>Amount</th>
          <th>Deductions</th>
          <th>Amount</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Basic Salary</td>
          <td><?= $values[0]->basic_salary ?></td>
          <td>Late Deduction</td>
          <td><?= $values[0]->late_deduct ?></td>
        </tr>
        <tr>
          <td>Modified Salary</td>
          <td><?= $values[0]->modify_salary ?></td>
          <td>Absent Deduction</td>
          <td><?= $values[0]->absent_deduct ?></td>
        </tr>
        <tr>
          <td>Extra Pay</td>
          <td><?= $values[0]->extra_pay ?></td>
          <td>Lunch Deduction</td>
          <td><?= $values[0]->lunch_deduct ?></td>
        </tr>
      </tbody>
    </table>

    <!-- Net Pay -->
    <div class="net-pay">
      Net Pay: <?= ($values[0]->grand_net_salary) + ($values[0]->modify_salary) ?>
    </div>

    <!-- Print Button -->
    <button class="btn-print" onclick="window.print()"><i class="bi bi-printer"></i> Print Payslip</button>
  </div>
</body>

</html>
