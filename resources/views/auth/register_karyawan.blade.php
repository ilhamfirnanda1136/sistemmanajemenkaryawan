
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register Karyawan</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('')}}/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{asset('')}}/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{asset('')}}/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="{{asset('')}}/assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="{{asset('')}}/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End Plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('')}}/assets/css/shared/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" />
  </head>
  <body>
    <div class="container-scroller">
     @if(Session::has('successMSG'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil &nbsp</strong>{{session('successMSG')}}.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth bg-dark theme-one">
          <div class="row w-100">
            <div class="col-lg-4 mx-auto">
              <div class="auto-form-wrapper">
                  <div class="float-right">
                      <a href="{{url('karyawan/login')}}" class="btn btn-success">login karyawan</a>
                  </div>
                <h4 class="text-center">REGISTER KARYAWAN </h4>
                <form method="post" id="formSubmit" >
                  @csrf
                    <div class="form-group">
                        <label for="nama">Nama *</label>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama">
                        <small class="text-danger nama"></small>
                    </div>
                    <div class="form-group">
                        <label for="username">Username *</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan Username">
                        <small class="text-danger username"></small>
                    </div>
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir *</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir">
                        <small class="text-danger tempat_lahir"></small>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">tanggal lahir *</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
                        <small class="text-danger tanggal_lahir"></small>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat *</label>
                        <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukkan ALamat"></textarea>
                        <small class="text-danger alamat"></small>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <small class="text-danger jenis_kelamin"></small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password">
                        <small class="text-danger password"></small>
                    </div>
                  <div class="form-group">
                    <button type="button" name="submit" id="submit" class="btn btn-primary submit-btn btn-block">Register Karyawan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>

    <script src="{{asset('')}}/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="{{asset('')}}/assets/vendors/sweetalert/sweetalert.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#submit').click(async function () {
                let form = $('#formSubmit')[0];
                let formdata = new FormData(form);
                let self = $(this);
                self.text('Loading....');
                self.attr('disabled','true');
                await axios({
                    method: "post",
                    data: formdata,
                    url: "{{ route('register') }}",
                }).then(data => {
                    self.text('Register Karyawan');
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
                        }).then(() => location.href="{{url('karyawan/login')}}")
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
                    self.text('Register Karyawan');
                    self.removeAttr('disabled');
                    alert("maaf ada kesalahan diserver");
                    console.log(err)
                });
            });
        });
    </script>
  </body>
</html>