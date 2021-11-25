@include('users.layout.index')

<body>

    @include('users.partials.header')
    <div id="container" style="width:95%; margin:0px auto;">
        <div class="content" style="margin-top: 10px">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb" style="float: right; font-size:15px;">
                    <li class="breadcrumb-item">
                        <a style="text-decoration:none; font-weight:bold;" href="{{ asset('users/index') }}">
                            <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-house-fill" viewBox="0 0 16 16" style="margin-top: -5px">
                                    <path fill-rule="evenodd"
                                        d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                                    <path fill-rule="evenodd"
                                        d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                                </svg> Trang chủ</p>
                        </a>
                    </li>
                </ol>
            </nav>
            <table class="table table-hover ">
                <thead style="background-color: #28a745; color:#fff">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="width: 800px; text-align: center">Danh sách đề tài</th>
                        <th scope="col" style="width: 200px; text-align: center">Tác giả</th>
                        <th scope="col" style="width: 200px; text-align: center">Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detai as $row)
                        <tr style="background: #fff">
                            <td style="text-align: center">
                                <span>{{ $row->id_DeTai }}</span>
                            </td>
                            <td>
                                <span>{{ $row->TenDeTai }}</span>
                            </td>




                        </tr>
                    @endforeach

                </tbody>
            </table>


        </div>


    </div>



    @include('users.partials.footer')


    <!-- Bootstrap -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- Load jQuery require for isotope -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- Isotope -->
    <script src="assets/js/isotope.pkgd.js"></script>
    <!-- Page Script -->
    <script>
        $(window).load(function() {
            // init Isotope
            var $projects = $('.projects').isotope({
                itemSelector: '.project',
                layoutMode: 'fitRows'
            });
            $(".filter-btn").click(function() {
                var data_filter = $(this).attr("data-filter");
                $projects.isotope({
                    filter: data_filter
                });
                $(".filter-btn").removeClass("active");
                $(".filter-btn").removeClass("shadow");
                $(this).addClass("active");
                $(this).addClass("shadow");
                return false;
            });
        });

    </script>
    <!-- Templatemo -->
    <script src="assets/js/templatemo.js"></script>
    <!-- Custom -->
    <script src="assets/js/custom.js"></script>

</body>

</html>
