<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Models\Card;

class JobPostController extends Controller
{

    /**
     * Display a listing of the user's cards.
     */
    public function index()
    {
        // Ensure the current user is authorized to view card listings.
        //Gate::authorize('viewAny', Card::class);

        // The current user is authorized to list cards.

        // Retrieve all cards that belong to the user, ordered by id.
        $jobPosts =JobPost::orderBy('created_at', 'desc')->get();

        // Render the 'pages.cards' view with the user's cards.
        return view('pages.jobposts', [
            'jobPosts' => $jobPosts
        ]);
    }

    /**
     * Store a newly created card in storage.
     */
    public function store(Request $request)
    {
        // Ensure the current user is authorized to create a card.
        Gate::authorize('create', Card::class);

        // Create and populate a new card instance.
        $card = new Card();
        $card->name = $request->input('name');
        $card->user_id = Auth::id();

        // Persist the card and return it as JSON.
        $card->save();
        return response()->json($card);
    }

    /**
     * Deletes a specific card.
     */
    public function destroy(Card $card)
    {
        // Ensure the current user is authorized to delete this card.
        Gate::authorize('delete', $card);

        // Delete the card and return it as JSON.
        $card->delete();
        return response()->json($card);
    }
}
