<?php

namespace ikepu_tp\SecureAuth\app\Http\Services;

use ikepu_tp\SecureAuth\app\Events\NewDeviceEvent;
use ikepu_tp\SecureAuth\app\Models\Sa_logged_device;
use ikepu_tp\SecureAuth\app\Models\Sa_login_history;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class NewDeviceService
{

    /**
     * save the logged device
     *
     * @param User $user
     * @param Sa_login_history $sa_login_history
     */
    static public function save_logged_device(User $user, Sa_login_history $sa_login_history): void
    {
        $new_deviceId = Str::uuid();
        $cookie_deviceId = Cookie::get("loggedDeviceId");
        $sa_logged_device = Sa_logged_device::query()
            ->where([
                ["loggedDeviceId", $cookie_deviceId],
                ["user_id", $user->getKey()]
            ])
            ->first();
        if (!$sa_logged_device) {
            $sa_logged_device = new Sa_logged_device();
            event(new NewDeviceEvent($user, $sa_login_history));
        }
        Cookie::queue("loggedDeviceId", $new_deviceId, 10080, "/", null, true, true, false, null);
        $sa_logged_device->fill([
            "loggedDeviceId" => $new_deviceId,
            "user_id" => $user->getKey(),
        ]);
        $sa_logged_device->save();
    }
}
