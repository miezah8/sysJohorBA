<?php
// app/Http/Controllers/ReportController.php
namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use App\Models\Athlete;
use App\Models\SanctionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('creator')->latest()->get();
        return view('reports.index', compact('reports'));
    }

    public function run(Report $report, Request $request)
    {
        // Sanction summary reports
        if ($report->slug === 'sanction-summary') {
            // Group by level
            $rows = SanctionRequest::select(
                        DB::raw('YEAR(created_at) AS year'),
                        'level',
                        DB::raw('COUNT(*) AS total')
                    )
                    ->groupBy('year','level')
                    ->orderBy('year','desc')
                    ->orderBy('level')
                    ->get();

            return view('reports.sanction_summary', compact('report','rows'));
        }

        // Athlete list reports
        if ($report->slug === 'athlete-list') {
            // pull athlete → user → school
            $rows = Athlete::with(['user','school'])
                           ->orderBy('athlete_fname')
                           ->get();
            return view('reports.athlete_output', [
                'report' => $report,
                'rows'   => $rows,
            ]);
        }

        // Registrations reports: last full calendar month
        $start = now()->subMonth()->startOfMonth();
        $end   = now()->subMonth()->endOfMonth();

        $registrations = User::whereBetween('created_at', [$start, $end])
                             ->orderBy('created_at')
                             ->get();

        return view('reports.output', compact('report','registrations'));
    }

    public function export(Report $report)
    {
        // CSV export for sanction-summary
        if ($report->slug === 'sanction-summary') {
            $rows = SanctionRequest::select('level', DB::raw('COUNT(*) AS total'))
                ->groupBy('level')
                ->orderBy('level')
                ->get();

            $filename = "sanction-summary-" . now()->format('Y-m-d') . ".csv";

            return response()->streamDownload(function() use($rows) {
                $out = fopen('php://output','w');
                fputcsv($out, ['Year','Sanction Level','Applications']);
                foreach ($rows as $r) {
                    fputcsv($out, [
                    $r->year,
                    $r->level,
                    $r->total,
                    ]);
                }
                fclose($out);
            }, $filename, ['Content-Type'=>'text/csv']);
        }


        // CSV export for athlete-list
        if ($report->slug === 'athlete-list') {
            $rows = Athlete::with(['user','school'])
                           ->orderBy('athlete_fname')
                           ->get();

            $filename = "athlete-list-" . now()->format('Y-m-d') . ".csv";

            $filename = "athlete-list-" . now()->format('Y-m-d') . ".csv";

            return response()->streamDownload(function() use($rows) {
                $out = fopen('php://output','w');
                // header row
                fputcsv($out, ['Athlete Name','IC Number','School']);
                foreach($rows as $a) {
                    fputcsv($out, [
                      $a->athlete_fname . ' ' . $a->athlete_lname,
                      $a->user->ic_number,
                      optional($a->school)->school_name,
                    ]);
                }
                fclose($out);
            }, $filename, ['Content-Type'=>'text/csv']);
        }

        // user‐registration export
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

