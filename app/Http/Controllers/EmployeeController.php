<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EmployeeService;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function __construct(protected EmployeeService $service)
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $user = auth()->user();
        $items = $this->service->listFor($user);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Employee::class);

        $data = $request->validate([
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'position'=>'nullable|string|in:Manager,Web Developer,Web Designer',
           
        ]);

        $employee = $this->service->createFor(auth()->user(), $data);
        return response()->json($employee, 201);
    }

    public function show(Employee $employee)
    {
        $this->authorize('view', $employee);
        return response()->json($employee);
    }

    public function update(Request $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        $data = $request->validate([
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'position'=>'nullable|string|in:Manager,Web Developer,Web Designer',
           
        ]);

        $employee = $this->service->updateFor(auth()->user(), $employee, $data);
        return response()->json($employee);
    }

    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);
        $this->service->deleteFor(auth()->user(), $employee);
        return response()->json(['message'=>'deleted']);
    }
}
