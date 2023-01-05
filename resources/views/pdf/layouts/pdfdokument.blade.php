<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>PDF-Dokument</title>

    <!-- Styles -->
    <style>
        body {
            font-family: "Verdana", sans-serif;
            font-size: 12px;
            background-color: #fff;
            color: black;
            padding: 30px 20px 50px 30px;
        }

        h1 {
            font-size: 18px;
            font-weight: bolder;
        }

        h2 {
            font-size: 16px;
            font-weight: bolder;
        }

        h3 {
            font-size: 15px;
            font-weight: bolder;
        }

        h4 {
            font-size: 14px;
            font-weight: bolder;
        }

        h5 {
            font-size: 13px;
            font-weight: bolder;
        }

        h6 {
            font-size: 12px;
            font-weight: bolder;
        }

        #header,
        #footer {
            width: 100%;
            text-align: center;
            position: fixed;
        }

        #header {
            top: 0px;
        }

        #footer {
            bottom: -20px;
            height: 80px;
        }

        #footer .pagenum:after {
            content: counter(page, decimal);
        }

        .footer--border {
            border-top: 1px solid #696969;
            margin-top: 12px;
        }

        .footer--info {
            margin-top: 8px;
            font-size: 9px;
        }

        .title {
            font-size: 18px;
            font-weight: bolder;
            margin-top: 12px;
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 15px;
            font-weight: bold;
            margin-top: 6px;
            margin-bottom: 6px;
        }

        .info {
            margin-top: 4px;
        }

        .image-center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
            margin-bottom: 12px;
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
            padding: 0;
            margin: 0;
            width: 100%
        }

        thead th {
            margin: 2px 4px 2px 4px;
            font-weight: bold;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #fff;
        }

        tbody td {
            margin: 2px 4px 2px 4px;
            vertical-align: middle;
            text-align: left;
        }

        td.text-right {
            text-align: right;
        }

        .adresse {
            margin-top: 4cm;
            margin-bottom: 1cm;
            line-height: 90%;
        }

        .content {
            margin-top: 1cm;
            margin-bottom: 1cm;
        }

        .company_data {
            margin-top: 1cm;
            margin-bottom: 1cm;
            font-size: 10px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>

</head>

<body class="bg-white">

    <!-- footer vor content führt dazu, dass die Fusszeile bereits auf der 1. Seite erscheint-->
    <div id="footer">
        @yield('footer')
    </div>

    <div>
        @yield('content')
    </div>

</body>

</html>
