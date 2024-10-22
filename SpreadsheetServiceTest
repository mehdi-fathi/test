<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\SpreadsheetService;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use App\Jobs\ProcessProductImage;


class SpreadsheetServiceTest extends TestCase
{

    public function test_process_file_success(): void
    {

        $SpreadsheetService = new SpreadsheetService();

        //imagine the file has name product_code 1,2,3 with valid data
        $SpreadsheetService->processSpreadsheet('~/Sites/sample-local-file-correct');

        // database has new record
        $this->assertDatabaseHas('products', [
            'product_code' => 1,
        ]);
        // database has new record
        $this->assertDatabaseHas('products', [
            'product_code' => 2,
        ]);
        // database has new record
        $this->assertDatabaseHas('products', [
            'product_code' => 3,
        ]);

        Bus::fake([ProcessProductImage::class]);
        Bus::assertDispatched(ProcessProductImage::class, 1);
    }

    public function test_process_file_fail_validation(): void
    {

        $SpreadsheetService = new SpreadsheetService();

        //imagine the file has duplicated product_code 1,1 ,correct 3 and file has quantity 0 with product_code 4
        $SpreadsheetService->processSpreadsheet('~/Sites/sample-local-file-wrong');

        $this->assertDatabaseMissing('products', [
            'product_code' => 1,
        ]);

        $this->assertDatabaseMissing('products', [
            'product_code' => 4,
        ]);

        $this->assertDatabaseHas('products', [
            'product_code' => 3,
        ]);

        Bus::fake([ProcessProductImage::class]);
        Bus::assertDispatched(ProcessProductImage::class, 1);
    }
}
