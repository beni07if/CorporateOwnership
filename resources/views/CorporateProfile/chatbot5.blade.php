<!DOCTYPE html>
<html>

<head>
    <title>Get Subsidiary</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #F5F5F5;
            padding: 20px;
        }


        .chatbox {
            background-color: #FFF;
            max-width: 500px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #BDBDBD;
            padding: 20px;
        }

        .chatbox form {
            padding: 20px;
        }

        .chatbox h1 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .chatbox input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            box-shadow: 0px 0px 5px #BDBDBD;
        }

        .chatbox input[type="submit"] {
            background-color: #4CAF50;
            color: #FFF;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .chatbox .response {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            box-shadow: 0px 0px 5px #BDBDBD;
        }

        .chatbox .user {
            background-color: #235142;
            color: #FFF;
        }

        .chatbox .bot {
            background-color: #E37B1C;
            color: #FFF;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="chatbox">
        <h1>Get Subsidiary</h1>
        <div id="response"></div>
        <form>
            <input type="text" id="subsidiary" name="subsidiary" placeholder="Enter subsidiary name...">
            <input type="submit" id="search" value="Send">
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $(".chatbox form").submit(function(e) {
                e.preventDefault();
                sendMessage();
            });

            function sendMessage() {
                var subsidiary = $("#subsidiary").val();
                var message = "<div class='response user'>" + subsidiary + "</div>";
                $("#response").append(message);

                $.ajax({
                    url: "/chatbot5",
                    type: "POST",
                    dataType: "json",
                    data: {
                        message: subsidiary,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        var message = "<div class='response bot'>" + response.message + "</div>";
                        $("#response").append(message);
                    }
                });

                $("#subsidiary").val("");
            }
        });
    </script>
</body>

</html>