<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title')</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">

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
    @include('includes.footer')
    
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
              // call onload or in script segment below form
        function attachCheckboxHandlers() {
            // get reference to element containing toppings checkboxes
            var el = document.getElementById('toppings');

            // get reference to input elements in toppings container element
            var tops = el.getElementsByTagName('input');
            
            // assign updateTotal function to onclick property of each checkbox
            for (var i=0, len=tops.length; i<len; i++) {
                if ( tops[i].type === 'checkbox' ) {
                    tops[i].onclick = updateTotal;
                }
            }
        }
            
        // called onclick of toppings checkboxes
        function updateTotal(e) {
            // 'this' is reference to checkbox clicked on
            var form = this.form;
            
            // get current value in total text box, using parseFloat since it is a string
            var val = parseFloat( form.elements['total'].value );
            
            // if check box is checked, add its value to val, otherwise subtract it
            if ( this.checked ) {
                val += parseFloat(this.value);
            } else {
                val -= parseFloat(this.value);
            }
            
            // format val with correct number of decimal places
            // and use it to update value of total text box
            form.elements['total'].value = formatDecimal(val);
        }
            
        // format val to n number of decimal places
        // modified version of Danny Goodman's (JS Bible)
        function formatDecimal(val, n) {
            n = n || 2;
            var str = "" + Math.round ( parseFloat(val) * Math.pow(10, n) );
            while (str.length <= n) {
                str = "0" + str;
            }
            var pt = str.length - n;
            return str.slice(0,pt) + "." + str.slice(pt);
        }

        // in script segment below form
        attachCheckboxHandlers();
    </script>
    <script>
        $(document).ready(function() {        
            $(".my-activity").click(function(event) {
                var total = 0;
                $(".my-activity:checked").each(function() {
                    total += parseInt($(this).val());
                });
                
                if (total == 0) {
                    $('#amount').val('');
                } else {                
                    $('#amount').val(total);
                }
            });
        });    
    </script>
    <script>
        $('#select-all').click(function(event) {   
            var total = 0;
            for(var i=0;i<input.length;i++){               
                total += ($(".my-activity")[i]).val();
                return total;
            }
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                    $('#amount').val(total);                        
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                    $('#amount').val('');                       
                });
            }
            
        });
    </script>
</body>

</html>