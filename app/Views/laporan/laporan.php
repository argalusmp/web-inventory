<!-- Begin Page Content -->
<div class="container-fluid">




    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Laporan</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 d-flex">

        <div class="card-header py-3 d-flex">
            <form action="<?= base_url("/laporan/export") ?>" method="post" class="pt-3">
                <button type="submit" class="btn btn-primary">
                    Export Laporan
                </button>
            </form>



            <form action="<?= base_url("/laporan/filter") ?>" method="post" class="d-flex">

                <select name="filterData" id="filterData" class="form-select form-control m-3 " aria-label="Default select example">
                    <option value="semua" <?php if (isset($_POST['filterData']) && $_POST['filterData'] == "semua") echo "selected='selected'"; ?> selected>Semua</option>
                    <option value="periode" <?php if (isset($_POST['filterData']) && $_POST['filterData'] == "periode") echo "selected='selected'"; ?>>Berdasarkan Periode</option>
                </select>

                <select name="filterBulan" id="filterBulan" class="form-select form-control m-3" aria-label="Default select example">
                    <option value="01" <?php if (isset($_POST['filterBulan']) && $_POST['filterBulan'] == "01") echo "selected='selected'"; ?>>Januari</option>
                    <option value="02" <?php if (isset($_POST['filterBulan']) && $_POST['filterBulan'] == "02") echo "selected='selected'"; ?>>Februari</option>
                    <option value="03" <?php if (isset($_POST['filterBulan']) && $_POST['filterBulan'] == "03") echo "selected='selected'"; ?>>Maret</option>
                    <option value="04" <?php if (isset($_POST['filterBulan']) && $_POST['filterBulan'] == "04") echo "selected='selected'"; ?>>April</option>
                    <option value="05" <?php if (isset($_POST['filterBulan']) && $_POST['filterBulan'] == "05") echo "selected='selected'"; ?>>Mei</option>
                    <option value="06" <?php if (isset($_POST['filterBulan']) && $_POST['filterBulan'] == "06") echo "selected='selected'"; ?>>Juni</option>
                    <option value="07" <?php if (isset($_POST['filterBulan']) && $_POST['filterBulan'] == "07") echo "selected='selected'"; ?>>Juli</option>
                    <option value="08" <?php if (isset($_POST['filterBulan']) && $_POST['filterBulan'] == "08") echo "selected='selected'"; ?>>Agustus</option>
                    <option value="09" <?php if (isset($_POST['filterBulan']) && $_POST['filterBulan'] == "09") echo "selected='selected'"; ?>>September</option>
                    <option value="10" <?php if (isset($_POST['filterBulan']) && $_POST['filterBulan'] == "10") echo "selected='selected'"; ?>>Oktober</option>
                    <option value="11" <?php if (isset($_POST['filterBulan']) && $_POST['filterBulan'] == "11") echo "selected='selected'"; ?>>November</option>
                    <option value="12" <?php if (isset($_POST['filterBulan']) && $_POST['filterBulan'] == "12") echo "selected='selected'"; ?>>Desember</option>
                </select>



                <select name="filterTahun" id="filterTahun" class="form-select form-control m-3" aria-label="Default select example">
                    <option value="2021" <?php if (isset($_POST['filterTahun']) && $_POST['filterTahun'] == "2021") echo "selected='selected'"; ?>>2021</option>
                    <option value="2022" <?php if (isset($_POST['filterTahun']) && $_POST['filterTahun'] == "2022") echo "selected='selected'"; ?>>2022</option>
                    <option value="2023" <?php if (isset($_POST['filterTahun']) && $_POST['filterTahun'] == "2023") echo "selected='selected'"; ?>>2023</option>
                    <option value="2024" <?php if (isset($_POST['filterTahun']) && $_POST['filterTahun'] == "2024") echo "selected='selected'"; ?>>2024</option>
                </select>

                <button type="submit" name="searchData" id="searchData" class="btn btn-primary m-3">Search</button>
            </form>


        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Index</th>
                            <th>Nama Barang</th>
                            <th>Harga Jual </th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Sisa</th>
                            <th>Laba Bersih</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Index</th>
                            <th>Nama Barang</th>
                            <th>Harga Jual </th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Sisa</th>
                            <th>Laba Bersih</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php if (count($listLaporan) > 0) : ?>
                            <?php $i = 1;
                            foreach ($listLaporan as $row) :
                                $selisih = $row['total_masuk'] - $row['total_keluar']
                            ?>

                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $row['nama_barang'] ?></td>
                                    <td><?= $row['harga_jual'] ?></td>
                                    <td><?= $row['total_masuk'] ?></td>
                                    <td><?= $row['total_keluar'] ?></td>
                                    <td><?= $selisih ?></td>
                                    <td><?= $row['laba_bersih'] ?></td>
                                </tr>

                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>



        </form>

    </div>

</div>
<!-- /.container-fluid -->