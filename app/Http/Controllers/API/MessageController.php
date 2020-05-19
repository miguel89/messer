<?php

namespace App\Http\Controllers\API;

use App\Change;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageCollection;
use App\Message;
use Carbon\Carbon;
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
     */
    public function index()
    {
        // get the current user id
        $user_id = Auth::user()->id;

        $messages = Message::where('user_id', $user_id)->paginate(15);

        return response()->json($messages, 200);
    }

    /**
     * List the 5 newest messages
     * @return \Illuminate\Http\JsonResponse
     */
    public function listNew() {
        // get the current user id
        $user_id = Auth::user()->id;

        $messages = Message::where('user_id', $user_id)->orderBy('created_at', 'asc')->limit(5)->get();

        return response()->json($messages, 200);
    }

    /**
     * List the 5 last updated messages
     * @return \Illuminate\Http\JsonResponse
     */
    public function listUpdated() {
        // get the current user id
        $user_id = Auth::user()->id;

        $messages = Message::where('user_id', $user_id)->orderBy('updated_at', 'asc')->limit(5)->get();

        return response()->json($messages, 200);
    }

    /**
     * List the next 5 messages that are about to start
     * @return \Illuminate\Http\JsonResponse
     */
    public function listNext() {
        // get the current user id
        $user_id = Auth::user()->id;

        $messages = Message::where('user_id', $user_id)->whereDate('start_date', '>', Carbon::today())
            ->orderBy('start_date', 'asc')->limit(5)->get();

        return response()->json($messages, 200);
    }

    /**
     * List the 5 last expired messages
     * @return \Illuminate\Http\JsonResponse
     */
    public function listExpired() {
        // get the current user id
        $user_id = Auth::user()->id;

        $messages = Message::where('user_id', $user_id)->whereDate('expiration_date', '<', Carbon::today())
            ->orderBy('expiration_date', 'asc')->limit(5)->get();

        return response()->json($messages, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $message = $this->validateAndCreateObject($request, new Message());

        $message->user()->associate(Auth::user());

        $message->save();

        return response()->json(['status' => 'success', 'id' => $message->id], 200);
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
     * @param Message $messageId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $messageId)
    {
        $message = Message::find($messageId);
        $changes = $this->registerChange($message, $request);
        $message = $this->validateAndCreateObject($request, $message);

        $this->validatePermission($message);

        $message->save();

        $this->saveChanges($changes, $message);

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
        if (!$message->user() == Auth::user()) {
            throw new AccessDeniedException();
        }
        return true;
    }

    /**
     * Validates the Message object for creation and edition. If messageId is given,
     * fetch the object from the database and update the values. If not, creates a new object.
     *
     * @param Request $request
     * @param Message $message
     * @return Message
     */
    private function validateAndCreateObject(Request $request, Message $message) {
        $validatedData = $request->validate([
            'subject' => ['required', 'max:255'],
            'content' => ['required'],
            'start_date' => ['required'],
            'expiration_date' => ['required'],
        ]);

        $message->subject = $request->get('subject');
        $message->content = $request->get('content');
        $message->start_date = $request->start_date;
        $message->expiration_date = $request->expiration_date;

        return $message;
    }

    /**
     * Compare the persisted object with the request to register the changes.
     * TODO move it to its own service.
     * @param Message $message
     * @param $request
     * @return array
     */
    private function registerChange(Message $message, $request) {
        $changes = [];

        if ($message->subject != $request->get('subject')) {
            array_push($changes, $this->createChangeMessage('subject',
                $message->subject, $request->get('subject')));
        }
        if ($message->content != $request->get('content')) {
            array_push($changes, $this->createChangeMessage('content',
                $message->content, $request->get('content')));
        }
        if ($message->start_date != $request->get('start_date')) {
            array_push($changes, $this->createChangeMessage('start_date',
                $message->start_date, $request->get('start_date')));
        }
        if ($message->expiration_date != $request->get('expiration_date')) {
            array_push($changes, $this->createChangeMessage('expiration_date',
                $message->expiration_date, $request->get('expiration_date')));
        }
        return $changes;
    }

    /**
     * Persist the changes objects. TODO move it to its own service
     * @param $changes
     * @param $message
     */
    private function saveChanges($changes, $message) {
        foreach ($changes as $it) {
            $change = new Change();
            $change->description = $it;
            $change->user()->associate(Auth::user());
            $change->message()->associate($message);

            $change->save();
        }
    }

    /**
     * Creates a description of the change, with the values and the field name.
     * TODO move it to its own service.
     * @param $field
     * @param $oldValue
     * @param $newValue
     * @return string
     */
    private function createChangeMessage($field, $oldValue, $newValue) {
        return "The field $field was changed from '$oldValue' to '$newValue'";
    }
}
