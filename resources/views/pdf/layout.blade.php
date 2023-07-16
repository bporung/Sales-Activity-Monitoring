<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        @page {
                margin-top: 5cm;
                margin-bottom: 3cm;
        }

        .tableHeader , .tableHeader td {
            border:none !important ;
            border-collapse:collapse;
            outline: none !important;
            border-style: none;
        }
        header {
                position: fixed;
                top: -4cm;
                left: 0px;
                right: 0px;
                height: 450px;

            }
        footer {
            position: fixed; 
            bottom: -2cm; 
            left: 0px; 
            right: 0px;

        }
        .page-break {
            page-break-after: always;
        }
        .tableListData{
            width:100%;
        }
        .tableListData , .tableListData th , .tableListData td{
            border:1px solid black ;
            border-collapse:collapse;
        }
        .tableListData th , .tableListData td{
            padding:5px;
        }
        .tableListData td p{
            padding:0px; margin:0px;
        }
        .tableListData td{
            vertical-align:top;
        }

        .text-left{text-align:left;}
        .text-right{text-align:right;}
        .text-center{text-align:center;}
        .text-justify{text-align:justify;}
        .font-bold{font-weight:bold;}
        .font-semibold{font-weight:300;}
        .text-xs{font-size:12px;}
        .text-sm{font-size:14px;}
        .text-md{font-size:16px;}
        .text-lg{font-size:18px;}

    </style>
</head>
<body>
    <header>
        <table class="tableHeader"> 
            <tr>
                <td>
                    <img src="{{public_path('/img/logo.png')}}" style="width:200px;">
                </td>
                <td>
                    <div style="padding-left:10px;">
                        <h3 style="padding:0; margin:0; margin-bottom:5px;" >Company Name</h3>
                        <p style="padding:0; margin:0;">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
                    </div>
                </td>
            </tr>
        </table>
        <hr>
    </header>
    <footer>
        <hr>
        <p style="text-align:right;">This document is printed from authorized system.</p>
    </footer>

    <!-- SECTION CONTENT -->
    <div>
        @yield('content')
    </div>
    <!-- SECTION CONTENT -->

</body>
</html>