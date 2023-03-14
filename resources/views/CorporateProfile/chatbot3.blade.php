<!DOCTYPE html>
<html>

<head>
    <title>Chatbot</title>
</head>

<body>
    <form method="post" action="{{ route('chat') }}">
        @csrf
        <label for="message">Pesan:</label>
        <input type="text" name="message" id="message">
        <button type="submit">Kirim</button>
    </form>
    <div id="response"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        $('#response').html('<p>Bot: ' + response.message + '</p>');
                    },
                    error: function(xhr) {
                        $('#response').html('<p>Bot: Maaf, terjadi kesalahan saat memproses permintaan Anda.</p>');
                    }
                });
            });
        });
    </script>
</body>

</html>