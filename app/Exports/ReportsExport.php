<?php

namespace App\Exports;

use App\Models\Report;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View
    {
        $reports = Report::with('comments')->get();
        return view('exports.reports_export', [
            'reports' => $reports
        ]);
    }

    // public function collection()
    // {
    //     return Conference::all();
   
    // }
}