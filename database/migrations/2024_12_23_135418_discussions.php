<?php

use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;

return new class {

    public function up(Builder $schema): void
    {
        $schema->create('discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id');
            $table->foreignId('author_id');
            $table->integer('like_count', false, true)->default(0);
            $table->text('content');
            $table->datetimes();
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('discussions');
    }
};
