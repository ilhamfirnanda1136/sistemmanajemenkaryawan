@extends('layouts.karyawan',['title' => 'Absen Keluar Karyawan'])
@section('content')
    <div class="container">
    <div class="row profile-page justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Silahkan Absen Keluar</h3>
                    <form action="" method="post" id="formAbsenKeluar">
                        <input type="hidden" name="lat" id="lat">
                        <input type="hidden" name="lang" id="lang">
                        <input type="hidden" name="absenmasuk_id" value="{{$absenmasuk->id}}">
                        <button type="button" id="btn-absen" class="btn btn-primary btn-md col-md-12"><i class="fa fa-file-archive-o"></i> Absen Keluar</button>
                        @if(date("H") <= 17)
                            <small class="text-danger">Anda belum boleh Absen Pulang,Jika anda Ketik Absen Maka absen tidak valid</small>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('footer')
<script>

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else { 
            alert("Geolocation is not supported by this browser.");
        }
    }
    function showPosition(position) {
        $('#lat').val(position.coords.latitude);
        $('#lang').val(position.coords.longitude);
    }

    $(document).ready(function(){
        getLocation();
        $('#btn-absen').click(async function () {
            let form = $('#formAbsenKeluar')[0];
            let formdata = new FormData(form);
            let self = $(this);
            self.text('Loading....');
            self.attr('disabled','true');
            await axios({
                method: "post",
                data: formdata,
                url: "{{ url('karyawan/absen/keluar') }}",
            }).then(data => {
                self.text('Absen Keluar');
                self.removeAttr('disabled');
                if ($.isEmptyObject(data.data.errors)) {
                    $.each(data.data.success, key => {
                        let pesan = $(`#` + key);
                        let text = $('.' + key);
                        pesan.removeClass('has-danger');
                        text.text(null);
                    });
                    swal({
                        title: "Pesan!",
                        text: data.data.message,
                        icon: "success",
                    }).then(() => location.reload())
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
                self.text('Absen Keluar');
                self.removeAttr('disabled');
                alert("maaf ada kesalahan diserver");
                console.log(err)
            });
        });
    });

</script>
@endsection