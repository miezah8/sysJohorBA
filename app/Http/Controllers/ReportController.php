<?php
// app/Http/Controllers/ReportController.php
namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('creator')->latest()->get();
        return view('reports.index', compact('reports'));
    }

    public function run(Report $report, Request $request)
    {
        // Example: last full calendar month
        $start = now()->subMonth()->startOfMonth();
        $end   = now()->subMonth()->endOfMonth();

        $registrations = User::whereBetween('created_at', [$start, $end])
                             ->orderBy('created_at')
                             ->get();

        return view('reports.output', compact('report','registrations'));
    }

    public function export(Report $report)
    {
        $start = now()->subMonth()->startOfMonth();
        $end   = now()->subMonth()->endOfMonth();

        $registrations = User::whereBetween('created_at', [$start, $end])
                             ->orderBy('created_at')
                             ->get();

        $filename = "{$report->slug}-" . now()->format('Y-m') . ".csv";

        return response()->streamDownload(function() use($registrations) {
            $out = fopen('php://output','w');
            fputcsv($out, ['Name','Email','Registered At']);
            foreach($registrations as $u) {
                fputcsv($out, [
                  $u->name,
                  $u->email,
                  $u->created_at->format('Y-m-d H:i')
                ]);
            }
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}

