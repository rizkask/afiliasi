<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title')</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- style -->
    @stack('prepend-style')
    @include('includes.style')
    @stack('addon-style')
    <!-- =======================================================
    * Template Name: Flattern - v2.1.0
    * Template URL: https://bootstrapmade.com/flattern-multipurpose-bootstrap-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

    <body>

    

        <!-- ======= navbar ======= -->
        @include('includes.navbar')

        <!-- ======= main content ======= -->
        @yield('content')

        @if ($message = Session::get('success'))
        <div class="container">
        <div class="row">
            <div class="modal fade" id="ignismyModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
                        </div>
                
                        <div class="modal-body">
                            <div class="thank-you-pop">
                            <img src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" alt="">
                            <p>{{ $message }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        @endif

        <!-- ======= Footer ======= -->
        
        
        <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

        @stack('prepend-script')
        @include('includes.script')
        @stack('addon-script')
        <script>
        @if ($message = Session::get('success'))
            $(function() {
                $('#ignismyModal').modal('show');
            });
        @endif
        </script>
        
        <script>
            $(document).ready(function() {
                (function() {
                    var showChar = 22;
                    var ellipsestext = " ...";

                    $(".truncate").each(function() {
                        var content = $(this).html();
                        if (content.length > showChar) {
                            var c = content.substr(0, showChar);
                            var h = content;
                            var html =
                            c +
                            '<span class="moreellipses">' +
                            ellipsestext;

                            $(this).html(html);
                        }
                    });
                    /* end iffe */
                })();

            /* end ready */
            });

        </script>

        <script>
            function search_animal() {
                let input = document.getElementById('searchbar').value
                input=input.toLowerCase();
                let x = document.getElementsByClassName('animals');
                
                for (i = 0; i < x.length; i++) { 
                    if (!x[i].innerHTML.toLowerCase().includes(input)) {
                        x[i].style.display="none";
                    }
                    else {
                        x[i].style.display="cek";                 
                    }
                }
            }
        </script>

        
        
        
        
    </body>
    <footer>
        @include('includes.footer')
    </footer>
</html>