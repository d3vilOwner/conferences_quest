<?php

namespace App\Http\Controllers\Api;

use App\Exports\ConferencesExport;
use App\Exports\ListenersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conference;
use App\Models\UserConference;
use App\Http\Resources\ConferenceResource;
use App\Http\Requests\ConferenceCreateRequest;
use App\Http\Requests\ConferenceUpdateRequest;
use App\Http\Requests\JoinConferenceRequest;
use App\Jobs\ConferenceDeletedJob;
use App\Jobs\NewListenerJob;
use App\Mail\ConferenceDeleted;
use App\Mail\NewListener;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ConferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ConferenceResource::collection(Conference::with('reports', 'country', 'user')->get());
  //      return (Conference::with('reports', 'country', 'user')->get());
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
    public function store(ConferenceCreateRequest $request)
    {
        $conference = Conference::create($request->validated());

        return new ConferenceResource($conference);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Conference $conference)
    {
//        return new ConferenceResource(Conference::with('user', 'country')->findOrFail($id));
        return new ConferenceResource($conference);
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
    public function update(ConferenceUpdateRequest $request, $id)
    {

        $conference = Conference::with('user', 'country')->find($id);

        if($conference) {
            $conference->update($request->validated());
            return new ConferenceResource($conference);
        }
        
        return 'Conference not found';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conference $conference)
    {
       
        //return ConferenceResource::collection(Conference::with('reports', 'country', 'user')->get());

        //--mail
        if(Auth::user()->role === 'admin') {
            dispatch(new ConferenceDeletedJob($conference->title, $conference->user_id));
        }

        $conference->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function joinConference(JoinConferenceRequest $request, $id)
    {
        $conference_id = $id;
        $user_id = Auth::user()->id;

        $conferenceUser = UserConference::create([
            'conference_id' => $conference_id,
            'user_id' => $user_id,
        ]);

        if(Auth::user()->role === 'Listener') {
            dispatch(new NewListenerJob($request->conference_title, $request->username, $request->conference_id));
        }

        return $conferenceUser;
    }

    public function getJoined($id)
    {
        $conference_id = $id;
        $user_id = Auth::user()->id;

        $joinedConference = DB::table('user_conferences')->where('user_id', $user_id)->where('conference_id', $id)->get();
        if($joinedConference) {
            return $joinedConference;
        } else {
            return false;
        }
    }

    public function cancelJoining($id)
    {
        UserConference::findOrFail($id)->delete();
        return true;
    }

    public function getAllJoins()
    {
        $joins = UserConference::with('conference', 'user')->get();
        return $joins;
    }

    public function export() {
    //    Excel::store(new ConferencesExport(), 'conferences.csv');
        return Excel::download(new ConferencesExport, 'conferences.csv');
    }

    public function exportListeners($conferenceID) {
    //    Excel::store(new ListenersExport($conferenceID), 'listeners.csv');
        return Excel::download(new ListenersExport($conferenceID), 'listeners.csv');
    }
}
