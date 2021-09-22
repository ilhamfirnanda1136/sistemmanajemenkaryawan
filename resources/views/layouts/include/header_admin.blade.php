<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav">
            <li class="nav-item dropdown language-dropdown">
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown"
                    aria-expanded="false">
                    <?php 
                        $foto = url('images/noimage.jpg');
                    ?>
                    <img class="img-xs rounded-circle" src="{{$foto}}"
                        alt="Profile image"> </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <img class="img-md rounded-circle" src="{{$foto}}"
                            alt="Profile image">
                        <p class="mb-1 mt-3 font-weight-semibold" >{{ Auth::user()->name }}</p>
                        <p class="font-weight-light text-muted mb-0">{{ Auth::user()->email }}</p>
                    </div>
                    <a href="{{url('admin/logout')}}" class="dropdown-item" ><i class="dropdown-item-icon mdi mdi-power text-primary"></i>Sign
                        Out</a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>