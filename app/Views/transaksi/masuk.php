<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Barang Masuk</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>


    <!-- Tampilkan pesan sukses jika berhasil nambah data -->
    <?php if (session()->getFlashdata('success_masuk')) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo session()->getFlashdata('success_masuk') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    <?php endif; ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahBarangMasuk">
                Tambah Barang Masuk
            </button>
            <!-- Modal Tambah Barang Masuk  -->
            <div class="modal fade" id="ModalTambahBarangMasuk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="FormModalLabel">Tambah Barang Masuk</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" action="<?= base_url("barang/masuk/tambah") ?> ">
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
                                    <label for="tanggalMasuk">Tanggal Masuk</label>
                                    <input type="date" class="form-control mb-2" name="tanggalMasuk" placeholder="Tanggal Masuk ">
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" class="form-control mb-2" name="keterangan" placeholder="Keterangan ...">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="BtnTambahBarangMasuk">Tambah</button>
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
                            <th>Tanggal Masuk</th>
                            <th>Kode Barang</th>
                            <th>Supplier</th>
                            <th>Nama Barang </th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Index</th>
                            <th>Tanggal Masuk</th>
                            <th>Kode Barang</th>
                            <th>Supplier</th>
                            <th>Nama Barang </th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>

                        </tr>
                    </tfoot>
                    <tbody>
                        <?php if (count($listMasuk) > 0) : ?>
                            <?php $index = 1;
                            foreach ($listMasuk as $row) : ?>
                                <tr>
                                    <td><?= $index++ ?></td>
                                    <td><?= $row['tanggal_masuk'] ?></td>
                                    <td><?= $row['kode_barang'] ?></td>
                                    <td><?= $row['nama_supplier'] ?></td>
                                    <td><?= $row['nama_barang'] ?></td>
                                    <td><?= $row['jumlah_barang'] ?></td>
                                    <td><?= $row['harga_beli'] ?></td>
                                    <td><?= $row['total_biaya_masuk'] ?></td>
                                    <td><?= $row['keterangan_masuk'] ?></td>

                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#ModalEditBarangMasuk<?= $row['id_masuk'] ?>"><i class="fa-solid fa-pen-to-square" style="color: #107d98;"></i></a> | <a data-bs-toggle="modal" data-bs-target="#ModalDeleteBarangMasuk<?= $row['id_masuk'] ?>"><i class="fa-solid fa-trash" style="color: #ce4040;"></i></a>
                                    </td>

                                </tr>

                                <!-- modal Edit  -->
                                <div class="modal fade" id="ModalEditBarangMasuk<?= $row['id_masuk']  ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="FormModalLabel">Edit Barang Masuk</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form method="post" action="<?= base_url("barang/masuk/edit") ?>">
                                                <!-- passing id untuk edit   -->
                                                <input type="hidden" name="IdBarang" value="<?= $row['id'] ?>">
                                                <input type="hidden" name="IdBarangMasuk" value="<?= $row['id_masuk']  ?>">

                                                <div class="modal-body">
                                                    <div class="form-floating mb-3">
                                                        <label for="namaBarang">Nama Barang</label>
                                                        <input type="text" class="form-control" name="namaBarang" value="<?= $row['nama_barang'] ?>" readonly>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="tanggalMasuk">Tanggal Masuk</label>
                                                        <input type="date" class="form-control mb-2" name="tanggalMasuk" value="<?= $row['tanggal_masuk'] ?>" required>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="jumlahBarang">Jumlah Barang</label>
                                                        <input type="number" class="form-control mb-2" name="jumlahBarang" value="<?= $row['jumlah_barang'] ?>" required>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="keterangan">Keterangan</label>
                                                        <input type="text" class="form-control mb-2" name="keterangan" value="<?= $row['keterangan_masuk'] ?>">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="BtnEditBarangMasuk">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- modal Delete -->
                                <div class="modal fade" id="ModalDeleteBarangMasuk<?= $row['id_masuk'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="FormModalLabel">Hapus Barang Masuk?</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form method="post" action="<?= base_url("barang/masuk/delete") ?>">
                                                <!-- passing id untuk delete   -->
                                                <input type="hidden" name="IdBarangMasuk" value="<?= $row['id_masuk'] ?>">
                                                <input type="hidden" name="jumlahBarang" value="<?= $row['jumlah_barang'] ?>">
                                                <input type="hidden" name="IdBarang" value="<?= $row['id'] ?>">
                                                <div class="modal-body">
                                                    <h4>Apakah Anda Yakin Ingin Menghapus <?= $row['nama_barang'] ?></h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger" name="BtnHapusBarangMasuk">Hapus</button>
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