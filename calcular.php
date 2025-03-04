<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ip = $_POST["ip"];
    $cidr = $_POST["cidr"];

    list($network, $mask, $broadcast, $range) = calcularXarxa($ip, $cidr);
}

function calcularXarxa($ip, $cidr) {
    $subnet = long2ip(ip2long($ip) & ~((1 << (32 - $cidr)) - 1));
    $broadcast = long2ip(ip2long($subnet) | ((1 << (32 - $cidr)) - 1));
    $range = long2ip(ip2long($subnet) + 1) . " - " . long2ip(ip2long($broadcast) - 1);
    return [$subnet, "/$cidr", $broadcast, $range];
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultats de la Xarxa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Estilos generals */
        body {
            font-family: 'Arial', sans-serif;
            background: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }

        h2 {
            color: #333;
            margin-bottom: 15px;
        }

        p {
            font-size: 18px;
            margin: 8px 0;
        }

        .icon {
            font-size: 18px;
            margin-right: 8px;
            color: #007BFF;
        }

        .btn {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            padding: 10px 15px;
            background: #007BFF;
            color: white;
            border-radius: 5px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2><i class="fa-solid fa-network-wired"></i> Resultats de la Xarxa</h2>
        <p><i class="fa-solid fa-globe icon"></i><strong>Adreça de xarxa:</strong> <?php echo $network; ?></p>
        <p><i class="fa-solid fa-mask icon"></i><strong>Màscara:</strong> <?php echo $mask; ?></p>
        <p><i class="fa-solid fa-arrows-left-right icon"></i><strong>Rang d'IP:</strong> <?php echo $range; ?></p>
        <p><i class="fa-solid fa-broadcast-tower icon"></i><strong>IP de broadcast:</strong> <?php echo $broadcast; ?></p>
        
        <a href="index.html" class="btn"><i class="fa-solid fa-arrow-left"></i> Tornar</a>
    </div>

</body>
</html>
