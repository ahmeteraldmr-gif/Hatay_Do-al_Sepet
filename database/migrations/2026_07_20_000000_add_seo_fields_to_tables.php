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
        Schema::table('products', function (Blueprint $table) {
            $table->string('seo_title')->nullable()->after('in_stock');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->string('og_title')->nullable()->after('seo_description');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');
            $table->boolean('noindex')->default(false)->after('og_image');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('seo_title')->nullable()->after('description');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->string('og_title')->nullable()->after('seo_description');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');
            $table->boolean('noindex')->default(false)->after('og_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description', 'og_title', 'og_description', 'og_image', 'noindex']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description', 'og_title', 'og_description', 'og_image', 'noindex']);
        });
    }
};
