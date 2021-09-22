<nav class="sidebar sidebar-offcanvas" id="sidebar">
     <ul class="nav">
         <li class="nav-item nav-profile">
             <a href="#" class="nav-link">
                 <div class="profile-image">
                     <img class="img-xs rounded-circle" src="{{asset('images/noimage.jpg')}}" alt="profile image">
                     <div class="dot-indicator bg-success"></div>
                 </div>
                 <div class="text-wrapper">
                     <p class="profile-name"> {{ Session::get('karyawan')->nama }}</p>
                     <p class="designation">Karyawan</p>
                 </div>
             </a>
         </li>
         <li class="nav-item nav-category">Aplikasi </li>
         <li class="nav-item">
             <a class="nav-link" href="{{url('karyawan/absen/masuk')}}">
                 <i class="menu-icon typcn typcn-mail"></i>
                 <span class="menu-title">Absen</span>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav-link" href="{{url('karyawan/izin')}}">
                 <i class="menu-icon typcn typcn-mail"></i>
                 <span class="menu-title">Pengajuan Ketidakhadiran</span>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav-link" href="{{url('karyawan/riwayat/absen')}}">
                 <i class="menu-icon typcn typcn-mail"></i>
                 <span class="menu-title">Riwayat Absen</span>
             </a>
         </li>
     </ul>
 </nav>