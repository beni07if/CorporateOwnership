<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .button-pyramid {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main-button {
            background-color: #0066FF;
            color: #FFFFFF;
            padding: 12px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .sub-button {
            background-color: transparent;
            border: none;
            text-align: left;
            padding: 8px 15px;
            font-size: 14px;
            color: #333333;
            cursor: pointer;
        }

        .line {
            width: 2px;
            background-color: green;
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="button-pyramid">
        <div class="button-container">
            <button class="main-button">Main Button</button>
        </div>
        <div class="line"></div>
        <div class="button-container">
            <div class="line"></div>
            <button class="sub-button">Sub Button 1</button>
            <div class="line"></div>
            <button class="sub-button">Sub Button 2</button>
            <div class="line"></div>
            <button class="sub-button">Sub Button 3</button>
            <div class="line"></div>
        </div>
    </div>

    <script>
        const dropdownToggle = document.getElementById('dropdown-toggle');
        const dropdownMenu = document.getElementById('dropdown-menu');

        dropdownToggle.addEventListener('click', function() {
            dropdownMenu.style.display = dropdownMenu.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</body>

</html>