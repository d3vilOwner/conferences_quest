<?php

namespace App\Exports;

use App\Models\Comment;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CommentsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $reportID;

    public function __construct($reportID)
    {
        $this->reportID = $reportID;
    }

    public function view(): View
    {
        $comments = Comment::with('user')->where('report_id', $this->reportID)->get();
        return view('exports.comments_export', [
            'comments' => $comments
        ]);
    }

    // public function collection()
    // {
    //     return Conference::all();
   
    // }
}
