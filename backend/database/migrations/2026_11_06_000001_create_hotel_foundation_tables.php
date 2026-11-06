<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('timezone')->default('Africa/Lagos');
            $table->char('currency', 3)->default('NGN');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country_code', 2)->default('NG');
            $table->string('status')->default('active');
            $table->timestamps();
            $table->unique(['organization_id', 'slug']);
            $table->unique(['id', 'organization_id']);
        });

        Schema::create('organization_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role'); // owner, admin; enforce permitted roles in application layer
            $table->timestamps();
            $table->unique(['organization_id', 'user_id']);
            $table->unique(['id', 'organization_id']);
        });

        Schema::create('property_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id');
            $table->foreignId('property_id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role'); // manager, receptionist, housekeeping
            $table->timestamps();
            $table->foreign(['property_id', 'organization_id'])->references(['id', 'organization_id'])->on('properties')->cascadeOnDelete();
            $table->unique(['property_id', 'user_id']);
        });

        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('max_occupancy');
            $table->unsignedBigInteger('base_price_minor'); // integer minor units, not floats
            $table->char('currency', 3)->default('NGN');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['property_id', 'slug']);
            $table->unique(['id', 'property_id']);
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->restrictOnDelete();
            $table->foreignId('room_type_id');
            $table->string('room_number');
            $table->string('operational_status')->default('active');
            $table->timestamps();
            $table->foreign(['room_type_id', 'property_id'])->references(['id', 'property_id'])->on('room_types')->restrictOnDelete();
            $table->unique(['property_id', 'room_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('room_types');
        Schema::dropIfExists('property_memberships');
        Schema::dropIfExists('organization_memberships');
        Schema::dropIfExists('properties');
        Schema::dropIfExists('organizations');
    }
};
