@extends('layout.app')
@section('title', 'DASHBOARD')
@section('konten')

<div class="container" style="margin-top: 50px">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-md mt-4">
                <div class="card-body">
                    <h4 class="text-left">KONTRAK</h4>

                    <div class="text-right">
                        <a href="javascript:void(0)" class="btn btn-success mb-2" id="btn-create-post">TAMBAH KONTRAK</a>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-posts">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="pegawaiDialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" name="_form" id="_form" novalidate>
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">POST</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" value="0">

                    <div class="form-group">
                        <label for="id_pegawai" class="control-label">Nama Pegawai</label>
                        <select class="form-control" id="id_pegawai">
                            <option>Pilih Pegawai</option>
                        </select>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-id-pegawai"></div>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_mulai" class="control-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tanggal-mulai"></div>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_selesai" class="control-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tanggal-selesai"></div>
                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="button" class="btn btn-primary" id="simpan">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>



</div>



<script>
    //action create post
    $('#simpan').click(function(e) {
        e.preventDefault();
        let id = $('#id').val();

        //define variable
        let id_pegawai = $('#id_pegawai').val();
        let tanggal_mulai = $('#tanggal_mulai').val();
        let tanggal_selesai = $('#tanggal_selesai').val();
        let token = $("meta[name='csrf-token']").attr("content");

        //jika id lebih dari 0 maka update
        if (id > 0) {

            //ajax
            $.ajax({

                url: `/api/kontrak/${id}`,
                type: "PUT",
                cache: false,
                data: {
                    "id_pegawai": id_pegawai,
                    "tanggal_mulai": tanggal_mulai,
                    "tanggal_selesai": tanggal_selesai,
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
                                    <tr id="index_${response.data.kontrak_id}">
                                    <td>${response.data.pegawai_nama}</td>
                                    <td>${response.data.kontrak_tanggal_mulai}</td>
                                    <td>${response.data.kontrak_tanggal_selesai}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.kontrak_id}" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
</svg></a>
                                        <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.kontrak_id}" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
</svg></a>
                                    </td>
                                    </tr>
                                `;

                    //append to post data
                    $(`#index_${response.data.kontrak_id}`).replaceWith(post);

                    //clear form
                    $('#id_pegawai').val('');
                    $('#tanggal_mulai').val('');
                    $('#tanggal_selesai').val('');
                    //close modal
                    $('#pegawaiDialog').modal('hide');


                },
                error: function(error) {

                }

            });

        } else {

            //ajax
            $.ajax({

                url: `/api/kontrak`,
                type: "POST",
                cache: false,
                data: {
                    "id_pegawai": id_pegawai,
                    "tanggal_mulai": tanggal_mulai,
                    "tanggal_selesai": tanggal_selesai,
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
                                    <tr id="index_${response.data.kontrak_id}">
                                    <td>${response.data.pegawai_nama}</td>
                                    <td>${response.data.kontrak_tanggal_mulai}</td>
                                    <td>${response.data.kontrak_tanggal_selesai}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.kontrak_id}" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
</svg></a>
                                        <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.kontrak_id}" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
</svg></a>
                                    </td>
                                    </tr>
                                `;

                    //append to table
                    $('#table-posts').prepend(post);

                    //clear form
                    $('#id_pegawai').val('');
                    $('#tanggal_mulai').val('');
                    $('#tanggal_selesai').val('');

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

                //fetch to delete data
                $.ajax({

                    url: `/api/kontrak/${id}`,
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
        $('#id_pegawai').val('');
        $('#tanggal_mulai').val('');
        $('#tanggal_selesai').val('');

    });

    $('body').on('click', '#btn-edit-post', function() {
        let id = $(this).data('id');

        $('#id').val(id);


        $.ajax({
            url: `/api/kontrak/${id}`,
            type: "GET",
            cache: false,
            success: function(response) {
                console.log(response.data);

                //fill data to form
                $('#id_pegawai').val(response.data.pegawai_id);
                $('#tanggal_mulai').val(response.data.kontrak_tanggal_mulai);
                $('#tanggal_selesai').val(response.data.kontrak_tanggal_selesai);

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

            url: `/api/kontrak`,
            type: "GET",
            cache: false,
            success: function(response) {
                var data = response.data.data;

                for (emp in data) {

                    //data post
                    let empRow = `
<tr id="index_${data[emp].kontrak_id}">
<td>${data[emp].pegawai_nama}</td>
<td>${data[emp].kontrak_tanggal_mulai}</td>
<td>${data[emp].kontrak_tanggal_selesai}</td>
<td class="text-center">
<a href="javascript:void(0)" id="btn-edit-post" data-id="${data[emp].kontrak_id}" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
<path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
</svg></a>
<a href="javascript:void(0)" id="btn-delete-post" data-id="${data[emp].kontrak_id}" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
<path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
</svg></a>
</td>
</tr>
`;

                    //append to table
                    $('#table-posts').prepend(empRow);

                }
            },
            error: function(error) {


            }

        });
    }


    tampilkanDataPegawai();

    function tampilkanDataPegawai() {

        $.ajax({
            type: 'GET',
            url: '/api/pegawai',
            cache: false,
            dataType: 'json',
            success: function(response) {
                var data = response.data.data;

                console.log(data);

                $('#id_pegawai').empty();
                for (emp in data) {
                    $('#id_pegawai').append('<option value="' + data[emp].pegawai_id + '">' + data[emp].pegawai_nama + '</option>');
                }


            }
        });
    }
</script>


@endsection
