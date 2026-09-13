<?php

namespace App\Policies;

use App\Models\aqar;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Policy لضبط من يستطيع الوصول للوحة تحليلات عقار.
 *
 * القاعدة: فقط مالك العقار يستطيع فتح تحليلاته.
 * الأدمن اختياريًا يمكنه الاطلاع (يظل ضمن نطاق المهمة الحالية عن البائع).
 */
class AqarAnalyticsPolicy
{
    use HandlesAuthorization;

    public function view(User $user, aqar $aqar): bool
    {
        if ((int) $aqar->user_id === (int) $user->getAuthIdentifier()) {
            return true;
        }

        if (method_exists($user, 'isAdminRole') && $user->isAdminRole()) {
            return true;
        }

        return false;
    }
}
