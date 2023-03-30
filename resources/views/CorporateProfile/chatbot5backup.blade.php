<!DOCTYPE html>
<html>

<head>
    <title>Get Subsidiary</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background-color: #F5F5F5;
            padding: 20px;
        }

        /* style nav  */
        nav {
            display: none;
        }

        nav.active {
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        nav li {
            margin: 0 10px;
        }

        nav a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        nav a:hover,
        nav a.active {
            background-color: gray;
            color: white;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }

        /* end style nav  */

        .chatbox {
            background-color: #FFF;
            max-width: 1200px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #BDBDBD;
            padding: 20px;
            font-size: 16px;
        }

        .chatbox form {
            padding: 20px;
        }

        .chatbox h1 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .chatbox input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            box-shadow: 0px 0px 5px #BDBDBD;
            font-size: 16px;
        }

        .chatbox input[type="submit"] {
            background-color: #4CAF50;
            color: #FFF;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }

        .chatbox .response {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            box-shadow: 0px 0px 5px #BDBDBD;
            font-size: 16px;
        }

        .chatbox .user {
            background-color: #235142;
            color: #FFF;
            font-size: 16px;
        }

        .chatbox .bot {
            background-color: #E37B1C;
            color: #FFF;
            font-size: 16px;
        }

        /* atur ukuran font untuk respon user dan bot agar sama */
        .chatbox .response.user,
        .chatbox .response.bot {
            font-size: 16px;
        }

        /* atur tampilan untuk layar kecil */
        @media (max-width: 576px) {
            .chatbox {
                max-width: 100%;
            }

            /* atur ukuran font untuk respon user dan bot agar sama di layar kecil */
            .chatbox .response.user,
            .chatbox .response.bot {
                font-size: 14px;
            }
        }

        /* atur tampilan untuk layar kecil */
        @media (max-width: 576px) {
            .chatbox {
                max-width: 100%;
            }

            .chatbox .response {
                font-size: 16px;
            }

            .chatbox .user {
                font-size: 16px;
            }

            .chatbox .bot {
                font-size: 16px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="chatbox">
        <nav>
            <ul>
                <li class="nav-item"><a class="nav-link active" href="#company" data-toggle="tab">Subsidiary</a></li>
                <li class="nav-item" disabled><a class="nav-link" href="#group" data-toggle="tab">Group</a></li>
                <li class="nav-item"><a class="nav-link" href="#shareholder" data-toggle="tab">Shareholder</a></li>
            </ul>
        </nav>
        <div class="tab pane" id="company">
            <h1>Get Subsidiary</h1>
            <div id="response"></div>
            <form>
                <input type="text" id="subsidiary" name="subsidiary" list="subsidiary-list" placeholder="Enter subsidiary name...">
                <!-- Input selection field -->
                <!-- <input type="text" id="subsidiary-selection" name="subsidiary-selection" list="subsidiary-list"> -->

                <!-- Datalist element -->
                <!-- <datalist id="subsidiary-list">
                @foreach(DB::table('consolidations')->pluck('subsidiary')->unique() as $subsidiary)
                <option value="{{ $subsidiary }}">
                    @endforeach
            </datalist> -->
                <datalist id="subsidiary-list">
                    @foreach(DB::table('consolidations')->pluck('subsidiary')->unique() as $subsidiary)
                    @php
                    $shareholder = DB::table('consolidations')->where('subsidiary', $subsidiary)->value('shareholder_subsidiary');
                    @endphp
                    @if(!empty($shareholder) && $shareholder != 'N/A' && $shareholder != 'check')
                    <option value="{{ $subsidiary }}">
                        @endif
                        @endforeach
                </datalist>

                <input type="submit" id="search" value="Send">
            </form>
        </div>
        <div class="tab pane" id="group" hidden>
            <h1>Get Group</h1>
            <div id="response-group"></div>
            <form class="group">
                <input type="text" id="group_name" name="group_name" list="group_name-list" placeholder="Enter group name...">

                <datalist id="group_name-list">
                    @foreach(DB::table('consolidations')->pluck('group_name')->unique() as $group_name)
                    @php
                    $shareholder = DB::table('consolidations')->where('group_name', $group_name)->value('shareholder_subsidiary');
                    @endphp
                    @if(!empty($shareholder) && $shareholder != 'N/A' && $shareholder != 'check')
                    <option value="{{ $group_name }}">
                        @endif
                        @endforeach
                </datalist>

                <input type="submit" id="search" value="Send">
        </div>
        <div class="tab pane" id="shareholder" hidden>
            Shareholder
        </div>
        <br><br>
    </div>

    <script>
        $(document).ready(function() {
            $(".chatbox form").submit(function(e) {
                e.preventDefault();
                sendMessage();
            });

            function sendMessage() {
                // subsidiary 
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
                // end subsidiary 
            }
        });

        // nav 
        // Ambil semua link navigasi
        const navLinks = document.querySelectorAll('.nav-link');

        // Tambahkan event listener pada setiap link navigasi
        navLinks.forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault(); // Hentikan aksi default link navigasi

                // Ambil id tab pane yang sesuai dengan link navigasi yang ditekan
                const tabId = link.getAttribute('href');

                // Hapus class active dari semua link navigasi
                navLinks.forEach(link => {
                    link.classList.remove('active');
                });

                // Tambahkan class active pada link navigasi yang ditekan
                link.classList.add('active');

                // Sembunyikan semua tab pane
                const tabPanes = document.querySelectorAll('.tab.pane');
                tabPanes.forEach(pane => {
                    pane.style.display = 'none';
                });

                // Tampilkan tab pane yang sesuai dengan link navigasi yang ditekan
                const tabPane = document.querySelector(tabId);
                tabPane.style.display = 'block';
            });
        });
        var nav = document.querySelector('nav');
        nav.classList.add('active');
        // end nav 
    </script>
</body>

</html>