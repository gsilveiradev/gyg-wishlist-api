<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Wishlist;
use App\Item;
use JWTAuth;

class ItemsController extends Controller
{
    /**
     * Set the logged User object.
     */
    public function __construct()
    {
        // GET User
        JWTAuth::parseToken();
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Verify if the logged user is the owner of the $wishlist_id
     */
    private function verifyOwnership($wishlist_id)
    {
        // Verify if user is owner
        if (Wishlist::where('user_id', '=', $this->user->id)->where('id', '=', $wishlist_id)->count() == 0) {
            return false;
        }

        return true;
    }

    /**
     * Show the resource
     */
    public function show($id)
    {
        $item = Item::findOrFail($id);

        if (!$this->verifyOwnership($item->wishlist_id)) {
            return response()->json(array(
                'message' => 'Unauthorized action'
            ), 401);
        }

        return response()->json(compact('item'));
    }

    /**
     * Create new resource
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'activity' => 'required',
            'wishlist_id' => 'required|exists:wishlists,id'
        ]);

        if ($validation->fails()) {
            return response()->json(array(
                'message' => 'Validation error',
                'errors' => $validation->errors()
            ), 422);
        }

        $item = new item;
        $item->activity = $request->activity;
        $item->wishlist_id = $request->wishlist_id;

        if (!$this->verifyOwnership($request->wishlist_id)) {
            return response()->json(array(
                'message' => 'Unauthorized action'
            ), 401);
        }

        $item->save();

        return response()->json(compact('item'));
    }

    /**
     * Update existing resource
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'activity' => 'required',
            'wishlist_id' => 'required|exists:wishlists,id'
        ]);

        if ($validation->fails()) {
            return response()->json(array(
                'message' => 'Validation error',
                'errors' => $validation->errors()
            ), 422);
        }

        $item = Item::findOrFail($id);

        if (!$this->verifyOwnership($item->wishlist_id)) {
            return response()->json(array(
                'message' => 'Unauthorized action'
            ), 401);
        }

        $item->activity = $request->activity;
        $item->wishlist_id = $request->wishlist_id;
        $item->save();

        return response()->json(compact('item'));
    }

    /**
     * Delete resource
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        if (!$this->verifyOwnership($item->wishlist_id)) {
            return response()->json(array(
                'message' => 'Unauthorized action'
            ), 401);
        }

        $item->delete();

        return response()->json(array('message' => 'Ok!'), 200);
    }
}
