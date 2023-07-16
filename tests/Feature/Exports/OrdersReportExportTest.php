<?php

namespace Tests\Feature\Exports;

use Tests\TestCase;
use App\Exports\OrdersReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrdersReportExportTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use WithFaker, RefreshDatabase;

    public function testOrdersReportExportQuery(): void
    {
        $filters = [
            'date1' => '2023-07-01',
            'date2' => '2023-07-31',
            'orderStatus' => 'PENDING',
            'minAmount' => 150,
            'maxAmount' => 300,
        ];

        $export = new OrdersReportExport($filters);

        $result = Excel::store($export, 'orders-report.xlsx');

        $this->assertTrue($result);
    }
}
