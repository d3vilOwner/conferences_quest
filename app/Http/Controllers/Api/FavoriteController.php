<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavoriteCreateRequest;
use App\Http\Resources\UserReportResource;
use App\Models\UserReport;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $allFavorites = UserReport::where('user_id', $user_id)->get();
     //   dump($allFavorites);
        return ($allFavorites);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FavoriteCreateRequest $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FavoriteCreateRequest $request)
    {
        $favorite = UserReport::create($request->validated());
        return new UserReportResource($favorite);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($reportID, $userID)
    {
        $favorite = UserReport::where('user_id', $userID)->where('report_id', $reportID)->get();
        if($favorite) {
            return $favorite;
        } else {
            return 'Favorite not found';
        }
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($favoriteID)
    {
        UserReport::find($favoriteID)->delete();
        return 'This report deleted from your favorites';
    }
}
