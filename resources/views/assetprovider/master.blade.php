<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        {{Str::title($title)}}
    </title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@200;300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/{{$bs_version}}/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="{{asset('css/sidenav.css')}}" rel="stylesheet">
    @stack('link-css')
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    {{-- Navigation Script --}}
    <script defer>
        document.addEventListener("DOMContentLoaded", function(event) {
        const showNavbar = (toggleId, navId, bodyId, headerId) =>{
        const toggle = document.getElementById(toggleId),
        nav = document.getElementById(navId),
        bodypd = document.getElementById(bodyId),
        headerpd = document.getElementById(headerId)

        // Validate that all variables exist
        if(toggle && nav && bodypd && headerpd){
        toggle.addEventListener('click', ()=>{
        // show navbar
        nav.classList.toggle('show')
        // change icon
        toggle.classList.toggle('bx-x')
        // add padding to body
        bodypd.classList.toggle('body-pd')
        // add padding to header
        headerpd.classList.toggle('body-pd')
        })
        }
        }

        showNavbar('header-toggle','nav-bar','body-pd','header')

        /*===== LINK ACTIVE =====*/
        const linkColor = document.querySelectorAll('.nav_link')

        function colorLink(){
        if(linkColor){
        linkColor.forEach(l=> l.classList.remove('active'))
        this.classList.add('active')
        }
        }
        linkColor.forEach(l=> l.addEventListener('click', colorLink))

        // Your code to run since DOM is loaded and ready
        });
    </script>
    @stack('link-js')
    <style>
        a{
            text-decoration: none
        }
        .nav {
            height: 100%;
            display: flex;
            flex-direction: row;
            justify-content: start;
            overflow: hidden;
            border: 0;
        }

        nav > .nav {
            height: 100%;
            display: flex;
            flex-direction: row;
            justify-content: end;
            overflow: hidden;
            border: 0;
        }

        .tab-pane{
                width: 100%
            }

        .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
            color: #fff;
            background-color: #17a2b8;
        }

        .nav-pills .nav-link {
            border-radius: .25rem;
            border:1px solid #17a2b8;
        }

        .nav-list {
            height: 100%;
            display: flex;
            flex-direction: row;
            justify-content: start;
            overflow: hidden;
        }   
        
        .modal{
            
            width: 100%
        }
        .nav_link{
            color : {{$nav_icon_color}}
        }
        
        .active {
            color: {{$active_nav_icon_color}}
        }

        .active::before {
            background-color: {{$active_nav_icon_color_border}}
        }

        .header_toggle{
            color: {{$left_nav_color}}
        }
        .nav_logo-icon{
            color: {{$nav_icon_color}}
        }
    </style>

</head>
<body id="body-pd" style="background-color: {{$background_color}}">
    <header class="header" id="header" style="background-color: {{$top_nav_color}}">
        <div class="header_toggle">
            <i class='bx bx-menu mr-2' id="header-toggle"></i>  
            {{-- {{Str::title(config('app.name'))}} --}}
            {{Str::title($page_name)}}
        </div>
        <div class="">
            <span class=" p-2">
                @auth
                <i class="bx bx-user mr-2"></i>    {{Str::title(Auth::user() -> username)}}
                @endauth
            </span>
        </div>
    </header>
    <div class="l-navbar" id="nav-bar" style="background-color: {{$left_nav_color}}">
        <nav class="nav">
            @stack('navs')
        </nav>
    </div>
    <!--Container Main start-->
    <section class="container-fluid">
        <div id="app">
            @yield('content')
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/{{$bs_version}}/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script> 
    function onlyNumberKey(evt) { 
        // Only ASCII charactar in that range allowed 
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode 
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) 
            return false; 
        return true; 
    } 
</script>
    <script>
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }       
            }
        }
    </script>
     <script>
        function closeAccordion(id){
            $("#"+id).collapse('hide');
        }
    </script>
    @stack('scripts')
</body>
</html>