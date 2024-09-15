<div id="content">
    <html lang="en">
    <head>
        <title>Joining Letter</title>
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
            margin: 2px 0;
            text-align: left;
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
            <p>Date: <?= date('d-m-Y')?></p>
            <p>Ref: MHL/DGT/L/24/286</p>
        </div>

        <div class="recipient-info">
            <p>To,</p>
            <p><strong>Name:</strong><?= $data->first_name.' '.$data->last_name?></p>
            <p><strong>Address:</strong> <?= $data->address?></p>
        </div>

        <h2>Letter of Appointment</h2>

        <div class="letter-body">
            <p><strong>Dear</strong> <?= $data->first_name.' '.$data->last_name?>,</p>
            <p><strong>Congratulations!!!</strong></p>
            <p>Greetings from <strong>Mysoft Heaven (BD) Ltd</strong> Family. With reference to our interview meetings, we are pleased to appoint you as a <strong>“<?= $data->designation_name?>”</strong> in the company effective from
            <strong><?= date('d-m-Y', strtotime($data->joining_date))?></strong>. The appointment is guided and governed by the company rules, 
            recruitment policies, and the employee-employer agreement and HR Policy attached. 
            Your consolidated salary will be of </strong>TK. <?= $data->salary?> </strong> per month. The first .... months of your employment will be considered probationary. During the probation period, a progress check will be kept and during this period a full appraisal of your performance will be made. The company will consider the next increment(s) every year on the basis of your performance, dedication, sincerity, and outcomes.</p>
            <p>We welcome you to our company and trust that our employment will be mutually satisfying.</p>
        </div>

        <div class="letter-footer">
            <p><strong>Regards,</strong></p>
            <br><br>
            <p>_____________</p>
            <p>Ummay Sharmin</p>
            <p><strong>Director</strong></p>
            <p><strong>Mysoft Heaven (BD) Ltd.</strong></p>
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