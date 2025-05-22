<?php
require_once('../vendor/tecnickcom/tcpdf/tcpdf.php'); 
include '../database/koneksi.php';

$query = "SELECT t.kode_invoice, p.nama AS nama_pelanggan, o.nama AS nama_outlet, t.tgl, t.batas_waktu, t.tgl_bayar, t.status, t.dibayar
          FROM tb_transaksi t
          JOIN tb_member p ON t.id_member = p.id
          JOIN tb_outlet o ON t.id_outlet = o.id
          ORDER BY t.id DESC";

$result = $koneksi->query($query);

// PDF Header
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);
$html = '<h2>Data Transaksi</h2>
<table border="1" cellpadding="4">
<tr>
    <th>Kode Invoice</th>
    <th>Pelanggan</th>
    <th>Outlet</th>
    <th>Tanggal</th>
    <th>Batas Waktu</th>
    <th>Tanggal Bayar</th>
    <th>Status</th>
    <th>Dibayar</th>
</tr>';

while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
        <td>' . $row['kode_invoice'] . '</td>
        <td>' . $row['nama_pelanggan'] . '</td>
        <td>' . $row['nama_outlet'] . '</td>
        <td>' . $row['tgl'] . '</td>
        <td>' . $row['batas_waktu'] . '</td>
        <td>' . ($row['tgl_bayar'] ?? '-') . '</td>
        <td>' . $row['status'] . '</td>
        <td>' . $row['dibayar'] . '</td>
    </tr>';
}
$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('laporan_transaksi.pdf', 'D');
exit;
?>
