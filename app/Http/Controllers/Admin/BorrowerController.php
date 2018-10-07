<?php

namespace App\Http\Controllers\Admin;

use App\Borrower;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BorrowerController extends Controller
{
    public function toggleReturn($id) {
        $borrower = Borrower::findOrFail($id);
        $borrower->returned =! $borrower->returned;
        $borrower->save();
        return response()->json(['success' => true, 'data' => $borrower],201);
    }
    public function destroy($id) {
        $borrower = Borrower::find($id);
        $borrower->delete();
        return response()->json(['success' => true],201);
    }
}
