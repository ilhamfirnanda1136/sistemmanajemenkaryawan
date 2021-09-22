@extends('layouts.karyawan',['title' => 'Data Absen Keluar Karyawan '])
@section('header')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin="" />
@stop
@section('content')
<div class="container">
    <div class="row profile-page justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Absen Keluar Anda Hari Ini : {{date("d/m/Y")}}</h4>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-responsive" >
                                <tbody >
                                    <tr>
                                        <th>Nama</th>
                                        <th>:</th>
                                        <th>{{Session::get('karyawan')->nama}}</th>
                                    </tr>
                                     <tr>
                                        <th>Jam Masuk</th>
                                        <th>:</th>
                                        <th>{{$absenkeluar->absenmasuk->created_at->format('H:i:s')}}</th>
                                    </tr>
                                    <tr>
                                        <th>Jam Keluar</th>
                                        <th>:</th>
                                        <th>{{$absenkeluar->created_at->format('H:i:s')}}</th>
                                    </tr>
                                    <tr>
                                        <th>Lokasi</th>
                                        <th>:</th>
                                        <th><button id="marker" data-lat="{{$absenkeluar->lat}}" data-lang="{{$absenkeluar->lang}}" class="btn btn-success btn-md"><i class="fa fa-map-marker"></i></button></th>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <th>:</th>
                                        <th>{!!$absenkeluar->status==1 ? '<span class="badge badge-success">Valid</span>' : '<span class="badge badge-danger">Tidak Valid</span>'  !!}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="map-absen-keluar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="exampleModalLabel">Koordinat Absen Keluar </h5>
        <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div id="map" class="maps-leaflet-container"></div>
      </div>
      <div class="modal-footer">
        <button type="button" id="" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


@stop
@section('footer')
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
<script>
$(document).ready(function(){
    document.querySelector('.maps-leaflet-container').style.height = '450px';
    const lat = "{{$absenkeluar->lat}}";
    const lang = "{{$absenkeluar->lang}}";
    var map = L.map('map').setView([lat,lang], 9);
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 20,
      attribution: '<a href>MAP KOORDINAT ANDA</a>',
      id: 'mapbox.light'
    }).addTo(map);
     L.marker([lat,lang]).addTo(map);
     $('#marker').click(function(){
        $('#map-absen-keluar').modal({backdrop:'static'});
     });
     $('.close-modal').click(function(){
      $('#map-absen-keluar').modal('hide');
     })
  });
</script>
@endsection