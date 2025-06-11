 <!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <title>ใบขออนุญาตใช้รถยนต์ราชการ</title>
        <style>
                @font-face {
                font-family: 'thsarabunnew';
                src: url('{{ public_path("fonts/THSarabunNew.ttf") }}') format('truetype');
                font-weight: normal;
                font-style: normal;
                }

                @font-face {
            font-family: 'thsarabunnew';
            src: url('{{ public_path("fonts/THSarabunNew Bold.ttf") }}') format('truetype');
            ont-weight: bold;
            font-style: normal;
    }

            body {
                font-family: 'thsarabunnew', 'Sarabun', 'Angsana New', 'Tahoma', sans-serif;
                font-weight: 400;
                font-size: 19px; /* ปรับให้ใกล้เคียงกับ TH Sarabun */
                line-height: 1.2;
                padding: 20px;
                color: #000000;
            }

            * {
                unicode-bidi: embed;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            .center {
                text-align: center;
                margin-bottom: 20px;
            }

            .right {
                text-align: right;
                margin-bottom: 20px;
            }

            .section {
                margin-top: 1em;
                margin-bottom: 1em;
            }

    .underline {
            display: inline-block;
            border-bottom: 1px dotted #000;
            padding: 0 5px;
            text-align: center;
            height: 1.5em;
            min-width: 100px; /* ความยาวขั้นต่ำ */
        }
        
        /* คลาสสำหรับความยาวต่างๆ */
        .underline-sm { min-width: 80px; } /* สำหรับชื่อ */
        .underline-md { min-width: 150px; } /* สำหรับตำแหน่ง/จังหวัด */
        .underline-lg { min-width: 250px; } /* สำหรับสถานที่ปฏิบัติราชการ */
        .underline-date { min-width: 100px; } /* สำหรับวันที่ */
        .underline-time { min-width: 60px; } /* สำหรับเวลา */
        .underline-car { min-width: 120px; } /* สำหรับทะเบียนรถ */

            .signature {
                margin-top: 2em;
                margin-bottom: 1em;
            }

            .title {
                font-size: 30px;
                font-weight: bold;
                font-weight: 700;
                margin-bottom: 10px;
                color: #000000;
            }

            .dotted-line {
                border-bottom: 1px dotted #000;
                margin: 10px 0;
            }

            .signature-line {
                display: inline-block;
                width: 200px;
                border-bottom: 1px dotted #000;
                margin-top: 30px;
            }

            .footer {
                margin-top: 30px;
                font-size: 14px;
            }

            .text-wrap {
                white-space: normal !important;
            }

            h4, h5 {
                font-weight: 700;
                color: #000000;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                padding: 8px;
                /*border: 1px solid #ddd;*/ 
            }

            th {
                background-color: #f8f9fa;
                font-weight: 500;
            }

            .btn {
                padding: 8px 16px;
                border-radius: 4px;
                font-weight: 500;
            }

            .btn-success {
                background-color: #28a745;
                color: white;
                border: none;
            }

            .btn-secondary {
                background-color: #6c757d;
                color: white;
                border: none;
            }


            


        </style>
    </head>
    <body>
        <!-- แก้ไขส่วนนี้โดยเพิ่ม class title -->
        <div class="center title">
            <div>ใบขออนุญาตใช้รถยนต์ราชการ</div>
            <div>ศูนย์อนามัยที่ 8 อุดรธานี</div>
        </div>

        <div class="right">
            วันที่ <span class="underline">{{ \Carbon\Carbon::now()->addYears(543)->format('d/m/Y') }}</span>
        </div>

        <div class="section">
            เรียน ผู้อำนวยการศูนย์อนามัยที่ 8 อุดรธานี
        </div>

    <div class="section" 
      style="white-space: nowrap;">
        ข้าพเจ้า <span class="underline">{{ $request->name }}</span>
        ตำแหน่ง <span class="underline">{{ $request->position }}</span>
        ขออนุญาตใช้รถยนต์ราชการไปปฏิบัติราชการ ณ<span class="underline">{{ $request->destination }}</span><br>
        จังหวัด <span class="underline">{{ $request->province }}</span>
        จำนวน <span class="underline">{{ $request->seats }}</span> คน
    <div>
ตั้งแต่วันที่ 
<span class="underline underline-date">{{ \Carbon\Carbon::parse($request->start_time)->addYears(543)->format('d/m/Y') }}</span>
เวลา 
<span class="underline underline-time">{{ \Carbon\Carbon::parse($request->start_time)->format('H:i') }}</span>
<span>น.</span> ถึงวันที่ 
<span class="underline underline-date">{{ \Carbon\Carbon::parse($request->end_time)->addYears(543)->format('d/m/Y') }}</span>
เวลา 
<span class="underline underline-time">{{ \Carbon\Carbon::parse($request->end_time)->format('H:i') }}</span>
<span>น.</span>


    </div>



    <div class="section" style="white-space: nowrap;">
        ลงชื่อ <span class="underline" style="min-width: 150px;">{{ $request->name }}</span>
        ผู้ขออนุญาต 
        ลงชื่อ <span class="underline" style="min-width: 150px;"></span>
        หัวหน้ากลุ่มงาน/ฝ่าย/ผู้ที่ได้รับมอบหมาย
    </div>



        <div class="section">
            อนุญาตให้<span class="underline">{{ $request->driver}}</span><span>พนักงานขับรถยนต์เป็นผู้ขับขี่ไปราชการดังกล่าว</span>
            <span>โดยใช้รถยนต์ราชการคันหมายเลขทะเบียน</span><span class="underline">{{ $request->car_registration}}</span>
        </div>

        <div class="section" style="margin-top: 40px;">
        <table style="width: 100%; text-align: center;">
            <tr>
                <td>
                    ลงชื่อ....................................................<br>
                    (<u><span class="underline"></u>)<br>
                    ผู้จัดรถ
                </td>
                <td>
                    ลงชื่อ....................................................<br>
                    (<u><span class="underline"></u>)<br>
                    ผู้อนุญาต/ผู้ที่ได้รับมอบหมาย<br>
                    
                </td>
            </tr>
            <tr>
                <td>
                    ลงชื่อ....................................................<br>
                    (<span class="underline">{{ $request->driver }}</span>)
                    <br>พนักงานขับรถยนต์
                </td>
                <td>
                </td>
            </tr>
        </table>
    </div>

        <div class="section">
            <strong>หมายเหตุ:</strong><br>
            1. การขอใช้รถยนต์ต้องเสนอให้ผู้มีอำนาจลงนามล่วงหน้าอย่างน้อย 1 วัน ยกเว้นกรณีเร่งด่วน<br>
            2. หากมีการเปลี่ยนแปลงกำหนดการเดินทาง เช่น เวลา หรือยกเลิก กรุณาแจ้งให้ทราบล่วงหน้า<br>
            3. หากพนักงานขับรถไม่ปฏิบัติงาน หรือประพฤติตัวไม่เหมาะสม ขอให้รายงานเป็นลายลักษณ์อักษร
        </div>

        <div class="section right footer">
            เลขบันทึก: <span class="underline">{{ $request->reference_number }}</span><br>
            เลขใบเสร็จ: <span class="underline">{{ $request->receipt_number}}</span>
        </div>

    </body>
    </html>