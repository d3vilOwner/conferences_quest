<?php

namespace App\Http\Controllers\Api;

use App\Exports\CommentsExport;
use App\Exports\ReportsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\ReportStoreRequest;
use App\Http\Requests\ReportUpdateRequest;
use App\Http\Resources\ReportResource;
use App\Http\Resources\UserConferenceResource;
use App\Jobs\NewReportJob;
use App\Jobs\ReportDeletedJob;
use App\Jobs\UpdateReportJob;
use App\Mail\NewReport;
use App\Mail\ReportDeleted;
use App\Mail\UpdateReport;
use App\Models\Report;
use App\Models\UserConference;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Polyfill\Intl\Idn\Resources\unidata\DisallowedRanges;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReportResource::collection(Report::with('conference')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReportStoreRequest $request)
    {   
        $input = $request->all();

        if($request->hasFile('presentation')) {
            $file = $request->file('presentation');
            $file_name = time(). '.' .$file->getClientOriginalName();
            $file->move(storage_path('/app/public/presentations/'), $file_name);
            $file_path = 'app/public/presentations/'.$file_name;
            $input['presentation'] = $file_path;
        }
        
        
        $report = Report::create($input);
            
        // ----- mail 
        dispatch(new NewReportJob($request->conference_title, $request->username, $request->topic, $request->report_start, $request->report_end, $request->conference_id)); 

        return new ReportResource($report);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        return new ReportResource($report);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReportUpdateRequest $request, $id)
    {
      //  dd($request->all());
        $report = Report::with('conference', 'user')->find($id);

        if($report) {
            $report->update($request->validated());

            // ---mail

        //    if($request->timeChanged === true) { // проверка на изменение времени
                dispatch(new UpdateReportJob($request->conference_title, $request->username, $request->topic, $request->report_start, $request->report_end, $request->conference_id));
        //    }

            return new ReportResource($report);
        }
        
        return 'Report not found';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        dump($report);
               
        $user_id = $report['user_id'];
        $conference_id = $report['conference_id'];
        UserConference::where('user_id', $user_id)->where('conference_id', $conference_id)->delete();
    //    dd($joined);
 //       $joined = DB::table('user_conferences')->where('user_id', $user_id)->where('conference_id', $conference_id)->get();
        $report->delete(); 
        return response(null, Response::HTTP_NO_CONTENT);

    }

    public function deleteReport(Report $report, $conference_title) {
    
        //--mail
        dispatch(new ReportDeletedJob($conference_title, $report->user->email));

        $report->delete();
        return 'Report deleted';
    }

    public function download(Report $report) {
        return response()->download(storage_path($report->presentation));
    }

    public function cancelJoining($id)
    {
        UserConference::findOrFail($id)->delete();
        return true;
    }

    public function export() {
        //    Excel::store(new ReportsExport(), 'reports.csv');
        return Excel::download(new ReportsExport, 'reports.csv');
    }

    public function exportComments($reportID) {
        //    Excel::store(new CommentsExport($reportID), 'comments.csv');
        return Excel::download(new CommentsExport($reportID), 'comments.csv');
    }
}
