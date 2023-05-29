<?php

namespace App\Controllers;
///masih error

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\TransaksiKeluar;
use App\Models\TransaksiMasuk;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends BaseController
{
    protected $session;
    protected $data;
    protected $barangModel;
    protected $masukModel;
    protected $keluarModel;


    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->masukModel = new TransaksiMasuk();
        $this->keluarModel = new TransaksiKeluar();
        $this->session = \Config\Services::session();
        $this->data["session"] = $this->session;
    }



    public function index()
    {
        $this->data['listLaporan'] = $this->barangModel->select('barang.id, barang.harga_jual, barang.harga_beli,
        IFNULL((SELECT SUM(jumlah_barang) FROM masuk WHERE id_barang = barang.id), 0) AS total_masuk,
        IFNULL((SELECT SUM(jumlah_barang) FROM keluar WHERE id_barang = barang.id), 0) AS total_keluar,
        IFNULL(((SELECT SUM(jumlah_barang) FROM keluar WHERE id_barang = barang.id) * barang.harga_jual) - ((SELECT SUM(jumlah_barang) FROM keluar WHERE id_barang = barang.id) * barang.harga_beli), 0) AS laba_bersih,
        barang.nama_barang
        ')->findAll();

        echo view('template/header', $this->data);
        echo view('laporan/laporan', $this->data);
        echo view('template/footer');
    }


    public function filterData()
    {
        $filterData = $this->request->getPost('filterData');
        $bulan = $this->request->getPost('filterBulan');
        $tahun = $this->request->getPost('filterTahun');

        if ($filterData == 'semua') {
            $this->data['listLaporan'] = $this->barangModel->select('barang.id, barang.harga_jual,barang.harga_beli, 
            IFNULL((SELECT SUM(jumlah_barang) FROM masuk WHERE id_barang = barang.id), 0) AS total_masuk, 
            IFNULL((SELECT SUM(jumlah_barang) FROM keluar WHERE id_barang = barang.id), 0) AS total_keluar,
            IFNULL((((SELECT SUM(jumlah_barang) FROM keluar WHERE id_barang = barang.id) * barang.harga_jual) - ((SELECT SUM(jumlah_barang) FROM keluar WHERE id_barang = barang.id) * barang.harga_beli)),0 ) AS laba_bersih,
            barang.nama_barang')->findAll();
        } else {
            $this->data['listLaporan'] = $this->barangModel->select('barang.id,barang.harga_jual,barang.harga_beli,
            IFNULL((SELECT SUM(jumlah_barang) FROM masuk WHERE id_barang = barang.id AND MONTH(tanggal_masuk)=' . $bulan . ' AND YEAR(tanggal_masuk)=' . $tahun . '), 0) AS total_masuk, 
            IFNULL((SELECT SUM(jumlah_barang) FROM keluar WHERE id_barang = barang.id AND MONTH(tanggal_keluar)=' . $bulan . ' AND YEAR(tanggal_keluar)=' . $tahun . '), 0) AS total_keluar,
            IFNULL((((SELECT SUM(jumlah_barang) FROM keluar WHERE id_barang = barang.id AND MONTH(tanggal_keluar)=' . $bulan . ' AND YEAR(tanggal_keluar)=' . $tahun . ' ) * barang.harga_jual) - ((SELECT SUM(jumlah_barang) FROM keluar WHERE id_barang = barang.id AND MONTH(tanggal_keluar)=' . $bulan . ' AND YEAR(tanggal_keluar)=' . $tahun . ') * barang.harga_beli)),0 ) AS laba_bersih,
            barang.nama_barang')->findAll();
        }
        //menyimpan data filter agar dipakai ketika export

        $this->session->remove('filterBulan');
        $this->session->remove('filterTahun');
        $this->session->remove('filterData');
        $this->session->set(['filterData' => $filterData, 'filterBulan' => $bulan, 'filterTahun' => $tahun]);
        echo view('template/header', $this->data);
        echo view('laporan/laporan', $this->data);
        echo view('template/footer');
    }

    public function export()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->getProperties()->setCreator("Nama Penulis")
            ->setLastModifiedBy("Nama Penulis")
            ->setTitle("Judul Laporan")
            ->setSubject("Subject Laporan")
            ->setDescription("Deskripsi Laporan")
            ->setKeywords("Laporan, Excel")
            ->setCategory("Kategori Laporan");



        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:A2')
            ->setCellValue('A1', 'No')
            ->mergeCells('B1:B2')
            ->setCellValue('B1', 'Kode Barang')
            ->mergeCells('C1:C2')
            ->setCellValue('C1', 'Nama Barang')
            ->mergeCells('D1:F1')
            ->setCellValue('D1', 'Stock Awal')
            ->setCellValue('D2', 'QTY')
            ->setCellValue('E2', 'Rp/Stn')
            ->setCellValue('F2', 'Total')
            ->mergeCells('G1:I1')
            ->setCellValue('G1', 'Penerimaan')
            ->setCellValue('G2', 'Jumlah')
            ->setCellValue('H2', 'Rp/Stn')
            ->setCellValue('I2', 'Total')
            ->mergeCells('J1:L1')
            ->setCellValue('J1', 'Pengeluaran')
            ->setCellValue('J2', 'Jumlah')
            ->setCellValue('K2', 'Rp/Stn')
            ->setCellValue('L2', 'Total')
            ->mergeCells('M1:M2')
            ->setCellValue('M1', 'Sisa Stock')
            ->mergeCells('N1:N2')
            ->setCellValue('N1', 'Laba Bersih');



        $filterData = $this->session->get('filterData');
        $bulan = $this->session->get('filterBulan');
        $tahun = $this->session->get('filterTahun');



        if ($filterData == 'semua') {

            $query = $this->barangModel->select("barang.id,
            IFNULL((SELECT SUM(jumlah_barang) FROM masuk WHERE id_barang = barang.id), 0) AS total_masuk, 
            IFNULL((SELECT SUM(jumlah_barang) FROM keluar WHERE id_barang = barang.id), 0) AS total_keluar,
            IFNULL((SELECT SUM(jumlah_barang) FROM masuk WHERE id_barang = barang.id AND YEAR(tanggal_masuk) < '2000'),0) AS total_stock_awal, 
            barang.nama_barang, barang.harga_beli, barang.harga_jual, barang.kode_barang")->findAll();
        } else {
            $query = $this->barangModel->select('barang.id,
            IFNULL((SELECT SUM(jumlah_barang) FROM masuk WHERE id_barang = barang.id AND MONTH(tanggal_masuk)=' . $bulan . ' AND YEAR(tanggal_masuk)=' . $tahun . '), 0) AS total_masuk, 
            IFNULL((SELECT SUM(jumlah_barang) FROM keluar WHERE id_barang = barang.id AND MONTH(tanggal_keluar)=' . $bulan . ' AND YEAR(tanggal_keluar)=' . $tahun . '), 0) AS total_keluar,
            IFNULL((SELECT SUM(jumlah_barang) FROM masuk WHERE id_barang = barang.id AND YEAR(tanggal_masuk) < ' . $tahun . ' OR (YEAR(tanggal_masuk) = ' . $tahun . ' AND MONTH(tanggal_masuk) < ' . $bulan . ')), 0) 
            - IFNULL((SELECT SUM(jumlah_barang) FROM keluar WHERE id_barang = barang.id AND YEAR(tanggal_keluar) < ' . $tahun . ' OR (YEAR(tanggal_keluar) = ' . $tahun . ' AND MONTH(tanggal_keluar) < ' . $bulan . ')), 0) AS total_stock_awal,
            barang.nama_barang,  barang.harga_beli, barang.harga_jual, barang.kode_barang')->findAll();
        }

        // ...

        $index = 3;
        $nomor = 1;


        // ...

        $index = 3;
        $nomor = 1;
        foreach ($query as $barang) {

            $idBarang = $barang['id'];
            $kodeBarang = $barang['kode_barang'];
            $namaBarang = $barang['nama_barang'];
            $hargamasuk = $barang['harga_beli'];
            $hargajual = $barang['harga_jual'];
            $stockAwal = $barang['total_stock_awal'];
            $masuk = $barang['total_masuk'];
            $keluar = $barang['total_keluar'];
            $profit = ($barang['total_keluar'] * $barang['harga_jual']) - ($barang['total_keluar'] * $barang['harga_beli']);

            $total_stockAwal = $stockAwal * $hargajual;
            $total_stockMasuk = $masuk * $hargamasuk;
            $total_stockJual = $keluar * $hargajual;

            //Stock Akhir 
            $stockAkhir = $stockAwal + $masuk - $keluar;
            $total_stockAkhir = $stockAkhir * $hargajual;

            $sheet->setCellValue('A' . $index, $nomor)
                ->setCellValue('B' . $index, $kodeBarang)
                ->setCellValue('C' . $index, $namaBarang)
                ->setCellValue('D' . $index, $stockAwal)
                ->setCellValue('E' . $index, $hargajual)
                ->setCellValue('F' . $index, $total_stockAwal)
                ->setCellValue('G' . $index, $masuk)
                ->setCellValue('H' . $index, $hargamasuk)
                ->setCellValue('I' . $index, $total_stockMasuk)
                ->setCellValue('J' . $index, $keluar)
                ->setCellValue('K' . $index, $hargajual)
                ->setCellValue('L' . $index, $total_stockJual)
                ->setCellValue('M' . $index, $stockAkhir)
                ->setCellValue('N' . $index, $profit);

            $index++;
            $nomor++;
        }


        foreach (range('A', 'N') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $alignment_center = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER;

        foreach ($sheet->getRowIterator() as $row) {
            foreach ($row->getCellIterator() as $cell) {
                $cellCoordinate = $cell->getCoordinate();
                $sheet->getStyle($cellCoordinate)->getAlignment()->setHorizontal($alignment_center);
            }
        }


        // Tentukan nama file yang akan dihasilkan
        $filename = "laporan.xlsx";

        // Set header untuk memunculkan dialog download pada browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Ekspor file Excel ke browser
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
}
