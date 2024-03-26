<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Info(
 *      title="Budget Buddy API",
 *      version="1.0.0",
 *      description="API documentation for Budget Buddy",
 *      @OA\Contact(
 *          email="anasaliky3@gmail.com"
 *      ),
 *      @OA\License(
 *          name="MIT License",
 *          url="https://opensource.org/licenses/MIT"
 *      )
 * )
 */
class ExpenseController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/expensesIndex",
     *     summary="Get all expenses",
     *     tags={"Expenses"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all expenses",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                  @OA\Property(property="price", type="number"),
     *                  @OA\Property(property="description", type="string"),
     *                  @OA\Property(property="date", type="string", format="date"),
     *                  @OA\Property(property="created_at", type="string"),
     *                  @OA\Property(property="updated_at", type="string")
     *             )
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function index()
    {
        //
        try{
            $expenses = Expense::all();
            return response()->json([
                "message" => "expenses retrieved successfully",
                "expenses" => $expenses
            ]);
        }catch(\Exception $e){
            return response()->json(["message" => "retrieved all expenses wrong", $e->getMessage()],500);
        }

    }


    /**
     * @OA\Post(
     *     path="/api/expenses",
     *     summary="Create a new expense",
     *     tags={"Expenses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="date", type="string", format="date"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="date", type="string", format="date"),
     *             @OA\Property(property="created_at", type="string"),
     *             @OA\Property(property="updated_at", type="string")
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function store(Request $request)
    {
        //
        //$this->authorize("view", Expense::class);
        try{
            $data = $request->all();
            $data["user_id"] =  Auth::id();
            $expense = Expense::create($data);
            return response()->json([
                "message" => "expenses retrieved successfully",
                "expenses" => $expense
            ]);
        }catch(\Exception $e){
            return response()->json(["message" => "store  expense wrong", $e->getMessage()],500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/expenses/{id}",
     *     summary="Get a specific expense",
     *     tags={"Expenses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the expense",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="date", type="string", format="date"),
     *             @OA\Property(property="created_at", type="string"),
     *             @OA\Property(property="updated_at", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense not found"
     *     )
     * )
     */
    public function show($id)
    {
        //
        try{
            $expense = Expense::findOrFail($id);
            return response()->json([
                "message" => "expense retrieved successfully",
                "expenses" => $expense
            ]);
        }catch(\Exception $e){
            return response()->json(["message" => "expense retrieved by id wrong", $e->getMessage()],500);
        }
    }



    /**
     * @OA\Put(
     *     path="/api/expensesUpdate/{id}",
     *     summary="Update an existing expense",
     *     tags={"Expenses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the expense",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="date", type="string", format="date"),
     *             @OA\Property(property="created_at", type="string"),
     *             @OA\Property(property="updated_at", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="date", type="string", format="date"),
     *             @OA\Property(property="created_at", type="string"),
     *             @OA\Property(property="updated_at", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense not found"
     *     )
     * )
     */
    public function update(ExpenseRequest $request, $id)
    {
        //$expense = Expense::findOrFail($id);

       // $this->authorize('update', $expense);
        try{
            $expense = Expense::findOrFail($id);
            $expense->update($request->all());
            return response()->json([
                "message" => "expenses updated successfully",
                "expenses" => $expense
            ]);
        }catch(\Exception $e){
            return response()->json(["message" => "update  expense wrong", $e->getMessage()],500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/expensesDelete/{id}",
     *     summary="Delete an existing expense",
     *     tags={"Expenses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the expense",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        //
        try{
            $expense = Expense::findOrFail($id);
            $expense->delete();
            return response()->json([
                "message" => "expense deleted successfully",
            ]);
        }catch(\Exception $e){
            return response()->json(["message" => "update  expense wrong", $e->getMessage()],500);
        }
    }
}
