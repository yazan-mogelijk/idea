<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Idea;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ideas = Auth::user()->ideas()->get();

        return view('idea.index', [
            'ideas' => $ideas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Auth::user()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create an idea.');
        }

        return view('idea.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIdeaRequest $request)
    {
        if(!Auth::user()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create an idea.');
        }

        $validated = $request->validated([
            'title' => 'required',
            'description' => 'required',
            'image_path' => 'string|nullable',
            'links' => 'array|nullable',
        ]);

        Auth::user()->ideas()->create($validated);

        return redirect()->route('idea.show')->with('success', 'You have created a new idea.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        if(!Auth::user()) {
            return redirect()->route('login')->with('error', 'You must be logged in to show an idea.');
        }

        return view('idea.show', compact('idea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {

        return view('idea.edit', compact('idea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        if(!Auth::user()) {
            return redirect()->route('login')->with('error', 'You must be logged in to update the idea.');
        }

        $validated = $request->validated([
            'title' => 'required',
            'description' => 'required',
            'image_path' => 'string|nullable',
            'links' => 'array|nullable',
        ]);

        Auth::user()->idea->update($validated);

        return redirect()->route('idea.show')->with('success', 'You have updated the idea.');
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
