<!DOCTYPE html>
<html>

<head>
    <title>Chatbot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-p/Gb+FJ1Mgpj+Y2dPUErPLmFRs4lt/KGLm4mZPe4E4XfMW23zBmMJLhWFKz+vT0T3NltO/jaF7NfHeZvO9LvRg==" crossorigin="anonymous" />

    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        #chatbot {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin: auto;
            /* margin: 50px; */
            max-width: 600px;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        #messages {
            height: 300px;
            overflow: auto;
            padding: 10px;
        }

        .message {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            margin-bottom: 10px;
            width: 100%;
        }

        .message .message {
            background-color: #D3D3D3;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            /* max-width: 60%; */
            width: 600px;
            padding: 10px;
            text-align: right;
        }

        .message .response {
            background-color: #F4A460;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            color: #fff;
            /* max-width: 60%; */
            width: 600px;
            padding: 10px;
            text-align: left;
        }

        .message .message-body:last-child {
            margin-left: auto;
            background-color: #F5F5F5;
        }

        #input {
            display: flex;
            flex-direction: row;
            margin-top: 10px;
            width: 100%;
        }

        #input input[type=text] {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            flex: 1;
            margin-right: 10px;
            padding: 10px;
            width: 500px;
        }

        #input button[type=submit] {
            background-color: #008080;
            border: none;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            padding: 10px;
        }
    </style>

</head>

<body>
    <div id="chatbot">
        <h1>Chatbot Corporate Profile</h1>
        <div id="messages">
            <div class="message">
                <div class="message-body">
                    Temukan Data Company/Subsidiary.
                </div>
            </div>
        </div>
        <div id="input">
            <form action="{{ route('chatbot.store2') }}">
                <input type="text" id="message" name="message" placeholder="Type subsidiary">
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
                    // // respon tanpa typing
                    // success: function(response) {
                    //     // $('#messages').append('<div class="message sent"><div class="message">' + message + '</div></div>');
                    //     $('#messages').append('<div class="message sent"> <i class = "fas fa-bars"></i> <div class = "message">' + message + '</div></div>');
                    //     $('#messages').append('<div class="message received"><div class="response">' + response.message + '</div></div>');
                    //     $('#messages').scrollTop($('#messages')[0].scrollHeight);
                    // },
                    // // end respon tanpa typing
                    // respon dengan typing
                    success: function(response) {
                        var sentMsg = $('<div class="message sent"></div>');
                        sentMsg.append('<i class="fas fa-user"></i>');
                        sentMsg.append('<div class="message">' + message + '</div>');
                        sentMsg.append('<i class="fas fa-bars"></i>');

                        $('#messages').append(sentMsg);

                        var responseDiv = $('<div class="message received"></div>');
                        responseDiv.append('<i class="fas fa-robot"></i>');
                        var responseMsg = $('<div class="response"></div>');
                        responseDiv.append(responseMsg);
                        responseDiv.append('<i class="fas fa-bars"></i>');

                        $('#messages').append(responseDiv);
                        $('#messages').scrollTop($('#messages')[0].scrollHeight);

                        var text = response.message;
                        var i = 0;
                        var timer = setInterval(function() {
                            if (i < text.length) {
                                responseMsg.text(responseMsg.text() + text.charAt(i));
                                i++;
                            } else {
                                clearInterval(timer);
                            }
                        }, 50);
                    },

                    // end respon dengan typing
                    error: function(xhr, status, error) {
                        alert('Maaf, terjadi kesalahan saat memproses permintaan Anda: ' + error);
                    },
                });
            });
        });
    </script>
</body>

</html>