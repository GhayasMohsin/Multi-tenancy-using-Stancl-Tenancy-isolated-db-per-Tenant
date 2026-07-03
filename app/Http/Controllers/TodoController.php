<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class TodoController extends Controller
{
    public function index(Request $request): View
    {
        $query = Todo::where('user_id', $request->user()->id);

        if ($search = $request->input('q')) {
            $query->where('title', 'like', "%{$search}%");
        }
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($priority = $request->input('priority')) {
            $query->where('priority', $priority);
        }

        $todos = $query->orderBy('due_date')->orderByDesc('id')->paginate(10)->withQueryString();

        return view('todos.index', [
            'todos'   => $todos,
            'tenant'  => tenant(),
            'filters' => $request->only('q', 'status', 'priority'),
        ]);
    }

    public function create(): View
    {
        return view('todos.create', ['tenant' => tenant()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateInput($request);

        $todo = Todo::create(array_merge($data, [
            'user_id'      => $request->user()->id,
            'completed_at' => $data['status'] === 'done' ? now() : null,
        ]));

        return redirect()->route('todos.show', $todo->id)->with('success', 'Todo created.');
    }

    public function show(int $id): View
    {
        $todo = Todo::where('user_id', request()->user()->id)->findOrFail($id);
        return view('todos.show', ['todo' => $todo, 'tenant' => tenant()]);
    }

    public function edit(int $id): View
    {
        $todo = Todo::where('user_id', request()->user()->id)->findOrFail($id);
        return view('todos.edit', ['todo' => $todo, 'tenant' => tenant()]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $todo = Todo::where('user_id', $request->user()->id)->findOrFail($id);
        $data = $this->validateInput($request);

        $data['completed_at'] = $data['status'] === 'done'
            ? ($todo->completed_at ?? now())
            : null;

        $todo->update($data);

        return redirect()->route('todos.show', $todo->id)->with('success', 'Todo updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Todo::where('user_id', request()->user()->id)->findOrFail($id)->delete();
        return redirect()->route('todos.index')->with('success', 'Todo deleted.');
    }

    public function toggle(int $id): RedirectResponse
    {
        $todo = Todo::where('user_id', request()->user()->id)->findOrFail($id);
        $todo->status === 'done' ? $todo->markPending() : $todo->markDone();
        return back()->with('success', 'Todo status updated.');
    }

    private function validateInput(Request $request): array
    {
        return $request->validate([
            'title'    => ['required', 'string', 'max:200'],
            'notes'    => ['nullable', 'string', 'max:2000'],
            'due_date' => ['nullable', 'date'],
            'priority' => ['required', 'in:low,medium,high'],
            'status'   => ['required', 'in:pending,in_progress,done'],
        ]);
    }
}
