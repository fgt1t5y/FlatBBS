<?php

use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;

return new class {

    public function up(Builder $schema): void
    {
        $schema->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('display_name', length: 32)->fulltext('display_name');
            $table->string('username', length: 32);
            $table->string('password', length: 256);
            $table->string('email', length: 64)->unique();
            $table->string('avatar_uri', length: 128);
            $table->boolean('allow_login')->default(true);
            $table->string('introduction', length: 128)->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->datetimes();

            $table->engine('Mroonga');
            $table->comment('engine "InnoDB"');
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('users');
    }
};
