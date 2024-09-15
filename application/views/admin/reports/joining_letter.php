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
                font-size: 20px;
                padding: 10px;
            }

            .letter-container {
                padding: 20px;
                max-width: 900px;
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

            .letter-body ul {
                list-style-type: disc;
                margin-left: 20px;
            }

            .letter-body ul li {
                margin-bottom: 5px;
            }

            .letter-signature p {
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
                <div class="letter-header"  style="line-height: normal;">
                    <p><?= date('F j, Y')?></p>
                </div>

                <div class="letter-to" style="line-height: normal;">
                    <p>To</p>
                    <p><strong><?= $data->first_name.' '.$data->last_name?></strong></p>
                    <p><?= $data->address?></p>
                    <p>Mobile: <?= $data->contact_no?></p>
                    <p>E-mail: <?= $data->email?></p>
                </div>

                <h2 class="letter-subject">Subject: Letter of Job Offer</h2>

                <div class="letter-body">
                    <p>Dear <?= $data->first_name.' '.$data->last_name?>,</p>
                    <p style="line-height: normal;">
                        With reference to your interview & your willingness to join our company, we are pleased to offer
                        you an appointment as <strong> "<?= $data->designation_name?>" </strong> in Mysoft Heaven (BD) Ltd.
                        with effect from <strong><?= date('F j, Y', strtotime($data->date_of_joining))?></strong>.
                        As per the discussion, salary will be paid. The Letter of Appointment will be issued soon.
                    </p>
                    <p>
                        Please bring the following papers on the date of joining:
                    </p>
                    <ul style="line-height: normal;">
                        <li>Original copy of all academic certificates.</li>
                        <li>Release Letter / Letter of acceptance of resignation in the company letterhead from the previous
                            employer.</li>
                        <li>Experience Certificates.</li>
                        <li>Passport size Photographs - 04.</li>
                        <li>Photo of nominee - 02.</li>
                        <li>Photocopy of National ID.</li>
                        <li>Photocopy of National ID of Nominee.</li>
                    </ul>
                    <p>
                        While welcoming you to Mysoft Heaven (BD) Ltd, we are confident that you will contribute to the
                        organization
                        and pursue its values of “ASPIRE TOWARDS GROWTH”!
                    </p>
                    <p>
                        Please confirm your acceptance of this offer by signing and returning this letter by mail within two
                        working days.
                    </p>
                    <p>Thanking You,</p>
                </div>
                <br><br>
                <div class="letter-signature">
                    <p>Md. Taslim Khan</p>
                    <p>Manager (Admin & Accounts)</p>
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