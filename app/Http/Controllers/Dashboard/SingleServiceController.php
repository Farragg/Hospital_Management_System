<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSingleServiceRequest;
use App\Interfaces\Services\SingleServiceRepositoryInterface;
use Illuminate\Http\Request;

class SingleServiceController extends Controller
{
    private $SingleService;
    public function __construct(SingleServiceRepositoryInterface $SingleService)
    {
        $this->SingleService= $SingleService;
    }

    public function index()
    {
        return $this->SingleService->index();
    }

    public function create()
    {
        //
    }


    public function store(StoreSingleServiceRequest $request)
    {
        return $this->SingleService->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    public function update(StoreSingleServiceRequest $request)
    {
        return $this->SingleService->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->SingleService->delete($request);
    }
}
