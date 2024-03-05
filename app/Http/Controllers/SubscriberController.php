<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubscriberResource;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function getSubscriberData(Request $request)
    {
        $subscriber = $request->user();

        // Return subscriber data
        return response()->json($subscriber);
    }

    public function show($id)
    {
        $subscriber = Subscriber::find($id);

        if (!$subscriber) {
            return response()->json(['error' => 'Subscriber not found'], 404);
        }

        return response()->json(['data' => $subscriber], 200);
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:subscribers',
            'email' => 'required|string|email|unique:subscribers',
            'password' => 'required|string|min:6',
            'status' => 'required|string',
        ]);

        $subscriber = Subscriber::create($request->all());

        return response()->json($subscriber, 201);
    }

    public function update(Request $request, $id)
    {
        $subscriber = Subscriber::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:subscribers,username,' . $id,
            'email' => 'required|string|email|unique:subscribers,email,' . $id,
            'status' => 'required|string',
        ]);

        $subscriber->update($request->all());

        return response()->json($subscriber, 200);
    }

    public function delete($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return response()->json(null, 204);
    }
    public function search(Request $request)
    {
        $query = Subscriber::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        
        $subscribers = $query->get();

        return SubscriberResource::collection($subscribers);
    }

}
