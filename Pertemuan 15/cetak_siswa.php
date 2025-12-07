<?php
require('fpdf.php');
include 'koneksi.php';

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,7,'SMK NEGERI 2 LANGSA',0,1,'C');
        
        $this->SetFont('Arial','',10);
        $this->Cell(0,5,'Daftar Siswa Kompetensi Keahlian: Rekayasa Perangkat Lunak',0,1,'C');
        
        $this->SetLineWidth(1);
        $this->Line(10, 25, 200, 25);
        $this->SetLineWidth(0); 
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Halaman '.$this->PageNo().' - Data Database: sekolah_db',0,0,'C');
    }
}

$pdf = new PDF('P','mm','A4');
$pdf->AddPage();

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'DATA SISWA JURUSAN RPL',0,1,'C');
$pdf->Ln(2);

$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(44, 62, 80);
$pdf->SetTextColor(255, 255, 255);

$w = array(10, 25, 75, 25, 35, 20); 

$pdf->Cell($w[0], 8, 'NO', 1, 0, 'C', true);
$pdf->Cell($w[1], 8, 'NIS', 1, 0, 'C', true);
$pdf->Cell($w[2], 8, 'NAMA SISWA', 1, 0, 'L', true);
$pdf->Cell($w[3], 8, 'KELAS', 1, 0, 'C', true);
$pdf->Cell($w[4], 8, 'NO HP', 1, 0, 'C', true);
$pdf->Cell($w[5], 8, 'PARAF', 1, 1, 'C', true);

$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(235, 236, 240);

$query = mysqli_query($connect, "SELECT * FROM siswa_rpl ORDER BY nama_siswa ASC");
$no = 1;
$fill = false; 

while ($row = mysqli_fetch_array($query)){
    
    $pdf->Cell($w[0], 7, $no++, 1, 0, 'C', $fill);
    $pdf->Cell($w[1], 7, $row['nis'], 1, 0, 'C', $fill);
    $pdf->Cell($w[2], 7, '  ' . strtoupper($row['nama_siswa']), 1, 0, 'L', $fill);
    $pdf->Cell($w[3], 7, $row['kelas'], 1, 0, 'C', $fill);
    $pdf->Cell($w[4], 7, $row['no_hp'], 1, 0, 'C', $fill);
    $pdf->Cell($w[5], 7, '', 1, 1, 'C', $fill);
    
    $fill = !$fill; 
}

$pdf->Output();
?>