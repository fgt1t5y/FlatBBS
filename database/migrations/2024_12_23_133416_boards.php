<?php

use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;

return new class {

    public function up(Builder $schema): void
    {
        $schema->create('boards', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 32)->fulltext();
            $table->string('slug', length: 32)->unique();
            $table->string('avatar_uri', length: 128);
            $table->string('description')->nullable();
            $table->integer('topic_count', false, true)->default(0);
            $table->datetimes();
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('boards');
    }
};
