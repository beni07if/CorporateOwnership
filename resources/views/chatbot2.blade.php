<!DOCTYPE html>
<html>

<head>
    <title>Chatbot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div id="chatbot">
        <h1>Chatbot</h1>
        <div id="messages">
            <div class="message">
                <div class="message-body">
                    Halo! Silakan bertanya.
                </div>
            </div>
        </div>
        <div id="input">
            <form>
                <input type="text" id="message" name="message" placeholder="Ketik pesan di sini">
                <button type="submit">Kirim</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            $('#chatbot form').submit(function(e) {
                e.preventDefault();

                var message = $('#message').val();

                if (message.trim() == '') {
                    return false;
                }

                $('#message').val('');

                $.ajax({
                    type: 'POST',
                    url: '/chatbot',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        message: message,
                    },
                    success: function(response) {
                        $('#messages').append('<div class="message"><div class="message-body">' + message + '</div></div>');
                        $('#messages').append('<div class="message"><div class="message-body">' + response.message + '</div></div>');
                        $('#messages').scrollTop($('#messages')[0].scrollHeight);
                    },
                    error: function() {
                        alert('Maaf, terjadi kesalahan saat memproses permintaan Andasdfsas.');
                    },
                });
            });
        });
    </script>
</body>

</html>