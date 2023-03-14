<!DOCTYPE html>
<html>

<head>
    <title>Chatbot</title>
</head>

<body>
    <h1>Chatbot</h1>

    <div id="chatbox">
        <div class="chatlog"></div>
        <form action="{{ route('chatbot.response') }}" method="POST">
            @csrf
            <input type="text" name="pesan" placeholder="Tulis pesan disini...">
            <button type="submit">Kirim</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('form').submit(function(e) {
            e.preventDefault();

            var pesan = $('input[name=pesan]').val();
            $('input[name=pesan]').val('');

            $.ajax({
                type: 'POST',
                url: '{{ route("chatbot.response") }}',
                data: {
                    pesan: pesan,
                },
                success: function(response) {
                    var chatlog = $('.chatlog');

                    chatlog.append('<p><strong>Kamu:</strong> ' + pesan + '</p>');
                    chatlog.append('<p><strong>Bot:</strong> ' + response.response + '</p>');
                }
            });
        });
    </script>
</body>

</html>