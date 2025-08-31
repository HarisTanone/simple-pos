<?php

namespace App\Services;

use App\Models\Table;
use App\Http\Resources\TableResource;
use App\Utils\ResponseHelper;
use App\Enums\TableStatus;

class TableService
{
    public function getAllTables()
    {
        $tables = Table::with('currentOrder')->orderBy('table_number')->get();

        return ResponseHelper::success(TableResource::collection($tables));
    }

    public function getAvailableTables()
    {
        $tables = Table::where('status', TableStatus::AVAILABLE)
            ->orderBy('table_number')
            ->get();

        return ResponseHelper::success(TableResource::collection($tables));
    }

    public function getTableById(int $id)
    {
        $table = Table::with('currentOrder')->find($id);

        if (!$table) {
            return ResponseHelper::error('Table not found', 404);
        }

        return ResponseHelper::success(new TableResource($table));
    }
}
