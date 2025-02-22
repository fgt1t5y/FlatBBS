<?php

use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;

return new class {

    public function up(Builder $schema): void
    {
        $schema->create('user_visit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('visitable_id');
            $table->string('visitable_type')->nullable();
            $table->datetimes();
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('user_visit_logs');
    }
};
