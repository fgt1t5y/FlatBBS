<?php

namespace app\controller;

use support\Request;
use app\service\AuthService;
use app\service\FileService;
use app\service\UserService;
use app\service\UserVisitLogService;
use app\service\SettingService;
use DI\Attribute\Inject;

class MeController
{
    #[Inject]
    protected FileService $file;

    #[Inject]
    protected UserService $user;

    #[Inject]
    protected AuthService $auth;

    #[Inject]
    protected SettingService $setting;

    #[Inject]
    protected UserVisitLogService $userVisitLog;

    public function logs(Request $request)
    {
        $request->assertLogin();

        $page = $request->get('page');
        $limit = $request->get('limit');

        return ok($this->userVisitLog->getVisitLogs(
            $request->getUser(),
            $page,
            $limit,
        ));
    }

    public function info(Request $request)
    {
        $request->assertLogin();

        return ok($request->getUser());
    }

    public function modify(Request $request)
    {
        $request->assertLogin();
        $request->assertPermission('user:modify');

        $attributes = $request->post();

        $request->assertNotEmptyArray($attributes);

        $result = $this->user->modifyUserInfo($request->getUser(), $attributes);

        if (!$result) {
            return no(STATUS_INTERNAL_ERROR);
        }

        return ok();
    }

    public function avatar(Request $request)
    {
        $request->assertLogin();

        $file = $request->file('avgfile');

        if (!$file) {
            return no(STATUS_BAD_REQUEST, '$exception.fill_out_form_completely');
        }

        if (
            !in_array(
                $file->getUploadMimeType(),
                $this->setting->getArrayValue('allowedImageType')
            )
        ) {
            return no(STATUS_BAD_REQUEST, '$exception.invalid_file_type');
        }

        $uri = $this->file->saveUserAvatar($request->file('avgfile'));

        if (!$uri) {
            return no(STATUS_INTERNAL_ERROR);
        }

        $result = $this->user->modifyUserInfo(
            $request->getUser(),
            ['avatar_uri' => $uri]
        );

        if (!$result) {
            return no(STATUS_INTERNAL_ERROR);
        } else {
            return ok();
        }
    }

    public function password(Request $request)
    {
        $request->assertLogin();

        $old_password = $request->post('old_password');
        $new_password = $request->post('new_password');

        if (!all([$old_password, $new_password]) || $old_password === $new_password) {
            return no(STATUS_BAD_REQUEST);
        }

        $user = $request->getUser();

        if (!password_verify($old_password, $user->password)) {
            return no(STATUS_FORBIDDEN, '$exception.password_is_wrong');
        }

        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $result = $this->user->modifyUserInfo($user, ['password' => $new_password]);

        $this->auth->logoutAll($user->id);

        if (!$result) {
            return no(STATUS_INTERNAL_ERROR);
        } else {
            return ok();
        }
    }
}
