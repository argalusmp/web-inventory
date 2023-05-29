<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Barang Keluar</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- Tampilkan pesan sukses jika berhasil nambah data -->
    <?php if (session()->getFlashdata('success_keluar')) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo session()->getFlashdata('success_keluar') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    <?php endif; ?>

    <!-- Tampilkan pesan gagal jika gagal nambah data -->
    <?php if ($error_keluar = session()->getFlashdata('error_keluar')) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_keluar; ?>
        </div>
    <?php endif; ?>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahBarangKeluar">
                Tambah Barang Keluar
            </button>
            <!-- Modal Tambah Barang Keluar -->
            <div class="modal fade" id="ModalTambahBarangKeluar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="FormModalLabel">Tambah Barang Keluar</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" action="<?= base_url("barang/keluar/tambah") ?>">
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <label for="IDbarang">Nama Barang</label>
                                    <select class="form-control mb-2" name="IdBarang" aria-label="Default select example">
                                        <?php
                                        foreach ($listBarang as $row) : ?>
                                            <option value="<?= $row['id']; ?>"><?= $row['nama_barang']; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-floating mb-2">
                                    <label for="jumlahBarang">Jumlah Barang</label>
                                    <input type="number" class="form-control mb-2" name="jumlahBarang" placeholder="Jumlah Barang" required>
                                </div>
                                <div class="form-floating mb-2">
                                    <label for="tanggalKeluar">Tanggal Keluar</label>
                                    <input type="date" class="form-control mb-2" name="tanggalKeluar" placeholder="Tanggal Keluar">
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" class="form-control mb-2" name="keterangan" placeholder="Keterangan ...">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="BtnTambahBarangKeluar">Tambah</button>
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
                            <th>Tanggal Keluar</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga Jual</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Index</th>
                            <th>Tanggal Keluar</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga Jual</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>

                        <?php
                        if (count($listKeluar) > 0) : ?>
                            <?php $index = 1;
                            foreach ($listKeluar as $row) : ?>
                                <tr>
                                    <td><?= $index++ ?></td>
                                    <td><?= $row['tanggal_keluar'] ?></td>
                                    <td><?= $row['kode_barang'] ?></td>
                                    <td><?= $row['nama_barang'] ?></td>
                                    <td><?= $row['harga_jual'] ?></td>
                                    <td><?= $row['jumlah_barang'] ?></td>
                                    <td><?= $row['total_keluar'] ?></td>
                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#ModalEditBarangKeluar<?= $row['id_keluar'] ?>"><i class="fa-solid fa-pen-to-square" style="color: #107d98;"></i></a> | <a data-bs-toggle="modal" data-bs-target="#ModalDeleteBarangKeluar<?= $row['id_keluar'] ?>"><i class="fa-solid fa-trash" style="color: #ce4040;"></i></a>
                                    </td>

                                </tr>

                                <!-- modal Edit  -->
                                <div class="modal fade" id="ModalEditBarangKeluar<?= $row['id_keluar']  ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="FormModalLabel">Edit Barang Keluar</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form method="post" action="<?= base_url('barang/keluar/edit/' . $row['id_keluar'] . '/' . $row['id']) ?>">

                                                <div class="modal-body">
                                                    <div class="form-floating mb-3">
                                                        <label for="namaBarang">Nama Barang</label>
                                                        <input type="text" class="form-control" name="namaBarang" value="<?= $row['nama_barang'] ?>" readonly>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="tanggalKeluar">Tanggal Keluar</label>
                                                        <input type="date" class="form-control mb-2" name="tanggalKeluar" value="<?= $row['tanggal_keluar'] ?>" required>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="jumlahBarang">Jumlah Barang</label>
                                                        <input type="number" class="form-control mb-2" name="jumlahBarang" value="<?= $row['jumlah_barang'] ?>" required>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="keterangan">Keterangan</label>
                                                        <input type="text" class="form-control mb-2" name="keterangan" value="<?= $row['keterangan_keluar'] ?>">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="BtnEditBarangKeluar">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- modal Delete -->
                                <div class="modal fade" id="ModalDeleteBarangKeluar<?= $row['id_keluar'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="FormModalLabel">Hapus Barang Keluar?</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form method="post" action="<?= base_url('barang/keluar/delete/' . $row['id_keluar'] . '/' . $row['id']) ?>">
                                                <div class="modal-body">
                                                    <h4>Apakah Anda Yakin Ingin Menghapus <?= $row['nama_barang'] ?> yang keluar pada <?= $row['tanggal_keluar'] ?> </h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger" name="BtnHapusBarangKeluar">Hapus</button>
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