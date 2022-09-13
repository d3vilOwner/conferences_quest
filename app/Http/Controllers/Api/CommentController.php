<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CommentImageRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Jobs\NewCommentJob;
use App\Mail\NewComment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Comment;
use App\Models\Report;
use App\Models\User;
use Error;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($report_id)
    {
        $comments = Report::find($report_id)->comments;
        return CommentResource::collection($comments);
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
    public function store(CommentRequest $request)
    {
        //--mail
        dispatch(new NewCommentJob($request->conference_title, $request->username, $request->topic, $request->report_author));

        $comment = Comment::create($request->validated());

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(CommentRequest $request, $id)
    {
        $comment = Comment::with('user', 'report')->find($id);
        if($comment) {
            $comment->update($request->validated());
            return new CommentResource($comment);
        }
        return 'Comment not found';
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

    public function storeImage(CommentImageRequest $request) {
        $data = $request->validated();
        $image = $data['image'];
        $imageName = md5(Carbon::now(). '_' .$image->getClientOriginalName()). '.' .$image->getClientOriginalExtension();
        /** @var Illuminate\Filesystem\FilesystemAdapter */
        $fileSystem = Storage::disk('public');
        $fileSystem->putFileAs('/images', $image, $imageName);
        $filePath = 'images/'.$imageName;
        return $filePath;
  //      dump($filePath);
     //   dump($data);
    }
}
