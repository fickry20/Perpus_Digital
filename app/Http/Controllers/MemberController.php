<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $members = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%")
                         ->orWhere('username', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%");
        })
        ->where('role', 'member')
        ->paginate(10);

        return view('members.index', compact('members'));
    }
}
