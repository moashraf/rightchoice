<?php

namespace Tests\Feature\Mobile;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Schema;

abstract class MobileTestCase extends TestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../../../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        return $app;
    }

    protected function setUp(): void
    {
        parent::setUp();
        // This suite never migrates the application's external/legacy databases.
        $this->assertSame('sqlite', config('database.default'));
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->string('MOP')->nullable();
            $table->string('updated_by')->nullable();
            $table->integer('TYPE')->default(1);
            $table->integer('status')->default(0);
            $table->boolean('isAdmin')->default(false);
            $table->boolean('phone_verfied_sms_status')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('users_priceing_sale', function (Blueprint $table) {
            $table->id();
            foreach (['user_id', 'pricing_id', 'start_points', 'current_points', 'sub_points', 'statues'] as $column) {
                $table->integer($column);
            }
            $table->timestamps();
        });
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
        (require database_path('migrations/2026_09_08_000001_add_social_identity_to_users.php'))->up();
        (require database_path('migrations/2026_09_08_000002_create_fcm_tokens_table.php'))->up();
    }
}
