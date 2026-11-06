<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class HotelFoundationSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_foundation_tables_exist(): void
    {
        foreach (['organizations', 'properties', 'organization_memberships', 'property_memberships', 'room_types', 'rooms'] as $table) {
            $this->assertTrue(Schema::hasTable($table), "Missing table: {$table}");
        }
    }

    public function test_room_numbers_are_unique_within_a_property(): void
    {
        $org = DB::table('organizations')->insertGetId(['name' => 'Demo', 'slug' => 'demo', 'created_at' => now(), 'updated_at' => now()]);
        $property = DB::table('properties')->insertGetId(['organization_id' => $org, 'name' => 'Hotel', 'slug' => 'hotel', 'created_at' => now(), 'updated_at' => now()]);
        $type = DB::table('room_types')->insertGetId(['property_id' => $property, 'name' => 'Standard', 'slug' => 'standard', 'max_occupancy' => 2, 'base_price_minor' => 1000000, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('rooms')->insert(['property_id' => $property, 'room_type_id' => $type, 'room_number' => '101', 'created_at' => now(), 'updated_at' => now()]);
        $this->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);
        DB::table('rooms')->insert(['property_id' => $property, 'room_type_id' => $type, 'room_number' => '101', 'created_at' => now(), 'updated_at' => now()]);
    }
}
