<?php
namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index() : \Illuminate\Http\JsonResponse
    {
        Log::info('Entering index method.');
        $todos = Todo::paginate(10);
        Log::info('Retrieved todos:', ['todos' => $todos->toArray()]);
        Log::info('Exiting index method.');
        return response()->json($todos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        Log::info('Entering create method.');
        Log::info('Showing the form for creating a new todo.');
        Log::info('Exiting create method.');
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Entering store method.');
        Log::info('Request data:', ['data' => $request->all()]);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean',
        ]);

        Log::info('Validation passed.');

        $todo = Todo::create($request->only('name', 'description', 'is_completed'));
        Log::info('Created new todo:', ['todo' => $todo->toArray()]);

        Log::info('Exiting store method.');
        return response(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : View
    {
        Log::info('Entering show method.');
        Log::info('Fetching todo with ID:', ['id' => $id]);

        $todo = Todo::findOrFail($id);
        Log::info('Retrieved todo:', ['todo' => $todo->toArray()]);

        Log::info('Exiting show method.');
        return view('app', ['todo' => $todo]);
    }
    public function deletePostId($id): \Illuminate\Http\JsonResponse
    {
        $todo = Todo::find($id);
        if ($todo) {
            $todo->delete();
            return response()->json(['message' => 'Post deleted'], 200);
        } else {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }
    public function update(Request $request, $id)
    {
        Log::info('Entering update method.');
        Log::info('Request data:', ['data' => $request->all()]);

        $todo = Todo::find($id);
        if ($todo) {
            Log::info('Entering update method find id method');

            $request->validate([
                'is_completed' => 'required|boolean',
            ]);

            $todo->update($request->only('is_completed'));
            Log::info('Success in update find id method');
            return response()->json(['message' => 'Post updated', 'todo' => $todo], 200);
        } else {
            Log::info('Error in update find id method');
            return response()->json(['message' => 'Post not found'], 404);
        }
    }



}
