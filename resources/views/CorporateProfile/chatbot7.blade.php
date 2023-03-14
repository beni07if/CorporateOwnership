<!DOCTYPE html>
<html>

<head>
    <title>Get Subsidiary</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Get Subsidiary</h1>
    <label for="subsidiary">Enter subsidiary name:</label>
    <input type="text" id="subsidiary" name="subsidiary">
    <button id="search">Search</button>
    <div id="response"></div>

    <script>
        $(document).ready(function() {
            $("#search").click(function() {
                var subsidiary = $("#subsidiary").val();
                $.ajax({
                    url: "/chatbot7",
                    type: "POST",
                    dataType: "json",
                    data: {
                        message: subsidiary,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $("#response").html(response.message);
                    }
                });
            });
        });
    </script>
</body>

</html>