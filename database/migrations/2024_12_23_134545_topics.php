<?php

use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;

return new class {

    public function up(Builder $schema): void
    {
        $schema->create('topics', function(Blueprint $table) {
            $table->id();
            $table->foreignId('board_id');
            $table->foreignId('author_id');
            $table->integer('discussion_count', false, true)->default(0);
            $table->integer('like_count', false, true)->default(0);
            $table->string('title', length: 128)->fulltext();
            $table->text('text');
            $table->text('content');
            $table->dateTime('last_reply_at')->nullable();
            $table->datetimes();
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('topics');
    }
};
