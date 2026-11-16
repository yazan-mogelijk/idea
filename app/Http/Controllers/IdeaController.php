<?php

namespace App\Http\Controllers;

use App\Actions\CreateIdea;
use App\Actions\UpdateIdea;
use App\Http\Requests\IdeaRequest;
use App\IdeaStatus;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $status = $request->status;

        if (! in_array($status, IdeaStatus::values())) {
            $status = null;
        }

        $ideas = $user
            ->ideas()
            ->latest()
            ->when($status, fn ($query, $status) => $query->where('status', $status))
            ->get();

        return view('idea.index', [
            'ideas' => $ideas,
            'statusCounts' => Idea::statusCount($user),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Auth::user()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create an idea.');
        }

        return view('idea.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IdeaRequest $request, CreateIdea $action)
    {
        if (! Auth::user()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create an idea.');
        }

        $action->handle($request->safe()->all());

        return to_route('ideas')->with('success', 'You have created a new idea.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        if (! Auth::user()) {
            return redirect()->route('login')->with('error', 'You must be logged in to show an idea.');
        }

        return view('idea.show', ['idea' => $idea]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {

        return view('idea.edit', ['idea' => $idea]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IdeaRequest $request, UpdateIdea $action, Idea $idea)
    {
        if (! Auth::user()) {
            return redirect()->route('login')->with('error', 'You must be logged in to update the idea.');
        }

        $action->handle($request->safe()->all(), $idea);

        return back()->with('success', 'You have updated the idea.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {

        $idea->delete();

        return redirect()->route('ideas')->with('success', 'You have deleted the idea.');
    }
}
