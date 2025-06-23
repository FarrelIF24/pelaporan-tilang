<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ViolationRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ViolationRuleController extends Controller
{
    /**
     * Display a listing of the violation rules.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $violationRules = ViolationRule::all();
        return response()->json([
            'success' => true,
            'data' => $violationRules
        ]);
    }

    /**
     * Store a newly created violation rule in storage.
     * Only accessible to Polantas users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:violation_rules',
            'description' => 'required|string',
            'fine_amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $violationRule = ViolationRule::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Violation rule created successfully',
            'data' => $violationRule
        ], 201);
    }

    /**
     * Display the specified violation rule.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $violationRule = ViolationRule::find($id);
        
        if (!$violationRule) {
            return response()->json([
                'success' => false,
                'message' => 'Violation rule not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $violationRule
        ]);
    }

    /**
     * Update the specified violation rule in storage.
     * Only accessible to Polantas users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'string|max:255|unique:violation_rules,code,' . $id,
            'description' => 'string',
            'fine_amount' => 'numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $violationRule = ViolationRule::find($id);
        
        if (!$violationRule) {
            return response()->json([
                'success' => false,
                'message' => 'Violation rule not found'
            ], 404);
        }

        $violationRule->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Violation rule updated successfully',
            'data' => $violationRule
        ]);
    }

    /**
     * Remove the specified violation rule from storage.
     * Only accessible to Polantas users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $violationRule = ViolationRule::find($id);
        
        if (!$violationRule) {
            return response()->json([
                'success' => false,
                'message' => 'Violation rule not found'
            ], 404);
        }

        // Check if this violation rule is used in any report
        if ($violationRule->reports()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete violation rule as it is referenced in reports'
            ], 409);
        }

        $violationRule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Violation rule deleted successfully'
        ]);
    }
}
