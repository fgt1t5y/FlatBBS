<?php

use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;

return new class {

    public function up(Builder $schema): void
    {
        $schema->table('discussions', function (Blueprint $table) {
            $table->integer('reply_count', false, true)->default(0);
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropColumns('discussions', 'reply_count');
    }
};
