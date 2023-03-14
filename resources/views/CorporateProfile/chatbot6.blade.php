<!DOCTYPE html>
<html>

<head>
    <title>Chatbot6</title>
</head>

<body>
    <form action="{{ route('chatbot.process') }}" method="POST">
        @csrf
        <label for="message">Masukkan pesan:</label><br>
        <input type="text" id="message" name="message"><br>
        <button type="submit">Kirim</button>
    </form>
</body>

</html>