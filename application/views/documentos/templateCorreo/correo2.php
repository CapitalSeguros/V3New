<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envio Correo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Open Sans', sans-serif;
            font-size:14px;
        }

        h1 {
            color: #663AB5;
        }

        table {
            max-width: 600px;
            margin: 0 auto;
            padding: 0 20px 30px;
            background-color: #EDE6F6;
            border-radius: 20px;
        }

        .table-head {
            font-size: 11px;
            padding: 5px;
            color: #663AB5;
        }

        @media (max-width: 600px) {
            .container {
                width: 100% !important;
            }
        }
    </style>
</head>

<body>
    <table class="container">
        <tr>
            <td colspan="6">
                <h1>NUEVO TRÁMITE ACTIVO</h1>
                <p>Se necesita la atención para la carga de la documentación del siguiente trámite: <br/>
				<b>Folio:</b> {{ folio_cia }}<br />
				<b>Tipo de tramite:</b> {{ tipo_tramite }} <br />
				<b>Descripción:</b> {{ tramite_descripcion }}<br />
				<b>Persona:</b> {{ afectado }}<br /><br />
				 {{ mensaje }}
				</p>
            </td>
        </tr>
        <tr>
        <td colspan="3" style="border-radius: 10px;">
        <tr style="background: #663AB5; color: #EDE6F6;">
            <th colspan="3" >
                <a href="{{ url }}" style="color:white; text-decoration:none;height:50px"> SITIO DE CARGA</a>
            </th>
        </tr>
    </table>
</body>

</html>