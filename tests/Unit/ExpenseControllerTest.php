<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class ExpenseControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testIndex()
    {
        $user = User::factory()->create(); // Assuming you have a User model
        $this->actingAs($user); // Authenticate the request as the created user

        $response = $this->get('/api/expensesIndex');

        $response->assertStatus(200);
    }


    /**
     * Test store method of ExpenseController.
     *
     * @return void
     */
    public function testStore()
    {
        // Create a user using the User factory
        $user = User::factory()->create();

        // Authenticate the request as the created user
        $this->actingAs($user);

        // Data for creating an expense
        $expenseData = [
            'price' => 100,
            'description' => 'Test Expense',
            'date' => now()->format('Y-m-d'),
        ];

        // Send a POST request to store the expense
        $response = $this->postJson('/api/expenses', $expenseData);

        // Assert that the request was successful (status code 200)
        $response->assertStatus(200);

        // Assert that the response contains the expense data
        $response->assertJson([
            'message' => 'expenses retrieved successfully',
            'expenses' => [
                'price' => 100,
                'description' => 'Test Expense',
                'date' => now()->format('Y-m-d'),
            ]
        ]);

        // Optionally, you can assert that the expense was stored in the database
        $this->assertDatabaseHas('expenses', $expenseData);
    }
}
