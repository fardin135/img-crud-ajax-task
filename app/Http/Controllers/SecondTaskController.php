<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SecondTaskController extends Controller
{
    public function createUser(Request $request){
        //validating the data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:5',
        ]);
        //insert data into database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Data inserted successfully',
        ]);
    }

    public function readUser(Request $request)
    {
        $query = User::query();
        // Query for searching option
        if ($request->search) {
            $users = $query->where('name', 'LIKE', $request->search . '%')
                ->orWhere('email', 'LIKE', $request->search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $users = $query->orderBy('created_at', 'desc')->paginate(10);
        }
        return response()->json([
            'data' => $users
            // 'data' => $users->items(), // Send the paginated data
            // 'current_page' => $users->currentPage(), // Current page number
            // 'last_page' => $users->lastPage(), // Total pages
            // 'total' => $users->total(), // Total items
        ]);
    }


    public function updateUser(User $id)
    {
        return response()->json(['data' => $id]);
    }

    public function updateUserPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'required|email',
            'password' => 'required|string|min:5',
        ]);
        $user = User::where('id', $request->update_id);
        $user->update([
            'name' => $request->name,
            // 'email' => $request->email,
            'password' => $request->password,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Data updated successfully',
        ]);
    }

    public function deleteUser(User $id)
    {
        if ($id) {
            $id->delete();
            return response()->json(['message' => 'User deleted successfully.']);
        } else {
            return response()->json(['message' => 'User not found']);
        }
    }
}
