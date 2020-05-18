<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class MessageController extends Controller
{

    /**
     * Create a new MessageController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $message = $this->validateAndCreateObject($request);

        $message->user()->associate(Auth::user());

        $message->save();

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Message $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Message $message)
    {
        $this->validatePermission($message);

        return response()->json($message, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Message $_message
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Message $_message)
    {
        $this->validatePermission($_message);

        $message = $this->validateAndCreateObject($request, $_message);

        $message->update();

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Message $message
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Message $message)
    {
        $this->validatePermission($message);

        $message->delete();

        return response()->json(['status' => 'deleted'], 200);
    }

    /**
     * Check if the current user can access the message object
     *
     * @param \App\Message $message
     * @return boolean
     */
    private function validatePermission(Message $message)
    {
        if (!$message->user() . equalTo(Auth::user())) {
            throw new AccessDeniedException();
        }
        return true;
    }

    private function validateAndCreateObject(Request $request, Message $_message = null) {
        $validatedData = $request->validate([
            'subject' => ['required', 'max:255'],
            'content' => ['required'],
            'start_date' => ['required'],
            'expiration_date' => ['required'],
        ]);

        $message = $_message == null ? new Message() : $_message;

        $message->subject = $request->get('subject');
        $message->content = $request->get('content');
        $message->start_date = $request->start_date;
        $message->expiration_date = $request->expiration_date;

        return $message;
    }
}
