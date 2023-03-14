<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="{{ route('import2') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="csv_file" />
        <button type="submit">Import</button>
    </form>

</body>

</html>