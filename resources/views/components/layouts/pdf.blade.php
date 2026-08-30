<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <table class="header">
        <tr>
            <td>
                <img height="70" src="{{ public_path('storage/img/logo-ifpr.png') }}">
            </td>

            <td class="right">
                <img height="90" src="{{ public_path('storage/img/logo-cnapne-full.png') }}">
            </td>
        </tr>
    </table>

    {{ $slot }}

    <p class="mt-md" style="font-size: 14px;">Documento gerado no dia {{ now()->format('d/m/Y \à\s H:i') }} por {{ Illuminate\Support\Facades\Auth::user()->nome }} no SUAPNE</p>
</body>

<style>
    body {
        box-sizing: border-box;
        padding: 30px 50px;
    }

    .header {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    .header td {
        width: 50%;
    }

    .header .right {
        text-align: right;
    }

    .textarea {
        white-space: pre-line;
    }

    .text-center {
        text-align: center;
    }

    .border {
        border: 1px solid black;
        padding: 10px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .table td {
        border: 1px solid black;
        padding: 8px;
    }

    .bold {
        font-weight: bold;
    }

    .mb-sm {
        margin-bottom: 10px;
    }

    .mb-md {
        margin-bottom: 20px;
    }

    .mb-lg {
        margin-bottom: 40px;
    }

    .mt-md {
        margin-top: 20px;
    }
</style>

</html>
