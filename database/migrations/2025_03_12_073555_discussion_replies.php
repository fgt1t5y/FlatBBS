<?php

use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;

return new class {

    public function up(Builder $schema): void
    {
        $schema->create('discussion_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion_id');
            $table->foreignId('author_id');
            $table->foreignId('reply_to_user_id')->nullable();
            $table->integer('like_count', false, true)->default(0);
            $table->integer('score')->default(0);
            $table->text('content');
            $table->datetimes();
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('discussion_replies');
    }
};
