<?php namespace Winter\User\Controllers;

use Auth;
use Cms\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lang;
use Flash;
use rainlab\User\Rules\IDNumber;
use Response;
use Redirect;
use BackendMenu;
use BackendAuth;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;
use Tymon\JWTAuth\Token;
use Winter\User\Models\User;
use Winter\User\Models\UserGroup;
use Winter\User\Models\MailBlocker;
use Winter\User\Models\Settings as UserSettings;

class Users extends Controller
{
    use ApiResponser;
    /**
     * @var array Extensions implemented by this controller.
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
    ];

    /**
     * @var array `FormController` configuration.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var array `ListController` configuration.
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var array `RelationController` configuration, by extension.
     */
    public $relationConfig;

    /**
     * @var array Permissions required to view this page.
     */
    public $requiredPermissions = ['winter.users.access_users'];

    /**
     * @var string HTML body tag class
     */
    public $bodyClass = 'compact-container';

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Winter.User', 'user', 'users');
        SettingsManager::setContext('Winter.User', 'settings');
    }

    public function index()
    {
        $this->addJs('/plugins/winter/user/assets/js/bulk-actions.js');

        $this->asExtension('ListController')->index();
    }

    /**
     * {@inheritDoc}
     */
    public function listInjectRowClass($record, $definition = null)
    {
        $classes = [];

        if ($record->trashed()) {
            $classes[] = 'strike';
        }

        if ($record->isBanned()) {
            $classes[] = 'negative';
        }

        if (!$record->is_activated) {
            $classes[] = 'disabled';
        }

        if (count($classes) > 0) {
            return join(' ', $classes);
        }
    }

    public function listExtendQuery($query)
    {
        $query->withTrashed();
    }

    public function formExtendQuery($query)
    {
        $query->withTrashed();
    }

    /**
     * Display username field if settings permit
     */
    public function formExtendFields($form)
    {
        /*
         * Show the username field if it is configured for use
         */
        if (
            UserSettings::get('login_attribute') == UserSettings::LOGIN_USERNAME &&
            array_key_exists('username', $form->getFields())
        ) {
            $form->getField('username')->hidden = false;
        }
    }

    public function formAfterUpdate($model)
    {
        $blockMail = post('User[block_mail]', false);
        if ($blockMail !== false) {
            $blockMail ? MailBlocker::blockAll($model) : MailBlocker::unblockAll($model);
        }
    }

    public function formExtendModel($model)
    {
        $model->block_mail = MailBlocker::isBlockAll($model);

        $model->bindEvent('model.saveInternal', function () use ($model) {
            unset($model->attributes['block_mail']);
        });
    }

    /**
     * Manually activate a user
     */
    public function preview_onActivate($recordId = null)
    {
        $model = $this->formFindModelObject($recordId);

        $model->attemptActivation($model->activation_code);

        Flash::success(Lang::get('winter.user::lang.users.activated_success'));

        if ($redirect = $this->makeRedirect('update-close', $model)) {
            return $redirect;
        }
    }

    /**
     * Manually unban a user
     */
    public function preview_onUnban($recordId = null)
    {
        $model = $this->formFindModelObject($recordId);

        $model->unban();

        Flash::success(Lang::get('winter.user::lang.users.unbanned_success'));

        if ($redirect = $this->makeRedirect('update-close', $model)) {
            return $redirect;
        }
    }

    /**
     * Display the convert to registered user popup
     */
    public function preview_onLoadConvertGuestForm($recordId)
    {
        $this->vars['groups'] = UserGroup::where('code', '!=', UserGroup::GROUP_GUEST)->get();

        return $this->makePartial('convert_guest_form');
    }

    /**
     * Manually convert a guest user to a registered one
     */
    public function preview_onConvertGuest($recordId)
    {
        $model = $this->formFindModelObject($recordId);

        // Convert user and send notification
        $model->convertToRegistered(post('send_registration_notification', false));

        // Remove user from guest group
        if ($group = UserGroup::getGuestGroup()) {
            $model->groups()->remove($group);
        }

        // Add user to new group
        if (
            ($groupId = post('new_group')) &&
            ($group = UserGroup::find($groupId))
        ) {
            $model->groups()->add($group);
        }

        Flash::success(Lang::get('winter.user::lang.users.convert_guest_success'));

        if ($redirect = $this->makeRedirect('update-close', $model)) {
            return $redirect;
        }
    }

    /**
     * Impersonate this user
     */
    public function preview_onImpersonateUser($recordId)
    {
        if (!$this->user->hasAccess('winter.users.impersonate_user')) {
            return Response::make(Lang::get('backend::lang.page.access_denied.label'), 403);
        }

        $model = $this->formFindModelObject($recordId);

        Auth::impersonate($model);

        Flash::success(Lang::get('winter.user::lang.users.impersonate_success'));
    }

    /**
     * Unsuspend this user
     */
    public function preview_onUnsuspendUser($recordId)
    {
        $model = $this->formFindModelObject($recordId);

        $model->unsuspend();

        Flash::success(Lang::get('winter.user::lang.users.unsuspend_success'));

        return Redirect::refresh();
    }

    /**
     * Force delete a user.
     */
    public function update_onDelete($recordId = null)
    {
        $model = $this->formFindModelObject($recordId);

        $model->forceDelete();

        Flash::success(Lang::get('backend::lang.form.delete_success'));

        if ($redirect = $this->makeRedirect('delete', $model)) {
            return $redirect;
        }
    }

    /**
     * Perform bulk action on selected users
     */
    public function index_onBulkAction()
    {
        if (
            ($bulkAction = post('action')) &&
            ($checkedIds = post('checked')) &&
            is_array($checkedIds) &&
            count($checkedIds)
        ) {
            foreach ($checkedIds as $userId) {
                if (!$user = User::withTrashed()->find($userId)) {
                    continue;
                }

                switch ($bulkAction) {
                    case 'delete':
                        $user->forceDelete();
                        break;

                    case 'activate':
                        $user->attemptActivation($user->activation_code);
                        break;

                    case 'deactivate':
                        $user->delete();
                        break;

                    case 'restore':
                        $user->restore();
                        break;

                    case 'ban':
                        $user->ban();
                        break;

                    case 'unban':
                        $user->unban();
                        break;
                }
            }

            Flash::success(Lang::get('winter.user::lang.users.'.$bulkAction.'_selected_success'));
        }
        else {
            Flash::error(Lang::get('winter.user::lang.users.'.$bulkAction.'_selected_empty'));
        }

        return $this->listRefresh();
    }

    public function signUp(Request $request, User $userModel)
    {
        $rules = [
            'email'                 => 'required|email|unique:users',
            'password'              => 'min:6|required',
            'password_confirmation' => 'min:6|same:password|required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->errorResponse($validator->getMessageBag(), self::$ERROR_CODES['VALIDATION_ERROR']);
        }

        try {
            $userModel->checkVerficiationCode($request->all());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        if (!$Response = $userModel->signUp($request)) {
            return $this->errorResponse('Auth Error', self::$ERROR_CODES['AUTH_ERROR']);
        }

        return $this->response($Response);
    }

    public function login(Request $request, User $userModel)
    {
        if (!$Response = $userModel->login($request)) {
            return $this->errorResponse('invalid_credentials', self::$ERROR_CODES['AUTH_ERROR']);
        }
        return $this->response($Response);
    }

    public function sendVerificationCode(Request $request, User $userModel)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->getMessageBag()->toArray(), self::$ERROR_CODES['VALIDATION_ERROR']);
        }
        return $this->response($userModel->sendVerificationCode($request->all()));
    }
}
