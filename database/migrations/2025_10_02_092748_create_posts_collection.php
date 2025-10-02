<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('posts', function (Blueprint $collection) {
            $collection->id(); // adds an _id field
            $collection->string('title');
            $collection->string('content');
            $collection->string('author');
            $collection->dateTime('created_at')->nullable();
            $collection->dateTime('updated_at')->nullable();

            // example index
            $collection->index('title');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('posts');
    }
};
