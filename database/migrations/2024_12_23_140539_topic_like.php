<?php

use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;

return new class {

    public function up(Builder $schema): void
    {
        $schema->create('topic_like', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id');
            $table->foreignId('user_id');
            $table->integer('type', false, true)->default(1);
            $table->datetimes();
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('topic_like');
    }
};
