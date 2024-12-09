<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Models\User;
use App\Util\APIResponder;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class NoteController extends Controller
{
    use APIResponder;
    /**
     * Display a listing of the resource.
     */
    public function index($username): JsonResponse
    {
        $user = User::where('username', $username)->firstOrFail();
        
        $stories = $user->notes()->get();

        return $this->successResponse(NoteResource::collection($stories), 'Note');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateNoteRequest $request)
    {
        $user = auth()->user();
        
        $note = Note::create(array_merge($request->validated(), [
            'user_id' => $user->id,
            'expires_at' => Carbon::now()->addHours(24),
        ]));
        return $this->successResponse($note, 'Note has been added successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($username, $id)
    {
        $user = auth()->user();
        
        $note = Note::findOrFail($id);

        $note->delete();

        return $this->successResponse($note, 'Note has been deleted');
    }
}