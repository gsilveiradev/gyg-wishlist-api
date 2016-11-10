<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Wishlist;
use JWTAuth;

class WishlistsController extends Controller
{
    public function __construct()
    {
        // GET User
        JWTAuth::parseToken();
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    private function verifyOwnership($object)
    {
        // Verify if user is owner
        if ($object->user_id <> $this->user->id) {
            return false;
        }

        return true;
    }

    public function index()
    {
        $wishlists = Wishlist::all();

        return response()->json(compact('wishlists'));
    }

    public function show($id)
    {
        $wishlist = Wishlist::findOrFail($id);

        if (!$this->verifyOwnership($wishlist)) {
            return response()->json(array(
                'message' => 'Unauthorized action'
            ), 401);
        }

        return response()->json(compact('wishlist'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json(array(
                'message' => 'Validation error',
                'errors' => $validation->errors()
            ), 422);
        }

        $wishlist = new Wishlist;
        $wishlist->name = $request->name;
        $wishlist->user_id = $this->user->id;
        $wishlist->save();

        return response()->json(compact('wishlist'));
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json(array(
                'message' => 'Validation error',
                'errors' => $validation->errors()
            ), 422);
        }

        $wishlist = Wishlist::findOrFail($id);

        if (!$this->verifyOwnership($wishlist)) {
            return response()->json(array(
                'message' => 'Unauthorized action'
            ), 401);
        }

        $wishlist->name = $request->name;
        $wishlist->save();

        return response()->json(compact('wishlist'));
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);

        if (!$this->verifyOwnership($wishlist)) {
            return response()->json(array(
                'message' => 'Unauthorized action'
            ), 401);
        }

        $wishlist->delete();

        return response()->json(array('message' => 'Ok!'), 200);
    }
}
