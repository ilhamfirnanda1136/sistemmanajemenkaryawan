 <!-- partial:{{asset('')}}/partials/_sidebar.html -->
 <style>
.img-xs {
    width: 58px;
    min-width: 55px;
    height: 56px;
}
 </style>
 <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="profile-image">
                    <?php
                            $foto = url('images/noimage.jpg'); 
                   ?>
                    <img class="img-xs rounded-circle" src="{{$foto}}"
                        alt="profile image">
                    <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                    <p class="profile-name">{{Auth::user()->name}}</p>
                    <p class="designation">Admin</p>
                </div>
            </a>
        </li>
        <li class="nav-item nav-category">Main Menu</li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('admin/absen')}}">
                <i class="menu-icon typcn typcn-mail"></i>
                <span class="menu-title">Laporan Absen</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('admin/izin')}}" >
                <i class="menu-icon typcn typcn-mail"></i>
                <span class="menu-title">Laporan Permohonan Ijin</span>
            </a>
        </li>
    </ul>
</nav>