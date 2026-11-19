<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengumpulanKarya;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class DataPekaryaController extends Controller
{
    /**
     * Menampilkan rekap data pekarya (siswa yang pernah mengajukan karya).
     * Data diambil langsung dari tabel pengumpulan_karya tanpa duplikasi tabel.
     */
    public function index(Request $request)
    {
        $query = PengumpulanKarya::query();

        // Fitur pencarian berdasarkan nama siswa, kelas, atau judul karya
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                    ->orWhere('kelas', 'like', "%{$search}%")
                    ->orWhere('judul_karya', 'like', "%{$search}%");
            });
        }

        // Filter kategori karya (Web, Apk, Desain, Gambar)
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter status peninjauan (pending, approved, rejected)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter status publikasi (belum_dipublikasi, dipublikasikan)
        if ($request->filled('status_publikasi')) {
            $query->where('status_publikasi', $request->status_publikasi);
        }

        // Pengurutan berdasarkan tanggal pengajuan (default: terbaru / desc)
        $sortDirection = $request->input('sort', 'desc') === 'asc' ? 'asc' : 'desc';
        $query->orderBy('created_at', $sortDirection);

        $pekaryas = $query->paginate(10)->withQueryString();

        // Statistik ringkas data pekarya
        $totalPengajuan = PengumpulanKarya::count();
        $totalPekaryaUnik = PengumpulanKarya::distinct('nama_siswa')->count('nama_siswa');
        $totalDipublikasikan = PengumpulanKarya::where('status_publikasi', 'dipublikasikan')->count();

        return view('admin.pekarya.index', compact(
            'pekaryas',
            'sortDirection',
            'totalPengajuan',
            'totalPekaryaUnik',
            'totalDipublikasikan'
        ));
    }

    /**
     * Ekspor seluruh data pengajuan karya ke format .xlsx (Microsoft Excel).
     * Kolom: No, Nama Siswa, Kelas, Judul Karya, Kategori, Deskripsi,
     *        Tanggal Pengajuan, Status Peninjauan, Status Publikasi.
     * Urut kronologis (created_at ASC). File gambar tidak disertakan.
     */
    public function export()
    {
        // Urutan wajib: pengajuan masuk paling awal → paling akhir.
        // id_pengumpulan ASC hanya sebagai pemisah bila created_at kembar.
        $data = PengumpulanKarya::orderBy('created_at', 'asc')
            ->orderBy('id_pengumpulan', 'asc')
            ->get();

        // ── Palet sederhana ──────────────────────────────────────────────────
        $cInk    = '1F2937'; // teks utama
        $cMuted  = '6B7280'; // teks sekunder
        $cNavy   = '1F3864'; // header tabel
        $cZebra  = 'F3F4F6'; // baris genap (abu-abu sangat muda)
        $cBorder = 'D1D5DB'; // border tipis

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);
        $spreadsheet->getDefaultStyle()->getFont()->getColor()->setRGB($cInk);

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Pengajuan Karya');
        $sheet->setShowGridLines(false);

        // ── Baris 1: judul ───────────────────────────────────────────────────
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', "Laporan Pengajuan Karya Siswa — S'Spotlight");
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['rgb' => $cInk]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT,
                            'vertical'   => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(26);

        // ── Baris 2: tanggal cetak ───────────────────────────────────────────
        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2', 'Dicetak pada: ' . now()->format('d F Y, H:i') . ' WIB');
        $sheet->getStyle('A2:I2')->applyFromArray([
            'font'      => ['size' => 9, 'color' => ['rgb' => $cMuted]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT,
                            'vertical'   => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(16);

        // ── Baris 3: jarak ───────────────────────────────────────────────────
        $sheet->getRowDimension(3)->setRowHeight(8);

        // ── Baris 4: header kolom (navy, teks putih) ─────────────────────────
        $headers = ['No', 'Nama Siswa', 'Kelas', 'Judul Karya', 'Kategori',
                    'Deskripsi', 'Tanggal Pengajuan', 'Status Peninjauan', 'Status Publikasi'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $col++;
        }
        $sheet->getStyle('A4:I4')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $cNavy]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical'   => Alignment::VERTICAL_CENTER,
                            'wrapText'   => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,
                                             'color'       => ['rgb' => $cNavy]]],
        ]);
        foreach (['B4', 'D4', 'F4'] as $leftHead) {
            $sheet->getStyle($leftHead)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        }
        $sheet->getRowDimension(4)->setRowHeight(24);

        // Lebar kolom (satuan karakter)
        $colWidths = ['A' => 5, 'B' => 22, 'C' => 10, 'D' => 30,
                      'E' => 11, 'F' => 48, 'G' => 17, 'H' => 20, 'I' => 18];
        foreach ($colWidths as $colLetter => $width) {
            $sheet->getColumnDimension($colLetter)->setWidth($width);
        }

        // ── Baris data ───────────────────────────────────────────────────────
        $labelStatus = [
            'pending'  => 'Menunggu Peninjauan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
        ];
        $labelPublikasi = [
            'dipublikasikan'    => 'Dipublikasikan',
            'belum_dipublikasi' => 'Belum Dipublikasi',
        ];

        // Warna lembut: [latar, teks]
        $warnaStatus = [
            'approved' => ['DCFCE7', '166534'],
            'rejected' => ['FEE2E2', '991B1B'],
            'pending'  => ['FEF3C7', '92400E'],
        ];

        // Perkiraan tinggi baris untuk teks yang membungkus (wrap text)
        $estimateLines = function (string $text, int $charsPerLine): int {
            $lines = 0;
            foreach (preg_split('/\r\n|\r|\n/', $text) as $segment) {
                $len = function_exists('mb_strlen') ? mb_strlen($segment) : strlen($segment);
                $lines += max(1, (int) ceil($len / max(1, $charsPerLine)));
            }
            return max(1, $lines);
        };

        $rowNum = 5;
        foreach ($data as $i => $item) {
            $deskripsi = strip_tags($item->deskripsi ?? '');

            $sheet->setCellValue('A' . $rowNum, $i + 1);
            $sheet->setCellValue('B' . $rowNum, $item->nama_siswa);
            $sheet->setCellValue('C' . $rowNum, $item->kelas);
            $sheet->setCellValue('D' . $rowNum, $item->judul_karya);
            $sheet->setCellValue('E' . $rowNum, $item->kategori);
            $sheet->setCellValue('F' . $rowNum, $deskripsi);
            $sheet->setCellValue('G' . $rowNum, $item->created_at
                ? $item->created_at->format('d/m/Y H:i')
                : '-');
            $sheet->setCellValue('H' . $rowNum, $labelStatus[$item->status] ?? $item->status);
            $sheet->setCellValue('I' . $rowNum, $labelPublikasi[$item->status_publikasi] ?? $item->status_publikasi);

            // Baris selang-seling (putih / abu-abu muda) + border tipis
            $bgColor = ($i % 2 === 0) ? 'FFFFFF' : $cZebra;
            $sheet->getStyle("A{$rowNum}:I{$rowNum}")->applyFromArray([
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,
                                                 'color'       => ['rgb' => $cBorder]]],
            ]);

            // Alignment: teks panjang rata kiri, kolom pendek di tengah
            foreach (['A', 'C', 'E', 'G', 'H', 'I'] as $centerCol) {
                $sheet->getStyle($centerCol . $rowNum)->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
            foreach (['B', 'D', 'F'] as $leftCol) {
                $sheet->getStyle($leftCol . $rowNum)->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);
            }

            // Warna status peninjauan (lembut)
            [$bg, $fg] = $warnaStatus[$item->status] ?? $warnaStatus['pending'];
            $sheet->getStyle("H{$rowNum}")->applyFromArray([
                'font' => ['color' => ['rgb' => $fg]],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
            ]);

            // Warna status publikasi (lembut)
            if ($item->status_publikasi === 'dipublikasikan') {
                $sheet->getStyle("I{$rowNum}")->applyFromArray([
                    'font' => ['color' => ['rgb' => '1E40AF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DBEAFE']],
                ]);
            } else {
                $sheet->getStyle("I{$rowNum}")->applyFromArray([
                    'font' => ['color' => ['rgb' => $cMuted]],
                ]);
            }

            // Tinggi baris menyesuaikan teks yang membungkus
            $lines = max(
                $estimateLines((string) $item->judul_karya, 32),
                $estimateLines($deskripsi, 50),
                $estimateLines((string) $item->nama_siswa, 23)
            );
            $sheet->getRowDimension($rowNum)->setRowHeight(min(300, max(20, $lines * 13 + 8)));

            $rowNum++;
        }
        $lastDataRow = $rowNum - 1;

        // ── Filter otomatis & freeze header ──────────────────────────────────
        $sheet->setAutoFilter('A4:I' . max(4, $lastDataRow));
        $sheet->freezePane('A5');

        // ── Total di bawah tabel ─────────────────────────────────────────────
        $sheet->mergeCells("A{$rowNum}:I{$rowNum}");
        $sheet->setCellValue("A{$rowNum}", 'Total: ' . count($data) . ' pengajuan');
        $sheet->getStyle("A{$rowNum}:I{$rowNum}")->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => $cMuted]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT,
                            'vertical'   => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension($rowNum)->setRowHeight(22);

        // ── Pengaturan cetak ─────────────────────────────────────────────────
        // A4 landscape, muat satu halaman lebar, header tabel diulang di tiap
        // halaman, margin ringkas, nomor halaman di footer.
        $sheet->getPageSetup()
            ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(PageSetup::PAPERSIZE_A4)
            ->setFitToPage(true)
            ->setFitToWidth(1)
            ->setFitToHeight(0)
            ->setHorizontalCentered(true)
            ->setPrintArea('A1:I' . $rowNum);
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(4, 4);
        $sheet->getPageMargins()
            ->setTop(0.5)->setBottom(0.6)
            ->setLeft(0.4)->setRight(0.4)
            ->setHeader(0.25)->setFooter(0.3);
        $sheet->getHeaderFooter()->setOddFooter(
            '&L&8Laporan Pengajuan Karya&R&8Halaman &P dari &N'
        );
        $sheet->setPrintGridlines(false);

        // ── Stream sebagai file download ─────────────────────────────────────
        $filename = 'laporan-pengajuan-karya-' . now()->format('Ymd-His') . '.xlsx';

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control'       => 'max-age=0',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
