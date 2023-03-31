<!DOCTYPE html>
<html>

<head>
    <title>Get Subsidiary</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="chatbox">
        <div class="language">
            <ul>
                <li><a class="active" href="#">Indonesia</a></li>
                <li><a href="{{ route('chatbotGroupEn') }}">English</a></li>
            </ul>
        </div>
        <nav>
            <ul>
                <li class="nav-item"><a href="{{route ('chatbotSubsidiaryId') }}" data-toggle="tab">Subsidiary</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Group</a></li>
                <!-- <li class="nav-item"><a class="nav-link" href="#shareholder" data-toggle="tab">Shareholder</a></li> -->
            </ul>
        </nav>
        <div class="tab pane">
            <h1>Cari Group</h1>
            <div id="response"></div>
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
                <input type="submit" id="search-group" value="Send">
            </form>
        </div>
        <div class="tab pane" id="shareholder" hidden>
            Shareholder
        </div>
        <br><br>
    </div>

    <script>
        $(document).ready(function() {
            // group 
            $(".chatbox form").submit(function(e) {
                e.preventDefault();
                sendMessage();
            });

            function sendMessage() {
                var group_name = $("#group_name").val();
                var message = "<div class='response user'>" + group_name + "</div>";
                $("#response").append(message);

                $.ajax({
                    url: "/eq-group",
                    type: "POST",
                    dataType: "json",
                    data: {
                        message: group_name,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response2) {
                        var message = "<div class='response bot'>" + response2.message + "</div>";
                        $("#response").append(message);
                    }
                });

                $("#group_name").val("");
            }
            // end group


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
        });

        // end nav 
    </script>
</body>

</html>