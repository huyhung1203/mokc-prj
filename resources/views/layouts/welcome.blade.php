<!DOCTYPE html>
<html lang="en">

<head>

   @include('includes.head')

</head>

<body id="page-top">
   
    <!-- Page Wrapper -->
    <div id="wrapper">
           
        <div style="height: auto">
            <!-- Sidebar -->
           
            @include('includes.sidebar')
            <!-- End of Sidebar -->
            
        </div>
       
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column overflow-auto">
            @include('includes.header')
            <!-- Main Content -->
            <div id="content">

             
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid " >
                   @yield('dashboard')
                   @yield('checkin')
                   @yield('member')
                   @yield('add_member')
                   @yield('staff')
                   @yield('add_staff')
                   @yield('list')
                   @yield('member_details')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            @stack('staff')
            {{-- <!-- Footer -->
            @include('includes.footer')
            <!-- End of Footer --> --}}

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

     
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('access/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('access/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('access/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('access/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('access/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('access/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('access/js/demo/chart-pie-demo.js') }}"></script>

    <script src="{{ asset('access/js/thainn/home.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
   
</body>

</html>