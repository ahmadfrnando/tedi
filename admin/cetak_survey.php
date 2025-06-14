<?php
require __DIR__ . '/../function.php';
require_once __DIR__ . '/../vendor/autoload.php'; // sesuaikan path

use TCPDF;

$pertanyaan_result = mysqli_query($conn, "SELECT no_urut, pertanyaan FROM pertanyaan ORDER BY no_urut ASC");
$pertanyaan_list = mysqli_fetch_all($pertanyaan_result, MYSQLI_ASSOC);

$data_pertanyaan = mysqli_query($conn, "SELECT user_id, persepsi0, persepsi1, persepsi2, persepsi3, persepsi4, persepsi5, persepsi6, persepsi7, persepsi8, persepsi9, total_penilaian, rata_rata_penilaian, tingkat_kepuasan FROM survey");
$data_pertanyaan = mysqli_fetch_all($data_pertanyaan, MYSQLI_ASSOC);

$nilai_deskripsi = [
    1 => 'Sangat Tidak Puas',
    2 => 'Tidak Puas',
    3 => 'Cukup Puas',
    4 => 'Puas',
    5 => 'Sangat Puas',
];

$pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistem Survey');
$pdf->SetTitle('Laporan Survey');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();

$html = '<h1>Daftar Pertanyaan</h1><ol>';
foreach ($pertanyaan_list as $p) {
    $html .= '<li>' . htmlspecialchars($p['pertanyaan']) . '</li>';
}
$html .= '</ol>';

$html .= '<h1>Hasil Survey</h1><table border="1" cellpadding="4"><thead><tr bgcolor="#4CAF50" style="color:#ffffff; text-align: center;"><th rowspan="2">No.</th><th rowspan="2">Nama</th><th colspan="10" style="text-align: center;">Pertanyaan</th><th rowspan="2">Total</th><th rowspan="2">Rata-Rata</th><th rowspan="2">Kepuasan</th></tr><tr bgcolor="#4CAF50" style="color:#ffffff; text-align: center;">';

for ($i = 1; $i <= 10; $i++) {
    $html .= "<th>$i</th>";
}

$html .= '</tr></thead><tbody>';

// $html .= '<th>Total</th><th>Rata-Rata</th><th>Kepuasan</th></tr></thead><tbody>';

$no = 1;
foreach ($data_pertanyaan as $row) {
    $nama_result = mysqli_query($conn, "SELECT username FROM user WHERE id = '" . $row['user_id'] . "'");
    $nama_row = mysqli_fetch_assoc($nama_result);
    $nama = $nama_row ? $nama_row['username'] : 'Unknown';

    $html .= '<tr>';
    $html .= '<td>' . $no++ . '</td>';
    $html .= '<td>' . htmlspecialchars($nama) . '</td>';

    for ($j = 0; $j <= 9; $j++) {
        $angka = (int)$row["persepsi$j"];
        $teks = $nilai_deskripsi[$angka] ?? '-';
        $html .= '<td>' . htmlspecialchars($teks) . '</td>';
    }

    $html .= '<td>' . htmlspecialchars($row['total_penilaian']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['rata_rata_penilaian']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['tingkat_kepuasan']) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody></table>';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('laporan_survey.pdf', 'I');
