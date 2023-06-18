<!doctype html>
<html lang="en">
  <head>
    <title>Floor Movement Report</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
      .p0 {
        margin: 0!important;
        padding: 0!important;
      }

      .table-wrapper {
        overflow-x: auto;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        text-align: center; /* Center aligns the text within the table */
      }

      th, td {
        padding: 8px;
        border: 1px solid #ddd;
      }

      th {
        background-color: #f2f2f2;
      }
    </style>
  </head>
  <body>
    <div>
      <div class="container" style="margin-bottom: 18px;">
        <div style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px">
          <?php echo xin_company_info(1)->company_name; ?>
        </div>
        <div style="font-size:12px; font-weight:bold; text-align:center;height:0px;"></div>
        <div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;">
          <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?>
        </div>
        <div style="font-size:16px; line-height:15px; font-weight:bold; text-align:center;">
          Daily Floor Movement Report of <?= isset($value[0]->date) ? $value[0]->date : ''; ?>
        </div>
      </div>
      <div class="table-wrapper">
        <table class="table p0">
          <thead>
            <tr>
              <th class="p0">Sl</th>
              <th class="p0">Name</th>
              <th class="p0">Designation</th>
              <th class="p0">Out Time</th>
              <th class="p0">In Time</th>
              <th class="p0">Location</th>
              <th class="p0">Reason</th>
              <th class="p0">Date</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($values as $key => $value) { ?>
              <tr>
                <td><?= $key+1?></td>
                <td><?= $value->first_name?> <?= $value->last_name?></td>
                <td><?= $value->designation_name?></td>
                <td class="p0">
                  <table class="table p0">
                    <?php 
                    $out_time_array=json_decode($value->out_time);
                    foreach ($out_time_array as $key => $outtime) { ?>
                      <tr><td class="p0"><?= $outtime?></td></tr>
                    <?php } ?>
                  </table>
                </td>
                <td class="p0">
                  <table class="table p0">
                    <?php 
                    $in_time_array=json_decode($value->in_time);
                    foreach ($in_time_array as $key => $intime) { ?>
                      <tr><td class="p0"><?= $intime?></td></tr>
                    <?php } ?>
                  </table>
                </td>
                <td class="p0">
                  <table class="table p0">
                    <?php 
                    $location_array=json_decode($value->location);
                    foreach ($location_array as $key => $location) { ?>
                      <tr><td class="p0"><?= ($location==1) ? '5th Floor' : (($location==2) ? '3rd Floor' : 'Out Side');?></td></tr>
                    <?php } ?>
                  </table>
                </td>
                <td class="p0">
                  <table class="table p0">
                    <?php 
                    $reason_array=json_decode($value->reason);
                    foreach ($reason_array as $key => $reason) { ?>
                      <tr><td class="p0"><?= $reason?></td></tr>
                    <?php } ?>
                  </table>
                </td>
                <td><?= $value->date?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Optional JavaScript -->
  </body>
</html>
