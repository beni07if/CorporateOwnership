<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>Import Data</h2>

    @if (session('success'))
    <div>
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div>
        {{ session('error') }}
    </div>
    @endif

    <form method="POST" action="{{ route('importCsv') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="file">Choose a CSV file:</label>
            <input type="file" id="file" name="file">
        </div>
        <button type="submit">Import</button>
    </form>
</body>

</html>