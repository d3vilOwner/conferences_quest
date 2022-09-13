<?php

namespace App\Exports;

use App\Models\Conference;
use App\Models\UserConference;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ListenersExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $conferenceID;

    public function __construct($conferenceID)
    {
        $this->conferenceID = $conferenceID;
    }

    public function view(): View
    {
        $listeners = UserConference::with('user')->where('conference_id', $this->conferenceID)->get();
    //    dump($listeners);
        return view('exports.listeners_export', [
            'listeners' => $listeners
        ]);
    }

    // public function collection()
    // {
    //     return Conference::all();
   
    // }
}
