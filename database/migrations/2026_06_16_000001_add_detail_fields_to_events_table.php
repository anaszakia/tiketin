<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('short_description')->nullable()->after('description');
            $table->string('venue_name')->nullable()->after('location');
            $table->text('address_detail')->nullable()->after('venue_name');
            $table->string('city')->nullable()->after('address_detail');
            $table->string('province')->nullable()->after('city');
            $table->string('map_url')->nullable()->after('province');
            $table->text('terms')->nullable()->after('capacity');
            $table->text('rundown')->nullable()->after('terms');
            $table->string('contact_name')->nullable()->after('rundown');
            $table->string('contact_phone')->nullable()->after('contact_name');
            $table->string('contact_email')->nullable()->after('contact_phone');
            $table->unsignedTinyInteger('minimum_age')->nullable()->after('contact_email');
            $table->text('refund_policy')->nullable()->after('minimum_age');
            $table->json('gallery_images')->nullable()->after('banner');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'short_description',
                'venue_name',
                'address_detail',
                'city',
                'province',
                'map_url',
                'terms',
                'rundown',
                'contact_name',
                'contact_phone',
                'contact_email',
                'minimum_age',
                'refund_policy',
                'gallery_images',
            ]);
        });
    }
};
