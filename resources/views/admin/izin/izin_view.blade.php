@extends('layouts.admin',['title' => 'Riwayat Permohonan Ijin Karyawan'])

@section('content')
<div class="container">
    <div class="row profile-page justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Riwayat Permohonan Ijin Karyawan</h3>
                    <form action="" method="get">
                        <div class="form-group">
                            <label for="bulan">Bulan</label>
                            <?php  $data = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
                                ?>
                            <select class="form-control" name="bulan" id="bulan">
                                <?php  foreach ($data as $key => $value) { 
                                ?>
                                <option value="<?= $key ?>" {{ $bulan== $key ? 'selected' : ''}}><?=$value ?></option>
                                <?php
                            } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <select name="tahun" id="tahun" class="form-control">
                                <?php
                                    $thn_skr = date('Y');
                                    for ($x = $thn_skr; $x >= 2012; $x--) {
                                    ?>
                                <option value="<?=$x?>" {{ $tahun== $x ? 'selected' : ''}}><?php echo $x ?>
                                </option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <button type="submit" name="lapor" class="btn btn-primary btn-md"><i class="fa fa-search"></i>
                            Search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-12 grid-margin mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Permohonan Ijin Anda</h4>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Table Permohonan Ketidakhadiran</h4>
                        <div class="table-responsive">
                            <table id="table-permohonan" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No #</th>
                                        <th>Karyawan</th>
                                        <th>Jenis Ijin</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Ijin</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach($izin as $i)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$i->karyawan->nama}}</td>
                                            <td>{{$i->jenis_ijin ? 'Izin Sakit' : 'Izin Cuti'}}</td>
                                            <td>{{$i->keterangan}}</td>
                                            <td>{{$i->tanggal_ijin}}</td>
                                            @if(Auth::user()->level == 'atasan')
                                            <td>{!!$i->status != 1 ? '<button class="btn btn-primary btn-approve" data-id="'.$i->id.'" ><i class="fa fa-pencil"></i> Approve Permohonan</button>' : '<span class="badge badge-success">Sudah Ter Approve</span>' !!}</td>
                                            @else
                                            <td>{!! $i->status == 1 ? '<span class="badge badge-success">Telah diapprove</span>' : '<span class="badge badge-success">Belum diapprove</span>'!!}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('footer')
<script>
    $('#table-permohonan').DataTable()

    $('body').on('click','.btn-approve',function(){
        const approve=$(this).data('id');
        const url = "{{url('admin/izin/approve')}}/"+approve;
        swal({
              title: "Yakin?",
              text: "anda yakin ingin mengapprove permohonan ijin karyawan ini??",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                window.location=url;
              } else {
                swal("Anda membatalkan hapus data");
              }
            });
    })
</script>
@endsection