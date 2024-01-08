<?php
// dd($result)
// stdClass Object
// (
//     [leave_id] => 408
//     [company_id] => 1
//     [employee_id] => 69
//     [department_id] => 0
//     [leave_type_id] => 1
//     [leave_type] => el
//     [qty] => 3.0
//     [from_date] => 2023-12-31
//     [to_date] => 2024-01-02
//     [applied_on] => 2024-01-04 10:37:03
//     [reason] => leave for family issues (Stepmother died)
//     [remarks] => 
//     [status] => 1
//     [is_half_day] => 0
//     [notify_leave] => 0
//     [leave_attachment] => 
//     [team_lead_approved] => 0
//     [team_lead_comment] => 
//     [created_at] => 2024-01-04 10:37:03
//     [current_year] => 2024
//     [first_name] => Md. Shahajahan
//     [last_name] => Ali
//     [basic_salary] => 33000
//     [type_name] => Earn leave
//     [department_name] => Technical Team
//     [designation_name] => Software Engineer
// )
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Leave Form</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
    <style>
        * {
            font-size: 14px;
        }
      .navebar {
        display: flex;
        flex-direction: column;
        border-bottom: 2px solid black;
        padding-bottom: 3px;
      }
      .logo {
        display: flex;
        justify-content: start;
      }
      .title {
        display: flex;
        justify-content: center;
        font-weight: bold;
      }
      .bold {
        font-weight: bold !important;
      }
      p {
        line-height: 50%;
      }
      .massage_content {
        margin-top: 11px;
      }
      .namefiled {
        font-weight: 300;
        border-bottom: 1px dashed black;
      }
      .unbold {
        font-weight: normal;
      }
      .box_head_t {
      }
      .box_head {
        border: 1px solid black;
        width: fit-content;
        padding: 4px;
        font-weight: bold;
      }
      .madale_content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 8px;
      }
      .bottom_content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 8px;
      }
      .sub_madale_content{
        display: flex;
      }
    th,td {
        text-align: center;
        }
        body {
            margin: 0px 17%;
        }
        @media print {
          body {
            margin: 0px 5%;
        }
        .print_btn {
            display: none;
        }

        }
       
    </style>
  </head>
  <body>
    <br>
    <br>
    <a class="btn btn-sm btn-primary print_btn" onclick="window.print()" style="position: absolute;right: 0;top: 0;">Print</a>
    <div class="navebar">
      <div class="logo">
        <img
          src="http://parliament-document.mysoftheaven.com/assets/image/mysoftheaven.png"
          alt=""
        />
      </div>
      <div class="title">
        <span class="title">LEAVE APPLICATION FORM</span>
      </div>
    </div>
    <div class="massage_content">
      <div class="top_massage">
        <p>From,</p>
        <p class="bold">
          Employee's Name : <span class="namefiled"><?=$result->first_name.' '.$result->last_name?></span>
        </p>
        <p class="bold">
          Designation : <span class="namefiled"><?=$result->designation_name?></span>
        </p>
        <p class="bold">
          Application Date : <span class="namefiled"><?=$result->applied_on?></span>
        </p>
      </div>
      <div class="bottom_massage">
        <p>To,</p>
        <p>The Director</p>
        <p class="bold">Mysoftheaven (BD) Ltd.</p>
        <p class="bold">
          Subject : <span class="namefiled">Permission for leave</span>
        </p>
        <p class="bold">Dear Madam,</p>
        <strong class="unbold"
          >I am requesting that the following leave be granted. I will report
          for work on<span class="namefiled bold"> <?php echo $result->from_date; ?> </span> I will
          hand over my duties and responsibilities to
          <span class="namefiled bold">...............</span> For the duration
          of my leave period my contact details would be
          <span class="namefiled bold"><?=$result->contact_no?></span></strong
        >
      </div>
    </div>
    <div class="madale_content">
      <div class="box_head">
        <span class="box_head_t">PERIOD OF LEAVE APPLICATION</span>
      </div>
      <div class="table_box col-md-12">
        <table class="table table-bordered">
          <tr>
            <th>Start Date</th>
            <th>End Date</th>
            <th>No of Day</th>
            <th>Leave Type</th>
            <th>Reasons</th>
          </tr>
          <tr>
            <td><?php echo $result->from_date; ?></td>
            <td><?php echo $result->to_date; ?></td>
            <td><?php echo $result->qty; ?></td>
            <td><?php echo $result->type_name; ?></td>
            <td><?php echo $result->reason; ?></td>
          </tr>
        </table>
      </div>
      <p class="unbold col-md-12">I request you to kindly approve my leave at the earliest and oblige.</p>
    </div>

    <div class="sub_madale_content col-md-12">
        <div class="col-md-6">
            <strong class="bold"> Your Sincerely,</strong><br>
            <strong class="namefiled bold"><?= $result->first_name.' '.$result->last_name ?></strong><br>
            <strong class="namefiled bold"><?=$result->applied_on?></strong>

        </div>
        <div class="col-md-6 table_box">
            <table class="table table-bordered">
                <tr><th>Team Leader Comment <?= ($result->team_lead_approved==1)?'<span class="namefiled bold text-success"> Approved':'<span class="namefiled bold text-danger"> Pending'?></span></th></tr>
                <tr> <td> <?= $result->team_lead_comment?>  </td></tr>
            </table>
        </div>
      
    </div>
    <div class="bottom_content">
        <div class="box_head ">
            <span class="box_head_t">For Office Use Only</span>
          </div>
        <strong class="col-md-12">Received by : <span class="namefiled unbold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></strong>
        <table class="table table-bordered col-md-12">
            <tr>
                <th colspan="4">Previous Leave Record</th>
            </tr>
            <tr>
                <th>Type of Leave</th>
                <th>Days</th>
                <th>Obtained Leave</th>
                <th>Remaining Leave</th>
            </tr>
            <tr>
                <th>Earn Leave</th>
                <td>12</td>
                <td><?=$leave_calel?></td>
                <td><?=(12-$leave_calel)?></td>
            </tr>
            <tr>
                <th>Sick Leave</th>
                <td>4</td>
                <td><?= $leave_calsl?></td>
                <td><?=(4-$leave_calsl)?></td>
            </tr>
            <tr>
                <th>Total Leave</th>
                <td>16</td>
                <td><?= ($leave_calel+$leave_calsl) ?></td>
                <td><?=16-($leave_calel+$leave_calsl)?></td>
        </table>
        <div class="sub_madale_content col-md-12">
            <div class="col-md-6 text-left">
                <strong class="bold"> Employee Info,</strong><br>
                <strong class="namefiled bold">Joining Date : <span class="namefiled unbold"><?= $result->date_of_joining ?></span> </strong>
    
            </div>
            <div class="col-md-6 text-right">
                <strong class="bold">Management Approval </strong><br>
                <strong class="namefiled bold">Approved</strong>
            </div>
          
        </div>
        <div class="sub_madale_content col-md-12">
            <div class="col-md-6 pull-left text-left">
                <strong class="bold"> Attachment</strong><br>
                <strong class="namefiled bold">No</strong>
    
            </div>
            <div class="col-md-6 text-right">
                <strong class="bold">...................</strong><br>
                <strong class="bold">Authorized Signature</strong>
            </div>
          
        </div>

    </div>


    <script
      src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
      integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
      integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
<!-- Mysoftheaven (BD) Ltd. A Complete IT Solution
LEAVE APPLICATION FORM
From,
Employee's Name:
Designation:
Application Date: /2023
To
The Director
Mysoftheaven (BD) Ltd.
Subject: Permission for leave.
Dear Madam,
I am requesting that the following leave be granted. I will report for work on my duties and responsibilities to I will hand over For the duration of my leave period my contact details
would be
PERIOD OF LEAVE APPLICATION
Start Date
End Date
No of Day
Leave Pattern
Earn
Sick
Reasons
Day Name
I request you to kindly approve my leave at the earliest and oblige.
Team leader Comments
Yours Sincerely,
FOR OFFICE USE ONLY
Received By
Previous Leave Record
Date:.......... /2023
Type of Leave
Days
Obtained Leave
Current Balance
Earned Leave
Sick Leave
Total Leave
12
04
16
Employee Info.
Joining Date:
Management Approval
Approved (with Pay).
Approved (without Pay).
Rejected.
*In Case of Sick Leave, a valid medical certificate must be attached.
Authorized Signature -->
