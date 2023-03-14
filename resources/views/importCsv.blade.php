<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h1>Import CSV</h1>
        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="csv_file">CSV File</label>
                <input type="file" class="form-control-file" id="csv_file" name="csv_file">
            </div>
            <button type="submit" class="btn btn-primary">Import</button>
        </form>
    </div>
</body>

</html>