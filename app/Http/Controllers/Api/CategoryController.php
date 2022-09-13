<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryAddConferencesRequest;
use App\Http\Requests\CategoryAddReportsRequest;

use App\Models\Conference;
use App\Models\Report;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CategoryResource::collection(Category::with('subcategories', 'conferences', 'reports')->get());
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
    public function store(CategoryCreateRequest $request)
    {
        $category = Category::create($request->validated());

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($categoryID)
    {
        $category = Category::with('subcategories', 'conferences', 'reports')->find($categoryID);
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryCreateRequest $request, $categoryID)
    {
        $category = Category::find($categoryID);

        if($category) {
            $category->update($request->validated());
            return new CategoryResource($category);
        }
        
        return 'Conference not found';
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($categoryID)
    {
        Category::where('id', $categoryID)->delete();
        return 'Category deleted';
    }

    public function updateConference(CategoryAddConferencesRequest $request, $categoryID) 
    {   
        $conferences = Conference::all();
        foreach($conferences as $keyConference) {
            if($keyConference->category_id == $categoryID) {
                $keyConference->category_id = null;
            }
            $keyConference->update();
            foreach($request->input() as $key => $value) {

                if($keyConference->id === $value) {
                    $keyConference->category_id = $categoryID;
                    $keyConference->update();
                    break;
                }
            }
        }
        return 'Conferences added to category';
    }

    public function updateReport(CategoryAddReportsRequest $request, $categoryID) 
    {   
        $reports = Report::all();
        foreach($reports as $keyReport) {
            if($keyReport->category_id == $categoryID) {
                $keyReport->category_id = null;
            }
            $keyReport->update();
            foreach($request->input() as $key => $value) {

                if($keyReport->id === $value) {
                    $keyReport->category_id = $categoryID;
                    $keyReport->update();
                    break;
                }
            }
        }
        return 'Reports added to category';
    }

    
}
