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
        .letter-signature,
        .letter-footer {
            margin-bottom: 20px;
        }
        
        .letter-header p,
        .letter-to p,
        .letter-body p,
        .letter-signature p,
        .letter-footer p {
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
        
        .letter-footer {
            font-size: 0.9em;
            line-height: 1.4;
            color: #555;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
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
            <p>Ref: MHL/Emp/2023/124</p>
            <p>Date: <?= date('d/m/Y')?></p>
        </div>

        <div class="letter-to">
            <p><strong><?= $data->first_name.' '.$data->last_name?></strong></p>
            <?php

            $old_desi= $promotion->old_desig_id;
            $old_dept= $promotion->old_dept_id;
            $this->load->model('Xin_model');
            $old_desi_name= $this->Xin_model->read_designation_info($old_desi);
            $old_dept_name= $this->Xin_model->read_department_info($old_dept);
            
            
            ?>
            <p>Designation: <?= $old_desi_name[0]->designation_name?></p>
            <p>Department: <?= $old_dept_name[0]->department_name?></p>
            <p>Employee ID: <?= $data->employee_id?></p>
        </div>

        <h2 class="letter-subject">Subject: Promotion Letter</h2>

        <div class="letter-body">
            <p>Dear <?= $data->first_name .' '.$data->last_name?>,</p>
            <p>
                We are pleased to inform you that the management is happy with your 
                performance and has decided to promote you to 
                the post of <?= $promotion->designation_name?> with effect from <?= $promotion->effective_date?> as a reward for your sincerity and dedication towards work.
            </p>
            <p>
                We hope this recognition will inspire you to devote yourself more for the benefit and development of the company in the future. Congratulations!
            </p>
            <p>Thanking you,</p>
        </div>

        <div class="letter-signature">
            <p>Ummay Sharmin</p>
            <p>Director</p>
            <p>Mysoft Heaven (BD) Ltd.</p>
        </div>

        <div class="letter-footer">
            <div>
                <p>Head Office:</p>
                <p>Raisa & Shikder Tower, Level-03 & 05</p>
                <p>3/8, North Pirerbag, Kafrul Soroni Rd</p>
                <p>Mirpur, Dhaka-1216.</p>
                <p>Tel: 02-41001094</p>
                <p>Cell: 01958633202, 01958633200</p>
                <p>Email: info@mysoftheaven.com</p>
            </div>
            <div>
                <p>Corporate Office:</p>
                <p>8813 NW 23 Street.</p>
                <p>Miami, FL 33172, USA</p>
                <p>Toll Free: 1.877.397.6735</p>
                <p>Tel: 305.436.9127</p>
                <p>Email: usa@mysoftheaven.com</p>
                <p>Website: www.mysoftheaven.com</p>
            </div>
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