<?php

namespace App\Http\Controllers;

use App\Services\KosAssistantService;
use Illuminate\Http\Request;

class KosAssistantController extends Controller
{
    public function ask(Request $request, KosAssistantService $service)
    {
        $data = $request->validate([
            'message'           => 'required|string|max:500',
            'history'           => 'array|max:20',
            'history.*.role'    => 'required|in:user,assistant',
            'history.*.content' => 'required|string|max:2000',
        ]);

        $reply = $service->ask($data['history'] ?? [], $data['message']);

        return response()->json(['reply' => $reply]);
    }
}