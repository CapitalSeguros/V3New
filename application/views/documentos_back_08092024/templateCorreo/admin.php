<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu Título de E-mail</title>
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
                <h1>REPORTE DE ESTADO DE SINIESTROS</h1>
                <p>Resumen general de los siniestros</p>
            </td>
        </tr>
        <tr>
            <td colspan="6" style="border-radius: 10px;">
        <tr>
            <td>
        <tr style="background: #663AB5; color: white;">
			<th class="table-head" style="color: #663AB5;">
                sdsdsds
            </th>
            <th class="table-head">
                <p>NUEVOS MES</p>
            </th>
            <th class="table-head">
                <p>TOTAL</p>
            </th>
            <th class="table-head">
                <p>EN TIEMPO</p>
            </th>
            <th class="table-head">
                <p>FUERA TIEMPO</p>
            </th>
            <th class="table-head">
                <p>TIEMPO PROMEDIO</p><br/>
                <p>(DIAS)</p>
            </th>
        </tr>
        <tr style='text-align: center; font-size: 14px;'>
			<th class="table-head" style="color: #663AB5;">
                <p>AUTOS INDIVIDUAL</p>
            </th>
            <th class="table-head">
                <p>{{ i_nuevos_mes }}</p>
            </th>
            <th class="table-head">
                <p>{{ i_total }}</p>
            </th>
            <th class="table-head">
                <p>{{ i_en_tiempo }}</p>
            </th>
            <th class="table-head">
                <p>{{ i_fuera_tiempo }}</p>
            </th>
            <th class="table-head">
                <p>{{ i_tiempo_promedio }}</p>
            </th>
		</tr>
		<tr style='text-align: center; font-size: 14px;'>
			<th class="table-head" style="color: #663AB5;">
                <p>AUTOS CORPORATIVO</p>
            </th>
            <th class="table-head">
                <p>{{ c_nuevos_mes }}</p>
            </th>
            <th class="table-head">
                <p>{{ c_total }}</p>
            </th>
            <th class="table-head">
                <p>{{ c_en_tiempo }}</p>
            </th>
            <th class="table-head">
                <p>{{ c_fuera_tiempo }}</p>
            </th>
            <th class="table-head">
                <p>{{ c_tiempo_promedio }}</p>
            </th>
		</tr>
		<tr style='text-align: center; font-size: 14px;'>
			<th class="table-head" style="color: #663AB5;">
                <p>GMM</p>
            </th>
            <th class="table-head">
                <p>{{ g_nuevos_mes }}</p>
            </th>
            <th class="table-head">
                <p>{{ g_total }}</p>
            </th>
            <th class="table-head">
                <p>{{ g_en_tiempo }}</p>
            </th>
            <th class="table-head">
                <p>{{ g_fuera_tiempo }}</p>
            </th>
            <th class="table-head">
                <p>{{ g_tiempo_promedio }}</p>
            </th>
		</tr>
		<tr style='text-align: center; font-size: 14px;'>
			<th class="table-head" style="color: #663AB5;">
                <p>DAÑOS</p>
            </th>
            <th class="table-head">
                <p>{{ d_nuevos_mes }}</p>
            </th>
            <th class="table-head">
                <p>{{ d_total }}</p>
            </th>
            <th class="table-head">
                <p>{{ d_en_tiempo }}</p>
            </th>
            <th class="table-head">
                <p>{{ d_fuera_tiempo }}</p>
            </th>
            <th class="table-head">
                <p>{{ d_tiempo_promedio }}</p>
            </th>
		</tr>
        <tr style='text-align: center; font-size: 14px;'>
			<th class="table-head" style="color: #663AB5;">
                <p>TOTALES</p>
            </th>
            <th class="table-head">
                <p>{{ Total1 }}</p>
            </th>
            <th class="table-head">
                <p>{{ Total2 }}</p>
            </th>
            <th class="table-head">
                <p>{{ Total3 }}</p>
            </th>
            <th class="table-head">
                <p>{{ Total4 }}</p>
            </th>
            <th class="table-head">
                <p>{{ Total5 }}</p>
            </th>
		</tr>
	</table>
</body>