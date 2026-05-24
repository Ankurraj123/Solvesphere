<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function store(Request $request, $problemId)
    {
        $request->validate([
            'answer' => 'required|string|min:5',
        ]);

        // Verify problem exists
        $problem = Problem::findOrFail($problemId);

        Answer::create([
            'problem_id' => $problem->id,
            'user_id' => Auth::id(),
            'answer' => $request->answer,
        ]);

        return redirect()->route('problems.show', $problem->id)->with('success', 'Your answer has been posted!');
    }

    public function update(Request $request, $id)
    {
        $answer = Answer::findOrFail($id);

        // Authorize: only owner can edit answer
        if (Auth::id() !== $answer->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'answer' => 'required|string|min:5',
        ]);

        $answer->update([
            'answer' => $request->answer,
        ]);

        return redirect()->route('problems.show', $answer->problem_id)->with('success', 'Answer updated successfully.');
    }

    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);

        // Authorize: owner or admin
        if (Auth::id() !== $answer->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $problemId = $answer->problem_id;
        $answer->delete();

        return redirect()->route('problems.show', $problemId)->with('success', 'Answer deleted successfully.');
    }
}
