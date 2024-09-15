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
                
                .letter-header,
                .letter-to,
                .letter-signature {
                    margin-bottom: 20px;
                }
                
                .letter-header p,
                .letter-to p,
                .letter-body p,
                .letter-signature p {
                    margin: 0;
                    padding: 5px 0;
                }
                
                .letter-subject {
                    text-align: center;
                    margin: 20px 0;
                    font-size: 1.2em;
                    text-decoration: underline;
                }
                
                .letter-body {
                    margin-bottom: 20px;
                }
                
                .letter-signature p {
                    text-align: left;
                }
                
                .letter-signature p:nth-child(2) {
                    margin-top: 20px;
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
                <p>Date: <span class="date"><?= date('F j, Y')?></span></p>
                <p>Ref: </p>
            </div>

            <div class="letter-to">
                <p>To</p>
                <p>Name: <span class="name"><?=$data->first_name.' '.$data->last_name?></span></p>
                <p>Employee ID: <span class="employee-id"><?=$data->employee_id?></span></p>
                <p>Designation: <span class="designation"><?=$data->designation_name?></span></p>
                <p>Date of Joining: <span class="joining-date"><?=$data->date_of_joining?></span></p>
                <p>Date of Increment: <span class="increment-date"><?=$increment->effective_date?></span></p>
            </div>

            <h2 class="letter-subject">Subject: Letter of Increment</h2>

            <div class="letter-body">
                <p>Dear <span class="name"><?=$data->first_name.' '.$data->last_name?></span>,</p>
                <p>
                    Congratulations!!! We would like to gladly inform you that your salary has been increased by 
                    <span class="amount"><?= $increment->old_salary?></span> taka starting from 
                    <span class="increment-month"><?= $increment->effective_date?></span>. Your new salary shall be 
                    <span class="new-salary"><?= $increment->new_salary?></span> 
                    (In word). This increase resembles recognition of your outstanding efforts. The company values your 
                    contribution and continuously looks for ways to reward loyal and hardworking employees like yourself. 
                    Congratulations and best of luck in the future.
                </p>
                <p>Thank you for your commitment and dedication. Keep up the good work.</p>
            </div>

            <div class="letter-signature">
                <p>Regards</p>
                <p>______________</p>
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