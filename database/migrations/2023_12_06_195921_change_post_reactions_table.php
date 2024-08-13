<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the foreign key before renaming the column
        Schema::table('post_reactions', function (Blueprint $table) {
            $table->dropForeign(['post_id']);
        });

        // Rename the column and add a new column
        Schema::table('post_reactions', function (Blueprint $table) {
            $table->unsignedBigInteger('object_id')->after('id');  // Create the new column
        });

        // Copy data from `post_id` to `object_id`
        DB::statement('UPDATE post_reactions SET object_id = post_id');

        // Drop the old column
        Schema::table('post_reactions', function (Blueprint $table) {
            $table->dropColumn('post_id');
        });

        // Add the new column `object_type` and rename the table
        Schema::table('post_reactions', function (Blueprint $table) {
            $table->string('object_type')->after('object_id');
        });

        Schema::rename('post_reactions', 'reactions');

        // Update existing rows
        DB::table('reactions')->update(['object_type' => 'App\Models\Post']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename the table back to the original name
        Schema::rename('reactions', 'post_reactions');

        // Drop the `object_type` column
        Schema::table('post_reactions', function (Blueprint $table) {
            $table->dropColumn('object_type');
        });

        // Add back the `post_id` column and copy data from `object_id`
        Schema::table('post_reactions', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id')->after('id');
        });

        DB::statement('UPDATE post_reactions SET post_id = object_id');

        // Drop the `object_id` column
        Schema::table('post_reactions', function (Blueprint $table) {
            $table->dropColumn('object_id');
        });

        // Re-add the foreign key constraint
        Schema::table('post_reactions', function (Blueprint $table) {
            $table->foreign('post_id')->references('id')->on('posts');
        });
    }
};

