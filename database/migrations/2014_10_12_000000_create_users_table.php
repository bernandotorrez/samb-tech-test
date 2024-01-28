<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->string('uuid_user', 100)->primary();
                $table->string('username', 50)->unique();
                $table->string('name', 100);
                $table->string('password', 100);
                $table->enum('level', ['Admin', 'User'])->default('User');
                $table->enum('status', ['1', '0'])->default('1')->comment('1 = Active, 0 = Non-Active');
                $table->rememberToken();
                $table->timestamps();
            });

            User::create(
                [
                    'uuid_user' => (string) Str::uuid(),
                    'username' => 'admin',
                    'name' => 'Admin',
                    'level' => 'Admin',
                    'password' => Hash::make('AdminCMSBackend!')
                ]
            );
            User::create(
                [
                    'uuid_user' => (string) Str::uuid(),
                    'username' => 'user',
                    'name' => 'User',
                    'level' => 'User',
                    'password' => Hash::make('user')
                ],
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
