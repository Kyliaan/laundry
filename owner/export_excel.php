<?php
require '../vendor/autoload.php'; 
include '../database/koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Kode Invoice');
$sheet->setCellValue('B1', 'Pelanggan');
$sheet->setCellValue('C1', 'Outlet');
$sheet->setCellValue('D1', 'Tanggal');
$sheet->setCellValue('E1', 'Batas Waktu');
$sheet->setCellValue('F1', 'Tanggal Bayar');
$sheet->setCellValue('G1', 'Status');
$sheet->setCellValue('H1', 'Dibayar');

$query = "SELECT t.kode_invoice, p.nama AS nama_pelanggan, o.nama AS nama_outlet, t.tgl, t.batas_waktu, t.tgl_bayar, t.status, t.dibayar
          FROM tb_transaksi t
          JOIN tb_member p ON t.id_member = p.id
          JOIN tb_outlet o ON t.id_outlet = o.id
          ORDER BY t.id DESC";

$result = $koneksi->query($query);
$rowNum = 2;

while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue("A$rowNum", $row['kode_invoice']);
    $sheet->setCellValue("B$rowNum", $row['nama_pelanggan']);
    $sheet->setCellValue("C$rowNum", $row['nama_outlet']);
    $sheet->setCellValue("D$rowNum", $row['tgl']);
    $sheet->setCellValue("E$rowNum", $row['batas_waktu']);
    $sheet->setCellValue("F$rowNum", $row['tgl_bayar'] ?? '-');
    $sheet->setCellValue("G$rowNum", $row['status']);
    $sheet->setCellValue("H$rowNum", $row['dibayar']);
    $rowNum++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="laporan_transaksi.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
