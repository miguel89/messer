<?php

namespace App\Http\Controllers\API;

use App\Change;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list($messageId)
    {
        $changes = Change::where('message_id', $messageId)->orderBy('created_at', 'desc')->get();

        return response()->json($changes, 200);
    }
}
