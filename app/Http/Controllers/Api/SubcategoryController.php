<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\SubcategoryCreateRequest;
use App\Http\Resources\SubcategoryResource;
use App\Models\Subcategory;

use App\Models\Category;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryAddConferencesRequest;
use App\Http\Requests\CategoryAddReportsRequest;

use App\Models\Conference;
use App\Models\Report;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryID)
    {
        $subcategories = Subcategory::where('category_id', $categoryID)->with('conferences', 'reports')->get();
    //    $subcategories = Category::find($categoryID)->subcategories->with('conferences', 'reports');
        return $subcategories;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubcategoryCreateRequest $request)
    {
        $subCategory = Subcategory::create($request->validated());

        return new SubcategoryResource($subCategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($subcategoryID)
    {
        $subcategory = Subcategory::with('conferences', 'reports')->find($subcategoryID);
        return $subcategory;
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
    public function destroy($id)
    {
        //
    }

    public function updateConference(CategoryAddConferencesRequest $request, $categoryID, $subCategoryID) 
    {   
        $conferences = Category::find($categoryID)->conferences;
    //    $conferences = Conference::all();
        foreach($conferences as $keyConference) {
            if($keyConference->subcategory_id == $subCategoryID) {
                $keyConference->subcategory_id = null;
            }
            $keyConference->update();
            foreach($request->input() as $key => $value) {

                if($keyConference->id === $value) {
                    $keyConference->subcategory_id = $subCategoryID;
                    $keyConference->update();
                    break;
                }
            }
        }
        return 'Conferences added to category';
    }

    public function updateReport(CategoryAddReportsRequest $request, $categoryID, $subCategoryID) 
    {   
        $reports = Category::find($categoryID)->reports;
        foreach($reports as $keyReport) {
            if($keyReport->subcategory_id == $subCategoryID) {
                $keyReport->subcategory_id = null;
            }
            $keyReport->update();
            foreach($request->input() as $key => $value) {

                if($keyReport->id === $value) {
                    $keyReport->subcategory_id = $subCategoryID;
                    $keyReport->update();
                    break;
                }
            }
        }
        return 'Reports added to category';
    }
}
