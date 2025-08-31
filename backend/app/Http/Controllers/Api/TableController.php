<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TableService;
use Illuminate\Http\Request;

class TableController extends Controller
{
    protected $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }

    public function index()
    {
        return $this->tableService->getAllTables();
    }

    public function available()
    {
        return $this->tableService->getAvailableTables();
    }

    public function show($id)
    {
        return $this->tableService->getTableById($id);
    }
}
