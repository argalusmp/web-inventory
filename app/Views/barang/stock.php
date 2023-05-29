<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Stock Barang</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3>Stock Barang</h3>
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
                            <th>Supplier</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Index</th>
                            <th>Gambar</th>
                            <th>Nama Barang</th>
                            <th>Kode Barang</th>
                            <th>Supplier</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stock</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php if (count($listStock) > 0) : ?>
                            <?php $i = 1;
                            foreach ($listStock as $row) : ?>
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
                                    <td><?= $row['nama_supplier'] ?></td>
                                    <td><?= $row['harga_beli'] ?></td>
                                    <td><?= $row['harga_jual'] ?></td>
                                    <td><?= $row['stock'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->