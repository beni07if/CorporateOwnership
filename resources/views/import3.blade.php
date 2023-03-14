<!DOCTYPE html>
<html>

<head>
    <title>Import Data</title>
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

    <form method="POST" action="{{ route('import') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="file">Choose a CSV file:</label>
            <input type="file" id="file" name="file">
        </div>
        <button type="submit">Import</button>
    </form>
</body>

</html>