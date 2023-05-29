<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Daftar Barang</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- Tampilkan pesan sukses jika berhasil nambah data -->
    <?php if (session()->getFlashdata('success_barang')) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo session()->getFlashdata('success_barang') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    <?php endif; ?>
    <!-- Tampilkan pesan gagal jika gambar tidak terverifikasi -->
    <?php if (session()->getFlashdata('error_gambar')) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo session()->getFlashdata('error_gambar') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    <?php endif; ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahBarang">
                Tambah Barang
            </button>

            <div class="modal fade" id="ModalTambahBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="FormModalLabel">Tambah Barang</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" action="<?= base_url("/barang/tambah") ?>" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <label for="namaBarang">Nama Barang</label>
                                    <input type="text" class="form-control" name="namaBarang" placeholder="nama barang" required>
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="kodeBarang">Kode Barang</label>
                                    <input type="text" class="form-control" name="kodeBarang" placeholder="kode barang" required>
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="Supplier">Supplier</label>
                                    <select class="form-control mb-2" name="supplier" aria-label="Default select example">
                                        <?php
                                        foreach ($listSupplier as $row) : ?>
                                            <option value="<?= $row['id_supplier']; ?>"><?= $row['nama_supplier']; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="hargaBeli">Harga Beli</label>
                                    <input type="number" class="form-control mb-2" name="hargaBeli" placeholder="Harga Beli" required>
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="hargaJual">Harga Jual</label>
                                    <input type="number" class="form-control mb-2" name="hargaJual" placeholder="Harga Jual" required>
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" class="form-control mb-2" name="keterangan" placeholder="Keterangan ...">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="fileInput">Input Gambar</label>

                                    <div class="custom-file">
                                        <!-- Menggunakan js untuk preview dan otomisasi nama di label nya, func ada di footer template -->
                                        <input type="file" class="custom-file-input" name="gambar" id="gambar" aria-describedby="fileInputAddon" onchange="previewImg()">
                                        <label class="custom-file-label" for="fileInput">Pilih file</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <img src="<?= base_url("img/uploads/default_img.jpg") ?>" alt="gambar" class="img-thumbnail img-preview">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="BtnTambahBarang">Tambah</button>
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
                            <th>Gambar</th>
                            <th>Nama Barang</th>
                            <th>Kode Barang</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Supplier</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Index</th>
                            <th>Gambar</th>
                            <th>Nama Barang</th>
                            <th>Kode Barang</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Supplier</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php if (count($list) > 0) : ?>
                            <?php $i = 1;
                            foreach ($list as $row) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td>
                                        <?php if ($row['gambar_barang'] !== null) : ?>
                                            <?php $imagePath = base_url('/img/uploads/' . $row['gambar_barang']); ?>
                                            <img src="<?= $imagePath ?>" width="150" height="150" style="object-fit: cover;" alt="Product Image">
                                        <?php else : ?>
                                            <span>No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $row['nama_barang'] ?></td>
                                    <td><?= $row['kode_barang'] ?></td>
                                    <td><?= $row['harga_beli'] ?></td>
                                    <td><?= $row['harga_jual'] ?></td>
                                    <td><?= $row['nama_supplier'] ?></td>
                                    </td>
                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#ModalEditBarang<?= $row['id'] ?>"><i class="fa-solid fa-pen-to-square" style="color: #107d98;"></i></a> | <a data-bs-toggle="modal" data-bs-target="#ModalDeleteBarang<?= $row['id'] ?>"><i class="fa-solid fa-trash" style="color: #ce4040;"></i></a>
                                    </td>
                                </tr>

                                <!-- modal Edit  -->
                                <div class="modal fade" id="ModalEditBarang<?= $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="FormModalLabel">Edit Barang</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form method="post" action="<?= base_url("/barang/edit") ?>">
                                                <!-- passing id untuk edit   -->
                                                <input type="hidden" name="IdBarangEdit" value="<?= $row['id'] ?>">

                                                <div class="modal-body">
                                                    <div class="form-floating mb-3">
                                                        <label for="subjek">Nama Barang</label>
                                                        <input type="text" class="form-control" name="namaBarang" value="<?= $row['nama_barang'] ?>" required>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="kodeBarang">Kode Barang</label>
                                                        <input type="text" class="form-control mb-2" name="kodeBarang" value="<?= $row['kode_barang'] ?>" required>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="hargaBeli">Harga Beli</label>
                                                        <input type="number" class="form-control mb-2" name="hargaBeli" value="<?= $row['harga_beli']  ?>" required>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="hargaBeli">Harga Jual</label>
                                                        <input type="number" class="form-control mb-2" name="hargaJual" value="<?= $row['harga_jual'] ?>" required>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="BtnEditBarang">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- modal Delete -->
                                <div class="modal fade" id="ModalDeleteBarang<?= $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="FormModalLabel">Hapus Barang ?</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form method="post" action="<?= base_url("/barang/delete") ?>">
                                                <!-- passing id untuk delete   -->
                                                <input type="hidden" name="IdBarangHapus" value="<?= $row['id'] ?>">
                                                <div class="modal-body">
                                                    <h4>Apakah Anda Yakin Ingin Menghapus <?= $row['nama_barang'] ?></h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger" name="BtnHapusBarang">Hapus</button>
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