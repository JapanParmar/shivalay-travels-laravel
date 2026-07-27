<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('agent');
            $table->string('avatar')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('inquiries', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('customerName');
            $table->string('customerPhone');
            $table->string('customerEmail')->nullable();
            $table->string('destinations')->nullable();
            $table->string('duration')->nullable();
            $table->integer('travelers')->default(1);
            $table->string('budget')->nullable();
            $table->string('accommodation')->nullable();
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('customerName');
            $table->string('customerPhone');
            $table->string('customerEmail')->nullable();
            $table->string('fromCity')->nullable();
            $table->string('toCity')->nullable();
            $table->string('travelType'); // flight, train, bus, taxi, cruise
            $table->date('date');
            $table->date('returnDate')->nullable();
            $table->integer('passengers')->default(1);
            $table->string('classType')->nullable();
            $table->string('status')->default('pending');
            $table->decimal('amount', 12, 2)->default(0.00);
            $table->string('agentId')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('India');
            $table->string('type')->default('airport');
            $table->boolean('isPopular')->default(false);
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        Schema::create('packages', function (Blueprint $table) {
            $table->string('id')->primary(); // text key e.g. 'kedarnath'
            $table->string('name');
            $table->string('region')->nullable();
            $table->string('tagline')->nullable();
            $table->string('duration')->nullable();
            $table->string('groupSize')->nullable();
            $table->string('difficulty')->nullable();
            $table->string('bestSeason')->nullable();
            $table->string('startingFrom')->nullable();
            $table->json('tags')->nullable();
            $table->json('highlights')->nullable();
            $table->json('includes')->nullable();
            $table->string('imagePath')->nullable();
            $table->json('gallery')->nullable();
            $table->timestamps();
        });

        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('title');
            $table->string('readTime')->nullable();
            $table->string('badge')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        Schema::create('hotels', function (Blueprint $table) {
            $table->string('id')->primary(); // text key e.g. 'hotel-1'
            $table->string('name');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('price')->nullable();
            $table->string('imagePath')->nullable();
            $table->string('rating')->nullable();
            $table->json('amenities')->nullable();
            $table->json('gallery')->nullable();
            $table->timestamps();
        });

        Schema::create('villas', function (Blueprint $table) {
            $table->string('id')->primary(); // text key e.g. 'villa-1'
            $table->string('name');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('price')->nullable();
            $table->string('imagePath')->nullable();
            $table->string('rating')->nullable();
            $table->json('amenities')->nullable();
            $table->json('gallery')->nullable();
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->text('quote');
            $table->string('name');
            $table->string('location')->nullable();
            $table->string('destination')->nullable();
            $table->string('trip')->nullable();
            $table->integer('rating')->default(5);
            $table->string('avatar')->nullable();
            $table->string('image')->nullable();
            $table->string('clientImage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('villas');
        Schema::dropIfExists('hotels');
        Schema::dropIfExists('guides');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('inquiries');
        Schema::dropIfExists('admin_users');
    }
};
