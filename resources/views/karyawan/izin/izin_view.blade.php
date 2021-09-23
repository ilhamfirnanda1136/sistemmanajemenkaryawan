@extends('layouts.karyawan',['title' => 'Data Permohonan KetidakHadiran Karyawan '])
@section('content')
<div class="container">
    <div class="row profile-page justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h3 class="card-title">Silahkan Melakukan Permhonan Ijin Ketidak Hadiran</h3>
                </div>
                <div class="card-body">
                    <form action="" id="formPermohonan" method="post">
                        <div class="form-group">
                            <small class="text-danger">Untuk Ijin Sakit bisa diinputkan maksimal H+3 dari Tanggal Ijin, Untuk Ijin Cuti bisa diinputkan maksimal H-1 dari Tanggal Ijin</small> <br>
                            <label for="jenis_ijin">jenis ijin</label>
                            <select name="jenis_ijin" id="jenis_ijin" class="form-control">
                                <option value="1">Izin Sakit</option>
                                <option value="2">Izin Cuti</option>
                            </select>
                            <small class="text-danger jenis_ijin"></small>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control" placeholder="Masukkan Keterangan Izin"></textarea>
                            <small class="text-danger keterangan"></small>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_ijin">Tanggal Ijin</label>
                            <input type="date" name="tanggal_ijin" id="tanggal_ijin"  class="form-control" />
                            <small class="text-danger tanggal_ijin"></small>
                        </div>
                        <button type="button" id="btn-izin" class="btn btn-md btn-success"> Izin</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 grid-margin mt-3">
           <div class="card">
               <div class="card-header">
                   <h4 class="card-title">Data Permohonan Ijin Anda</h4>
                   <div class="text-center">
                       <label for="">Tanggal Input</label>
                       <input type="date" class="form-control" id="tanggal" value="{{date("Y-m-d")}}">
                   </div>
               </div>
               <div class="card-body">
                   <h4 class="card-title">Table Permohonan Ketidakhadiran</h4>
                   <div class="table-responsive">
                       <table id="table-permohonan" class="table table-bordered table-hover">
                           <thead>
                               <tr>
                                   <th>No #</th>
                                   <th>Jenis Ijin</th>
                                   <th>Keterangan</th>
                                   <th>Tanggal Ijin</th>
                                   <th>status</th>
                               </tr>
                           </thead>
                           <tbody>
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
<script>
    $(document).ready(function(){
        $('#btn-izin').click( async function(){
            let form = $('#formPermohonan')[0];
            let formdata = new FormData(form);
            let self = $(this);
            self.text('Loading....');
            self.attr('disabled','true');
            await axios({
                method: "post",
                data: formdata,
                url: "{{ url('karyawan/izin') }}",
            }).then(data => {
                self.text('Izin');
                self.removeAttr('disabled');
                if ($.isEmptyObject(data.data.errors)) {
                    $.each(data.data.success, key => {
                        let pesan = $(`#` + key).parent();
                        let text = $('.' + key);
                        pesan.removeClass('has-danger');
                        text.text(null);
                    });
                    swal({
                        title: "Pesan!",
                        text: data.data.message,
                        icon: data.data.icon,
                    })
                    form.reset();
                } else {
                    $.each(data.data.errors, function (key, value) {
                        let pesan = $(`#` + key).parent();
                        let text = $('.' + key);
                        pesan.removeClass('has-danger');
                        text.text(null);
                        pesan.addClass('has-danger');
                        text.text(value);
                    });
                    swal({
                        title: "Pesan!",
                        text: data.data.message,
                        icon: "error",
                    });
                }
            })
            .catch(err => {
                self.text('Izin');
                self.removeAttr('disabled');
                alert("maaf ada kesalahan diserver");
                console.log(err)
            });
        });

        $('#tanggal').change(function(){
             $('#table-permohonan').DataTable().ajax.reload(null, false);
        });

        $('#table-permohonan').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax:{
                url  : "{{url('karyawan/izin/table')}}",
                data : {
                    tanggal:function() { return $('#tanggal').val() },
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'jenisijin',
                    name: 'jenisijin'
                },  
                {
                    data: 'keterangan',
                    name: 'keterangan',
                    "render": function ( data, type, row, meta ) {
                        return wordWrap(data,40);
                    }
                },
                {
                    data: 'tanggal_ijin',
                    name: 'tanggal_ijin', 
                },
                {
                    data: 'status_ijin',
                    name: 'status_ijin'
                },
            ],
            "order": [
                [1, "asc"]
            ],
        })
    });
</script>
@endsection