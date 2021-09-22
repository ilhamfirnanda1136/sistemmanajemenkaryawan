@extends('layouts.admin',['title' => 'Riwayat Absen Karyawan'])
@section('content')
<div class="container">
    <div class="row profile-page justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Riwayat Absen Karyawan</h3>
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

        
        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Grafik Absen</h3>
                </div>
                <div class="card-body">
                    <canvas id="grafik-absen" width="100%"></canvas>
                </div>
            </div>
        </div>


        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Riwayat Absen</h4>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Table Data Riwayat Absen</h4>
                    <div class="table-responsive">
                        <table id="table-absen" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No #</th>
                                    <th>Tanggal Absen</th>
                                    <th>Absen Masuk</th>
                                    <th>Absen Keluar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach($absen as $a)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$a->created_at->format('Y-m-d')}}</td>
                                    <td>{{$a->created_at->format('H:i:s')}}{!!$a->status==1 ? '<span
                                            class="badge badge-success">Valid</span>' : '<span
                                            class="badge badge-danger">Tidak Valid</span>' !!}</td>
                                    <td>{{$a->absenkeluar->created_at->format('H:i:s')}} {!!$a->absenkeluar->status==1 ?
                                        '<span class="badge badge-success">Valid</span>' : '<span
                                            class="badge badge-danger">Tidak Valid</span>' !!}</td>
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
@stop
@section('footer')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
   
<script>
    $('#table-absen').DataTable();

    $(document).ready(function () {
        const tahun = $('#tahun').val();
        const bulan = $('#bulan').val();
        fetch(`${process_env_url}/admin/grafik/karyawan/${bulan}/${tahun}`)
            .then(res => res.json())
            .then(data => {
                console.log(data);
                var ctx = document.getElementById('grafik-absen').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: getDaysInMonth(),
                        datasets: [{
                            label: `Absen Karyawan `,
                            backgroundColor: 'red',
                            borderColor: 'red',
                            data: data.data
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Grafik Absen Karyawan'
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
                        scales: {
                            xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Month'
                                }
                            }],
                            yAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Value'
                                }
                            }]
                        }
                    }
                })
            })
            .catch(err => console.log(err))
    });
</script>
@endsection