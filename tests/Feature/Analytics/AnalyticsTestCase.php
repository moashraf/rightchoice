<?php

namespace Tests\Feature\Analytics;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * قاعدة اختبارات تحليلات العقار.
 *
 * لأن مخطط قاعدة البيانات في هذا المشروع قديم ولا يحتوي على Migrations
 * لجداول aqar / users، نُنشئ يدويًا الجداول الحد الأدنى اللازمة داخل SQLite في الذاكرة،
 * ثم نُطبّق Migration تحليلات العقار كما هي.
 */
abstract class AnalyticsTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DB::purge();
        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite' => [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
            'foreign_key_constraints' => false,
        ]]);

        $this->buildMinimalSchema();
        Cache::flush();
    }

    protected function buildMinimalSchema(): void
    {
        Schema::dropIfExists('aqar_analytics_events');
        Schema::dropIfExists('aqar');
        Schema::dropIfExists('users');
        Schema::dropIfExists('wish_list');
        Schema::dropIfExists('usercontactaqar');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('MOP')->nullable();
            $table->tinyInteger('TYPE')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('isAdmin')->default(0);
            $table->tinyInteger('phone_verfied_sms_status')->default(1);
            $table->unsignedBigInteger('role_id')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('aqar', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('vip')->default(0);
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('wish_list', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('aqars_id');
            $table->timestamps();
        });

        Schema::create('usercontactaqar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('aqars_id');
            $table->tinyInteger('contact_via_whats_app')->default(0);
            $table->timestamps();
        });

        Schema::create('aqar_analytics_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aqar_id');
            $table->string('event_type', 40);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('visitor_hash', 64)->nullable();
            $table->string('session_id', 100)->nullable();
            $table->string('source', 40)->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('occurred_at')->useCurrent();
            $table->timestamps();

            $table->index('aqar_id');
            $table->index('event_type');
            $table->index('occurred_at');
            $table->index('user_id');
            $table->index('visitor_hash');
        });
    }

    protected function makeUser(array $attrs = []): int
    {
        return DB::table('users')->insertGetId(array_merge([
            'name'       => 'Test User',
            'email'      => 'user_' . uniqid() . '@test.local',
            'password'   => bcrypt('secret'),
            'MOP'        => '01000000000',
            'TYPE'       => 1,
            'status'     => 1,
            'isAdmin'    => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ], $attrs));
    }

    protected function makeAqar(array $attrs = []): int
    {
        return DB::table('aqar')->insertGetId(array_merge([
            'slug'       => 'aqar-' . uniqid(),
            'title'      => 'Test Aqar',
            'user_id'    => $this->makeUser(),
            'status'     => 1,
            'views'      => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ], $attrs));
    }
}
