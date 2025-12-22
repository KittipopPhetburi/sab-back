<?php

namespace App\Http\Controllers;

use App\Models\CreditNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreditNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CreditNote::query();

        // Optional filtering
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('credit_note_no', 'like', "%{$search}%")
                  ->orWhere('customer', 'like', "%{$search}%")
                  ->orWhere('invoice_ref', 'like', "%{$search}%");
            });
        }

        $creditNotes = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $creditNotes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate
        $validator = Validator::make($request->all(), [
            'credit_note_no' => 'required|string|unique:credit_notes,credit_note_no',
            'date' => 'required|date',
            'customer' => 'required|string',
            'invoice_ref' => 'nullable|string',
            'items' => 'nullable', // accept array or json string
            'status' => 'nullable|in:draft,pending,paid,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Prepare Data
        $data = $request->all();
        
        // Ensure items is properly formatted (if sent as string JSON, Laravel casts might handle it, but being safe)
        if (isset($data['items']) && is_string($data['items'])) {
            $data['items'] = json_decode($data['items'], true);
        }

        // Default status if not provided (though migration has default)
        if (!isset($data['status'])) {
            $data['status'] = 'draft';
        }

        // 3. Create
        try {
            $creditNote = CreditNote::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Credit Note created successfully',
                'data' => $creditNote
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create Credit Note',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $creditNote = CreditNote::find($id);

        if (!$creditNote) {
            return response()->json([
                'status' => 'error',
                'message' => 'Credit Note not found'
            ], 404);
        }

        return response()->json($creditNote);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $creditNote = CreditNote::find($id);

        if (!$creditNote) {
            return response()->json([
                'status' => 'error',
                'message' => 'Credit Note not found'
            ], 404);
        }

        // Validate (Unique check except current id)
        $validator = Validator::make($request->all(), [
            'credit_note_no' => 'sometimes|required|string|unique:credit_notes,credit_note_no,' . $id,
            'date' => 'sometimes|required|date',
            'customer' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            if (isset($data['items']) && is_string($data['items'])) {
                $data['items'] = json_decode($data['items'], true);
            }

            $creditNote->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Credit Note updated successfully',
                'data' => $creditNote
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update Credit Note',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $creditNote = CreditNote::find($id);

        if (!$creditNote) {
            return response()->json([
                'status' => 'error',
                'message' => 'Credit Note not found'
            ], 404);
        }

        try {
            $creditNote->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Credit Note deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete Credit Note',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
