<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        h1 {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            margin-top: 50px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            background-color: #f2f2f2;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        p {
            font-size: 18px;
            line-height: 1.5;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1>Data Shareholder</h1>

    <div class="container">

        <p>{{ $shareholder->shareholder_name }} memiliki saham di {{ $shareholder->company_name }} sebesar {{ $shareholder->percentage_of_shares }} yang beralamat di {{ $shareholder->address }} </p>

    </div>
</body>

</html>