@extends('layout.app')
@section('title', 'DASHBOARD')
@section('konten')



<div class="container">
    <div class="jumbotron jumbotron-fluid">
        <div class="col-md-12">
            <p class="lead">Selamat datang di,</p>
            <h1 class="display-4">Sistem Data Karyawan.</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">

        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Pegawai</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $jumlah_pegawai }}</h6>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Jabatan</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $jumlah_jabatan }}</h6>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Kontrak</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $jumlah_kontrak }}</h6>
                </div>
            </div>
        </div>

    </div>
</div>



<script>
    //action create post
    $('#simpan').click(function(e) {
        e.preventDefault();
        let id = $('#id').val();

        //define variable
        let nama = $('#nama').val();
        let alamat = $('#alamat').val();
        let tanggal_lahir = $('#tanggal_lahir').val();
        let token = $("meta[name='csrf-token']").attr("content");

        //jika id lebih dari 0 maka update
        if (id > 0) {

            //ajax
            $.ajax({

                url: `/api/pegawai/${id}`,
                type: "PUT",
                cache: false,
                data: {
                    "nama": nama,
                    "alamat": alamat,
                    "tanggal_lahir": tanggal_lahir,
                    "_token": token
                },
                success: function(response) {


                    //show success message
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    //data post
                    let post = `
                                    <tr id="index_${id}">
                                    <td>${response.data.nama}</td>
                                    <td>${response.data.alamat}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" id="btn-edit-post" data-id="${id}" class="btn btn-primary btn-sm">EDIT</a>
                                        <a href="javascript:void(0)" id="btn-delete-post" data-id="${id}" class="btn btn-danger btn-sm">DELETE</a>
                                    </td>
                                    </tr>
                                `;

                    //append to post data
                    $(`#index_${id}`).replaceWith(post);

                    //clear form
                    $('#nama').val('');
                    $('#alamat').val('');
                    $('#tanggal_lahir').val('');
                    //close modal
                    $('#pegawaiDialog').modal('hide');


                },
                error: function(error) {

                }

            });

        } else {

            //ajax
            $.ajax({

                url: `/api/pegawai`,
                type: "POST",
                cache: false,
                data: {
                    "nama": nama,
                    "alamat": alamat,
                    "tanggal_lahir": tanggal_lahir,
                    "_token": token
                },
                success: function(response) {

                    //show success message
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    //data post
                    let post = `
                                    <tr id="index_${response.data.id}">
                                    <td>${response.data.nama}</td>
                                    <td>${response.data.alamat}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                                        <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                                    </td>
                                    </tr>
                                `;

                    //append to table
                    $('#table-posts').prepend(post);

                    //clear form
                    $('#nama').val('');
                    $('#alamat').val('');
                    $('#tanggal_lahir').val('');

                    //close modal
                    $('#pegawaiDialog').modal('hide');


                },
                error: function(error) {



                }

            });

        }

    });

    $('body').on('click', '#btn-delete-post', function() {

        let id = $(this).data('id');
        let token = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "ingin menghapus data ini!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, HAPUS!'
        }).then((result) => {
            if (result.isConfirmed) {

                console.log('test');

                //fetch to delete data
                $.ajax({

                    url: `/api/pegawai/${id}`,
                    type: "DELETE",
                    cache: false,
                    data: {
                        "_token": token
                    },
                    success: function(response) {

                        //show success message
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        //remove post on table
                        $(`#index_${id}`).remove();

                    }
                });


            }
        })

    });


    //button create post event
    $('body').on('click', '#btn-create-post', function() {
        $('#id').val(0);
        //open modal
        $('#pegawaiDialog').modal('show');
        $('#exampleModalLabel').html('TAMBAH DATA');


        //clear form
        $('#nama').val('');
        $('#alamat').val('');
        $('#tanggal_lahir').val('');

    });

    $('body').on('click', '#btn-edit-post', function() {
        let id = $(this).data('id');

        $('#id').val(id);


        $.ajax({
            url: `/api/pegawai/${id}`,
            type: "GET",
            cache: false,
            success: function(response) {

                //fill data to form
                $('#nama').val(response.data.nama);
                $('#alamat').val(response.data.alamat);
                $('#tanggal_lahir').val(response.data.tanggal_lahir);

                //open modal
                $('#pegawaiDialog').modal('show');
            }
        });

        //open modal
        $('#exampleModalLabel').html('EDIT DATA');

    });


    tampilkanData();

    function tampilkanData() {
        //ajax
        $.ajax({

            url: `/api/pegawai`,
            type: "GET",
            cache: false,
            success: function(response) {
                var data = response.data.data;

                if (data.length < 1 || !data) {

                    var empRow = '' +
                        '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<div class="bs-callout bs-callout-danger" id="callout-glyphicons-empty-only">' +
                        '<h4>Tidak ada daftar pegawai</h4>' +
                        '<p>Daftar pegawai akan terlihat ketika data tersedia!.</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="clearfix"></div>' +
                        '';
                    $('#able-posts').append(empRow);
                } else {

                    for (emp in data) {

                        //data post
                        let empRow = `
        <tr id="index_${data[emp].id}">
            <td>${data[emp].nama}</td>
            <td>${data[emp].alamat}</td>
            <td class="text-center">
                <a href="javascript:void(0)" id="btn-edit-post" data-id="${data[emp].id}" class="btn btn-primary btn-sm">EDIT</a>
                <a href="javascript:void(0)" id="btn-delete-post" data-id="${data[emp].id}" class="btn btn-danger btn-sm">DELETE</a>
            </td>
        </tr>
    `;

                        //append to table
                        $('#table-posts').prepend(empRow);

                    }
                }

            },
            error: function(error) {


            }

        });
    }
</script>


@endsection
