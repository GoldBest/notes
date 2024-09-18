<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $notes = Note::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'content' => [
                'required',
                'string',
            ]
        ]);

        $note = new Note();
        $note->user_id = Auth::id();
        $note->title = $request->input('title');
        $note->content = $request->input('content');
        $note->save();

        return redirect()->route('notes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        return redirect()->route('notes.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|View
     */
    public function edit(int $id): \Illuminate\Http\RedirectResponse|View
    {
        $note = Note::findOrFail($id);
        if ($note->user_id != Auth::id()) { // Проверяем является ли данный пользователь автором заметки
            return redirect()->route('notes.index');
        }

        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'content' => [
                'required',
                'string',
            ]
        ]);

        $note = Note::find($id);
        $note->title = $request->input('title');
        $note->content = $request->input('content');
        $note->update();
        return redirect()->route('notes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $note = Note::findOrFail($id);
        if ($note->user_id != Auth::id()) { // Удаляем если эта запись принадлежит этому пользователю
            return redirect()->route('notes.index');
        } else {
            $note->delete();
        }
        return redirect()->route('notes.index');
    }
}
