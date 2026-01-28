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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('email');
            $table->string('job_title')->nullable()->after('name');
            $table->string('location')->nullable()->after('job_title');
            $table->string('phone')->nullable()->after('email');
            $table->text('bio')->nullable()->after('phone');
            $table->string('country')->nullable()->after('bio');
            $table->string('city_state')->nullable()->after('country');
            $table->string('postal_code')->nullable()->after('city_state');
            $table->string('tax_id')->nullable()->after('postal_code');
            $table->string('facebook_url')->nullable()->after('tax_id');
            $table->string('twitter_url')->nullable()->after('facebook_url');
            $table->string('linkedin_url')->nullable()->after('twitter_url');
            $table->string('instagram_url')->nullable()->after('linkedin_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_picture',
                'job_title',
                'location',
                'phone',
                'bio',
                'country',
                'city_state',
                'postal_code',
                'tax_id',
                'facebook_url',
                'twitter_url',
                'linkedin_url',
                'instagram_url',
            ]);
        });
    }
};
