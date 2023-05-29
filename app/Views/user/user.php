<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data User</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- Tampilkan pesan sukses jika berhasil nambah data -->
    <?php if (session()->getFlashdata('success_user')) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo session()->getFlashdata('success_user') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    <?php endif; ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- Button trigger tambah modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahUser">
                Tambah User
            </button>

            <div class="modal fade" id="ModalTambahUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="FormModalLabel">Tambah User</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" action="<?= base_url("user/tambah") ?>">
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control mb-2" name="username" autocomplete="off" placeholder="Username.." required>
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control mb-2" name="email" placeholder="Email" required>
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="nohp">Password</label>
                                    <input type="password" class="form-control mb-2" name="password" autocomplete="off" placeholder="Password.." required>
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="nohp">No Hp</label>
                                    <input type="text" class="form-control mb-2" name="nohp" autocomplete="off" placeholder="No Hp Format +628.." required>
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" class="form-control mb-2" name="alamat" autocomplete="off" placeholder="Alamat..." required>
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="tingkatan">Tingkatan</label>
                                    <select name="tingkatanUser" class="form-control mb-2">
                                        <option value='user'>User Biasa</option>
                                        <option value='admin'>Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="BtnTambahUser">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Index</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>No Hp</th>
                            <th>Level</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Index</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>No Hp</th>
                            <th>Level</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php if (count($list) > 0) : ?>
                            <?php $i = 1;
                            foreach ($list as $row) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $row['username'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['no_hp'] ?></td>
                                    <td><?= $row['user_type'] ?></td>
                                    <td><?= $row['alamat'] ?></td>
                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#ModalEditUser<?= $row['id_user'] ?>"><i class="fa-solid fa-pen-to-square" style="color: #107d98;"></i></a> | <a data-bs-toggle="modal" data-bs-target="#ModalDeleteUser<?= $row['id_user'] ?>"><i class="fa-solid fa-trash" style="color: #ce4040;"></i></a>
                                    </td>
                                </tr>

                                <!-- modal Edit  -->
                                <div class="modal fade" id="ModalEditUser<?= $row['id_user'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="FormModalLabel">Edit User</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form method="post" action="<?= base_url("user/edit") ?>">
                                                <!-- passing id untuk edit   -->
                                                <input type="hidden" name="IdUserEdit" value="<?= $row['id_user'] ?>">

                                                <div class="modal-body">
                                                    <div class="form-floating mb-3">
                                                        <label for="username">Username</label>
                                                        <input type="text" class="form-control" name="username" autocomplete="off" value="<?= $row['username'] ?>" required>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control mb-2" name="email" value="<?= $row['email'] ?>" required>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="nohp">No Hp</label>
                                                        <input type="text" class="form-control" name="nohp" autocomplete="off" value="<?= $row['no_hp'] ?>" required>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="alamat">Alamat</label>
                                                        <input type="text" class="form-control" name="alamat" autocomplete="off" value="<?= $row['alamat'] ?>" required>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <label for="tingkatanUser">Tingkatan</label>
                                                        <select name="tingkatanUser" class="form-control mb-2">
                                                            <option value="<?= $row['user_type'] ?>" selected><?= $row['user_type'] ?></option>
                                                            <option value='user'>User Biasa</option>
                                                            <option value='admin'>Admin</option>
                                                        </select>

                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="BtnEditUser">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- modal Delete -->
                                <div class="modal fade" id="ModalDeleteUser<?= $row['id_user'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="FormModalLabel">Hapus User ?</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form method="post" action="<?= base_url("/user/delete") ?>">
                                                <!-- passing id untuk delete   -->
                                                <input type="hidden" name="IdUserHapus" value="<?= $row['id_user']  ?>">
                                                <div class="modal-body">
                                                    <h4>Apakah Anda Yakin Ingin Menghapus <?= $row['username']  ?></h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger" name="BtnHapusUser">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->