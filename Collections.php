 $employees = [
        ['name' => 'John', 'city' => 'Dallas'],
        ['name' => 'Jane', 'city' => 'Austin'],
        ['name' => 'Jake', 'city' => 'Dallas'],
        ['name' => 'Jill', 'city' => 'Dallas'],
    ];

    $offices = [
        ['office' => 'Dallas HQ', 'city' => 'Dallas'],
        ['office' => 'Dallas South', 'city' => 'Dallas'],
        ['office' => 'Austin Branch', 'city' => 'Austin'],
    ];

    /*
    $output = [
        "Dallas" => [
            "Dallas HQ" => ["John", "Jake", "Jill"],
            "Dallas South" => ["John", "Jake", "Jill"],
        ],
        "Austin" => [
            "Austin Branch" => ["Jane"],
        ],
    ];
    */

    $employeesCollection = collect($employees);
    $officesCollection = collect($offices);

    $groupedEmployees = $employeesCollection->groupBy('city')->map(function ($employee) {
        return $employee->map(function ($user) {
            return $user['name'];
        })->toArray();
    });

    $output = $groupedEmployees->mapWithKeys(function ($itemEmployee, $key) use ($officesCollection) {
        $out = $officesCollection->where('city', $key)->mapWithKeys(function ($item) use ($itemEmployee) {
            return [$item['office'] => $itemEmployee];
        });
        return [$key => $out->toArray()];
    })->toArray();

    dd($output);
