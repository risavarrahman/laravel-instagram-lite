<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf as PdfWriter;


class PostController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            // 'file' => 'required|file|mimes:jpg,png,jpeg,mp4,mov|max:150000', 
            'file' => [
                'required',
                File::types(['jpg', 'png', 'jpeg', 'mp4', 'mov'])
                    ->max('150mb')
            ],
            'caption' => 'nullable|string',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();

        Storage::disk('public')->put('assets/images/' . $fileName, file_get_contents($file));
        $filePath = 'assets/images/' . $fileName;
        $file->move(public_path('assets/images/'), $fileName);

        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        // dd($filePath);
        $fileType = in_array($fileExtension, ['jpg', 'png', 'jpeg']) ? 'image' : 'video';


        Post::create([
            'user_id' => Auth::id(),
            'caption' => $request->caption,
            'file_path' => $filePath,
            'file_type' => $fileType,

        ]);

        return redirect()->route('profile.index')->with('success', 'Post uploaded successfully.');
    }

    public function archive(Request $request): View
    {
        $query = Auth::user()->posts()->latest();

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            switch ($filter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'last_week':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'last_year':
                    $query->whereYear('created_at', Carbon::now()->year - 1);
                    break;
            }
        }
        $posts = $query->paginate(5);

        return view('profile.archive', [
            'posts' => $posts,
            'filter' => $request->input('filter'),
        ]);
    }

    public function exportPdf()
    {
        $posts = Auth::user()->posts()->latest()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan header
        $sheet->setCellValue('A1', 'No.');
        $sheet->setCellValue('B1', 'Tipe Post / Video');
        $sheet->setCellValue('C1', 'Tanggal Post');
        $sheet->setCellValue('D1', 'Caption');

        // Tambahkan data
        $row = 2;
        $start = 1;
        foreach ($posts as $post) {
            $sheet->setCellValue('A' . $row, $start++);
            $sheet->setCellValue('B' . $row, $post->file_type);
            $sheet->setCellValue('C' . $row, $post->created_at->format('j M Y H:i'));
            $sheet->setCellValue('D' . $row, $post->caption);
            $row++;
        }

        $writer = new PdfWriter($spreadsheet);
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="posts.pdf"');
        $writer->save('php://output');
    }

    public function exportXlsx()
    {
        $posts = Auth::user()->posts()->latest()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan header
        $sheet->setCellValue('A1', 'No.');
        $sheet->setCellValue('B1', 'Tipe Post / Video');
        $sheet->setCellValue('C1', 'Tanggal Post');
        $sheet->setCellValue('D1', 'Caption');

        // Tambahkan data
        $row = 2;
        $start = 1; // Inisialisasi nomor urut
        foreach ($posts as $post) {
            $sheet->setCellValue('A' . $row, $start++);
            $sheet->setCellValue('B' . $row, $post->file_type);
            $sheet->setCellValue('C' . $row, $post->created_at->format('j M Y H:i'));
            $sheet->setCellValue('D' . $row, $post->caption);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="posts.xlsx"');
        $writer->save('php://output');
    }

    public function destroy(Post $post): RedirectResponse
    {
        // dd($post);
        $post->delete();
        return redirect()->route('post.archive')->with('success', 'Post deleted successfully.');
    }
}
