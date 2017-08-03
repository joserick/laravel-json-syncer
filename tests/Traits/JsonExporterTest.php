<?php

namespace MathieuTu\JsonImport\Tests\Traits;

use MathieuTu\JsonImport\Tests\Stubs\Bar;
use MathieuTu\JsonImport\Tests\Stubs\Baz;
use MathieuTu\JsonImport\Tests\Stubs\DoNotExport;
use MathieuTu\JsonImport\Tests\Stubs\Foo;
use MathieuTu\JsonImport\Tests\TestCase;

class JsonExporterTest extends TestCase
{

    public function testExportToJson()
    {
        (new Foo)->create(['author' => 'Mathieu TUDISCO', 'username' => '@mathieutu'])
            ->bars()->createMany([
                ['name' => 'bar1'],
                ['name' => 'bar2'],
            ])->each(function (Bar $bar) {
                $bar->baz()->create(['name' => $bar->name . '_baz'])
                    ->doNots()->createMany([
                        ['name' => 'do not 1'],
                        ['name' => 'do not 2'],
                        ['name' => 'do not 3'],
                    ]);
            });

        $this->assertEquals(
            json_decode(file_get_contents(__DIR__ . '/../Stubs/import.json')),
            json_decode(Foo::first()->exportToJson())
        );
    }
}