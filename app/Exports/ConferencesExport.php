<?php

namespace App\Exports;

use App\Models\Conference;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ConferencesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View
    {
        $conferences = Conference::with('reports', 'listeners')->get();
        return view('exports.conferences_export', [
            'conferences' => $conferences
        ]);
    }

    // public function collection()
    // {
    //     return Conference::all();
   
    // }
}
