<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            margin: 0;
        }

        .justify-content-center {
            justify-content: center !important;
        }

        .col-xxl-9 {
            flex: 0 0 auto;
            width: 100%;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }



        .container {
            max-width: 940px;
            margin: 0 auto;
            padding: 20px;
            background: #f8f9fa;
        }
        .header {
            padding: 20px;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }
        .body {
            padding:0px 20px;
        }
        .transaction-details {
            margin-bottom: 30px;
            padding: 20px;
            background: #d5d7da;

        }
    </style>



</head>

<body>
    <div class="container">
        <div class="header">
            <table width="100%">
                <tr>
                    <td>
                        <img src="file://{{ public_path('assets/img/logos/votium_V.png') }}" alt="Logo" height="100">
                        <h3>Invoice No : {{$data["invoice_number"] ?? 'Non disponible' }}</h3>
                    </td>
                </tr>
            </table>
        </div>
        <div class="body">
            <div class="transaction-details">
                <h4>Information paiement</h4>
                <table width="100%" cellspacing="0" cellpadding="5">
                    <tbody>
                        <tr>
                            <td>Nom et prènom du payeur</td>
                            <td>{{$data["name"] ?? 'Non disponible' }}</td>
                        </tr>
                        <tr>
                            <td>Numero de telephone</td>
                            <td>{{$data["phoneNumber"] ?? 'Non disponible' }}</td>
                        </tr>
                        <tr>
                            <td>Adresse èlêctronique</td>
                            <td>{{$data["email"] ?? 'Non disponible' }}</td>
                        </tr>
                        <tr>
                            <td>Montant payee </td>
                            <td>{{$data["amount"] ?? 'Non disponible' }}</td>
                        </tr>
                        <tr>
                            <td>Date de transaction</td>
                            <td>{{$data["date"] ?? 'Non disponible' }}</td>
                        </tr>
                        <tr>
                            <td>Identifiant de transaction</td>
                            <td>{{$data["transaction_id"] ?? 'Non disponible' }}</td>
                        </tr>
                        <tr>
                            <td>Reference partenaire</td>
                            <td>{{$data["reference"] ?? 'Non disponible' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="">
                <h4>Information candidat</h4>
                <table width="100%" cellspacing="0" cellpadding="5">
                    <tbody>
                    <tr>
                        <td>Candidat</td>
                        <td></td>
                        <td> xxxxx xxxxxxxx</td>
                    </tr>
                    <tr>
                        <td>Nombre de vote(s)</td>
                        <td></td>
                        <td> xxxxx xxxxxxxx</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="">
                <table width="100%" cellspacing="0" cellpadding="5">
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
