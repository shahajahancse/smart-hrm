<div id="content">
    <html lang="en">
    <head>
        <title>confirmation_letter</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <style>
            #loading {
                visibility: visible;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 3;
                /* set z-index higher than other elements */
                background-color: rgba(255, 255, 255, 0.8);
                /* semi-transparent background */
            }
            #loading img {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        </style>

        <style>
          body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
           
            padding: 20px;
        }
        
        .letter-container {
            padding: 20px;
            max-width: 700px;
            margin: auto;
        }

        .letter-header {
            display: flex;
            justify-content: space-between;
        }
        .letter-header, .recipient-info, .letter-footer {
            margin-bottom: 20px;
        }
        
        .letter-header p, .recipient-info p {
            margin: 5px 0;
        }
        
        .letter-body p {
            margin: 10px 0;
        }
        
        .letter-footer p {
            margin: 5px 0;
        }
        
        h2 {
            text-decoration: underline;
        }
        </style>
    </head>

    <body>
        <button id="download" onclick="downloadDoc()">Download as DOCX</button>

        <div id="loading">
            <img src="<?php echo base_url()?>skin/hrsale_assets/img/loding.gif">
        </div>


        <div>
        <div class="letter-container">
        <div class="letter-header">
            <p>Date: <?= date('d-m-Y') ?></p>
            <p>Ref: MHL/HR./L/24/085</p>
        </div>

        <div class="recipient-info">
            <p><strong>Name</strong>: <?= $data->first_name.' '.$data->last_name ?></p>
            <p><strong>Employee ID</strong>: <?= $data->employee_id ?></p>
            <p><strong>Designation</strong>: <?= $data->designation_name ?></p>
            <p><strong>Address</strong>: <?= $data->address ?>.</p>
        </div>

        <h2>Subject: Job Confirmation & Increment Letter</h2>

        <div class="letter-body">
            <p>Dear <?= $data->first_name.' '.$data->last_name ?>,</p>
            <p>This has reference to your letter of Appointment Ref: MHL/Emp./23/205 dated <?=$data->date_of_joining?>, appointing you as “<?= $data->designation_name ?>” from <?= $increment->effective_date ?>.</p>
            <p>In the meantime, we have reviewed your performance during the probation period from <?= $data->date_of_joining ?> to <?= $increment->effective_date ?> and found it to be satisfactory. We are pleased to inform you that your employment is confirmed in your current position, and your salary has been increased by <?= $increment->new_salary-$increment->old_salary ?> Taka, effective from <?= date('d-m-Y', strtotime($increment->effective_date . ' + 1 day')) ?> to <?= $increment->end_date ?>. Your new salary will be of <?= $increment->new_salary ?> Taka.</p>
            <p>All other terms and conditions as mentioned in your appointment letter will remain unchanged.</p>
            <p>We are happy to have you as an integral part of our company and hope this recognition will inspire you to contribute more to the company's development in the future.</p>
            <p>Please sign the duplicate copy of this letter as a token of acceptance of the same.</p>
        </div>

        <div class="letter-footer">
            <p>Sincerely,</p>
            <br><br>
            <p>_____________</p>
            <p>Ummay Sharmin</p>
            <p>Director</p>
            <p>Mysoft Heaven (BD) Ltd.</p>
        </div>
    </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
        </script>
        <script>
        $(document).ready(function() {
            $("#loading").hide();
        });
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
        <script src="https://unpkg.com/html-docx-js/dist/html-docx.js"></script>
        <script>
        function downloadDoc() {
            if ($('#download').remove()) {
                var content = document.getElementById('content').innerHTML;
                var fullContent = content;
                var docx = htmlDocx.asBlob(fullContent, {
                    pageMargins: {
                        top: 1440,    // 1 inch margin in twips
                        right: 1440,  // 1 inch margin in twips
                        bottom: 1440, // 1 inch margin in twips
                        left: 1440,   // 1 inch margin in twips
                    },
                    pageOrientation: 'portrait',
                    pageSize: 'A4'
                });
                saveAs(docx, 'page.docx');
            }
        }
        </script>
    </body>

    </html>


</div>