<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpensesCollection;
use App\Notifications\ExpenseNotification;
use Illuminate\Support\Facades\Notification;
use App\User;
use App\Expense;

class ExpensesController extends Controller
{
    
    public function index()
    {
        $user = request()->user();
        $expenses = Expense::with(['user'])->orderBy('created_at', 'DESC');

        // check
        if (request()->q != '') {
            $expenses = $expenses->where('description','LIKE', '%' . request()->q . '%');
        }

        if (in_array($user->role, [1, 3])) {
            $expenses = $expenses->where('user_id', $user->id);    
        }

        return (new ExpensesCollection( $expenses->paginate(10)));

    }

    public function store(Request $request) 
    {
        // Validasi data yang akan dikirim
        $this->validate($request, [
            'description' => 'required|string|max:150',
            'price' => 'required|integer',
            'note' => 'nullable|string'
        ]);

        $user = $request->user();
        $status = $user->role == 0 || $user->role == 2 ? 1:0;
        $request->request->add(
            [
                'user_id' => $user->id,
                'status' => $status
            ]
        );

        $expenses = Expense::create($request->all());
        $users = User::whereIn('role', [0,2])->get();
        Notification::send($users, new ExpenseNotification($expenses, $user));
        return response()->json(['status' => 'success']);
    }

    public function accept(Request $request)
    {
        $this->validate($request, ['id' => 'required|exists:expenses,id']);
        $expenses = Expense::with(['user'])->find($request->id);
        $expenses->update(['status' => 1]);
        Notification::send($expenses->user, new ExpenseNotification($expenses, $expenses->user));
        return response()->json(['status' => 'success']);

    }

    public function cancelRequest (Request $request)
    {
        $this->validate($request, ['id' => 'required|exists:expenses,id', 'reason' => 'required|string']);
        $expenses = Expense::with(['user'])->find($request->id);
        $expenses->update(['status' => 2, 'reason' => $request->reason]);
        Notification::send($expenses->user, new ExpenseNotification($expenses, $expenses->user));
        return response()->json(['status' => 'success']);

    }

    public function edit($id)
    {
        $expenses = Expense::with(['user'])->find($id);
        return response()->json(['status' => 'success', 'data' => $expenses]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'description' => 'required|string|max:150',
            'price' => 'required|integer',
            'note'=> 'nullable|string'
        ]);

        $expenses = Expenses::find($id);
        $expenses->update($request->except('id'));
        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $expenses = Expenses::find($id);
        $expenses->delete();
        return response()->json(['status' => 'success']);
    }
}
