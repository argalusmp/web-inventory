<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Supplier</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- Tampilkan pesan sukses jika berhasil nambah data -->
    <?php if (session()->getFlashdata('success_supplier')) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo session()->getFlashdata('success_supplier') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    <?php endif; ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahSupplier">
                Tambah Supplier
            </button>

            <div class="modal fade" id="ModalTambahSupplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="FormModalLabel">Tambah Supplier</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" action="<?= base_url("supplier/tambah") ?>">
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <label for="namaSupplier">Nama Supplier</label>
                                    <input type="text" class="form-control" name="namaSupplier" placeholder="Nama Supplier" required>
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="alamatSupplier">Alamat</label>
                                    <input type="text" class="form-control" name="alamatSupplier" placeholder="Alamat Supplier" required>
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="emailSupplier">Email</label>
                                    <input type="email" class="form-control mb-2" name="emailSupplier" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="BtnTambahSupplier">Tambah</button>
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
                            <th>Nama </th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Index</th>
                            <th>Nama</th>
                            <th>Email</th>
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
                                    <td><?= $row['nama_supplier'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['alamat'] ?></td>
                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#ModalEditSupplier<?= $row['id_supplier'] ?>"><i class="fa-solid fa-pen-to-square" style="color: #107d98;"></i></a> | <a data-bs-toggle="modal" data-bs-target="#ModalDeleteSupplier<?= $row['id_supplier'] ?>"><i class="fa-solid fa-trash" style="color: #ce4040;"></i></a>
                                    </td>
                                </tr>

                                <!-- modal Edit  -->
                                <div class="modal fade" id="ModalEditSupplier<?= $row['id_supplier'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="FormModalLabel">Edit Supplier</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form method="post" action="<?= base_url("supplier/edit") ?>">
                                                <!-- passing id untuk edit   -->
                                                <input type="hidden" name="IdSupplierEdit" value="<?= $row['id_supplier'] ?>">

                                                <div class="modal-body">
                                                    <div class="form-floating mb-3">
                                                        <label for="nama">Nama Supplier</label>
                                                        <input type="text" class="form-control" name="namaSupplier" autocomplete="off" value="<?= $row['nama_supplier'] ?>" required>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control mb-2" name="emailSupplier" value="<?= $row['email'] ?>" required>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="alamat">Alamat</label>
                                                        <input type="text" class="form-control" name="alamatSupplier" autocomplete="off" value="<?= $row['alamat'] ?>" required>
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
                                <div class="modal fade" id="ModalDeleteSupplier<?= $row['id_supplier'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="FormModalLabel">Hapus Supplier ?</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form method="post" action="<?= base_url("supplier/delete") ?>">
                                                <!-- passing id untuk delete   -->
                                                <input type="hidden" name="IdSupplierHapus" value="<?= $row['id_supplier']  ?>">
                                                <div class="modal-body">
                                                    <h4>Apakah Anda Yakin Ingin Menghapus <?= $row['nama_supplier']  ?></h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger" name="BtnHapusSupplier">Hapus</button>
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