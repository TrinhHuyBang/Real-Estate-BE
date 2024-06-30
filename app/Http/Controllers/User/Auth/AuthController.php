<?php

namespace App\Http\Controllers\User\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Repos\UserRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\SendEmail;
use App\Repos\BrokerageAreaRepo;
use App\Repos\BrokerRepo;
use App\Repos\EnterpriseRepo;
use App\Repos\NotificationRepo;
use App\Repos\PasswordResetRepo;
use App\Repos\SubFieldRepo;
use App\Repos\VerifyEmailTokenRepo;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class AuthController extends Controller
{
    use HandleJsonResponse;
    protected UserRepo $userRepo;
    protected PasswordResetRepo $passwordResetRepo;
    protected VerifyEmailTokenRepo $verifyEmailTokenRepo;
    protected EnterpriseRepo $enterpriseRepo;
    protected SubFieldRepo $subFieldRepo;
    protected BrokerRepo $brokerRepo;
    protected BrokerageAreaRepo $brokerageAreaRepo;
    protected NotificationRepo $notificationRepo;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(
        UserRepo $userRepo,
        PasswordResetRepo $passwordResetRepo,
        VerifyEmailTokenRepo $verifyEmailTokenRepo,
        EnterpriseRepo $enterpriseRepo,
        SubFieldRepo $subFieldRepo,
        BrokerRepo $brokerRepo,
        BrokerageAreaRepo $brokerageAreaRepo,
        NotificationRepo $notificationRepo)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'unauth', 'resetPassword', 'forgetPassword', 'verifyEmail']]);
        $this->userRepo = $userRepo;
        $this->passwordResetRepo = $passwordResetRepo;
        $this->verifyEmailTokenRepo = $verifyEmailTokenRepo;
        $this->enterpriseRepo = $enterpriseRepo;
        $this->subFieldRepo = $subFieldRepo;
        $this->brokerRepo = $brokerRepo;
        $this->brokerageAreaRepo = $brokerageAreaRepo;
        $this->notificationRepo = $notificationRepo;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $username = $request->get('username');
            $password = $request->get('password');
            
            if (str_contains($username, '@')) {
                $credentials = [
                    'email' => $username,
                    'password' => $password
                ];
            } else {
                $credentials = [
                    'phone' => $username,
                    'password' => $password
                ];
            }

            if (!$token = auth()->attempt($credentials)) {
                throw new Exception('Sai tài khoản hoặc mật khẩu', 401);
            }

            if (!$user = $this->userRepo->checkStatus($username)) {
                throw new Exception('Tài khoản đang bị khoá', 401);
            }

            //Email đã verify chưa
            if(!$user->email_verified_at) {
                throw new Exception("Tài khoản chưa được xác thực");
            }
            return $this->respondWithToken($token);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Generate token verify and Send email verify
     */

    public function sendVerifyEmail($email, $user_name)
    {
        $check_email = $this->verifyEmailTokenRepo->get($email);
        // Tạo một token để verify
        $token = Str::random(40);
        if ($check_email) {
            // Nếu đã tồn tại lịch sử thì cập nhật lại token
            $this->verifyEmailTokenRepo->edit($email, $token);
        } else {
            // Nếu chưa có thì thêm mới
            $this->verifyEmailTokenRepo->create([
                'email' => $email,
                'token' => $token,
            ]);
        }

        $data = [
            'from_email' => config('app.mail_from_address'),
            'subject' => 'Yêu cầu xác thực email',
            'user_name' => $user_name,
            'to_email' => $email,
            'type' => -1,
            'redirect_url' => config('app.url') . "/api/auth/verify-email?token=" . $token . "&email=" . $email,
        ];
        Mail::to($email)->send(new SendEmail($data));
    }

    /**
     * Verify email address
     */

    public function verifyEmail(Request $request)
    {
        try {
            $token = $request->get('token');
            $email = $request->get('email');
            // Kiểm tra email và token có khớp nhau không
            $check_token = $this->verifyEmailTokenRepo->getByEmailAndToken($email, $token);
            if (!$check_token) {
                throw new Exception("Token không hợp lệ");
            }

            // Kiểm tra email đã được sử dụng để đăng kí hay chưa
            $user = $this->userRepo->findUserByEmail($email);
            if (!$user) {
                throw new Exception("Tài khoản email không đúng");
            }
            // Kiểm tra email đã được verify trước đó hay chưa
            if ($user->email_verified_at) {
                return redirect()->route('verifyFail');
            }
            $user = $this->userRepo->edit($user->id, ['email_verified_at' => Carbon::now()]);
            return redirect()->route('verifySuccess');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('verifyFail');
        }
    }

    public function register(Request $request)
    {
        try {
            $user_phone = $this->userRepo->findUserByPhone($request->get('phone'));
            $user_email = $this->userRepo->findUserByEmail($request->get('email'));
            if ($user_phone) {
                throw new Exception('Số điện thoại đã đăng ký');
            } elseif ($user_email) {
                throw new Exception('Email đã đăng ký');
            } else {
                $user = $this->userRepo->create([
                    'avatar' => $request->get('avatar'),
                    'name' => $request->get('username'),
                    'phone' => $request->get('phone'),
                    'email' => $request->get('email'),
                    'password' => bcrypt($request->get('password'))
                ]);
                // Generate token và gửi email yêu cầu verify
                $this->sendVerifyEmail($request->get('email'), $request->get('name'));
                return $this->handleSuccessJsonResponse($user);
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Generate a token for user when forget password
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgetPassword(Request $request)
    {
        try {
            $email = $request->get('email');
            $user = $this->userRepo->findUserByEmail($email);
            // Check mail tồn tại hay không
            if (!$user) {
                throw new Exception("Email không tồn tại");
            }
            $token = Str::random(40);

            // Check xem đã từng có request reset password nào của email này chưa
            // Chưa có thì tạo mới
            // Có thì update lại token
            $passwordResetRequest = $this->passwordResetRepo->get($email);
            if ($passwordResetRequest) {
                $this->passwordResetRepo->edit($email, $token);
            } else {
                $this->passwordResetRepo->create([
                    'email' => $email,
                    'token' => $token,
                ]);
            }
            $data = [
                'from_email' => config('app.mail_from_address'),
                'type' => -2,
                'subject' => 'Yêu cầu đặt lại mật khẩu',
                'to_email' => $email,
                'redirect_url' => 'http://103.195.238.178/thay-doi-mat-khau/' . $token,
            ];
            Mail::to($email)->send(new SendEmail($data));
            return $this->handleSuccessJsonResponse($token);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Reset password
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        try {
            $token = $request->get('token');
            // Kiểm tra token có đúng hay không (Xác minh xem email nào)
            $check_token = $this->passwordResetRepo->getByToken($token);
            if(!$check_token) {
                throw new Exception("Token không hợp lệ");
            }
            $new_password = $request->get('new_password');
            $confirm_password = $request->get('confirm_password');
            // Xác nhận lại mật khẩu mới
            if ($new_password !== $confirm_password) {
                throw new Exception("Xác nhận mật khẩu không khớp");
            }

            // Kiểm tra email tương ứng với tài khoản nào không
            $user = $this->userRepo->findUserByEmail($check_token->email);
            if (!$user) {
                throw new Exception("Email không tồn tại");
            }

            // Cập nhật lại mật khẩu
            $this->userRepo->edit($user->id, ['password' => bcrypt($new_password)]);
            return $this->handleSuccessJsonResponse();
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        $user = auth()->user();
        $user->bookmark = $this->userRepo->getNumberBookmark($user->id);
        $user->notification = $this->notificationRepo->getCountUnreadByUser($user->id);
        if($user->role == UserRole::BROKER) {
            $user->broker_infor = $this->brokerRepo->getDetailByUserId($user->id);
        }
        if($user->role == UserRole::USER) {
            $user->registeredBroker = $this->brokerRepo->checkRegisteredByUserId($user->id);
            $user->registeredEnterprise = $this->enterpriseRepo->checkRegisteredByUserId($user->id);
        }
        if($user->role == UserRole::ENTERPRISE) {
            $user->enterprise_infor = $this->enterpriseRepo->getDetailByUserId($user->id);
        }
        return $this->handleSuccessJsonResponse($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function unauth()
    {
        try {
            throw new Exception('Đăng nhập để tiếp tục!');
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $avatar = $request->get('avatar');
        $name = $request->get('name');
        try {
            $info = $this->userRepo->edit($user->id, ['avatar' => $avatar, 'name' => $name]);

            //Cập nhật thông tin nếu là nhà môi giới
            if($user->role == UserRole::BROKER) {
                $broker_infor = $request->get('broker_infor');
                $data = [
                    'address' => Arr::get($broker_infor, 'address'),
                    'description' => Arr::get($broker_infor, 'description'),
                ];
                $broker = $this->brokerRepo->updateByUserId($user->id, $data);
                $brokerageAreas = Arr::get($broker_infor, 'areas') ? Arr::get($broker_infor, 'areas') : [];
                $this->brokerageAreaRepo->deleteByBrokerId($broker->id);
                foreach ($brokerageAreas as $brokerageArea) {
                    $brokerageArea['broker_id'] = $broker->id;
                    $brokerageArea = $this->brokerageAreaRepo->create($brokerageArea);
                    if(!$brokerageArea) {
                        throw new Exception('Cập khu vực và loại môi giới không thành công');
                    }
                }
            }

            if($user->role == UserRole::ENTERPRISE) {
                $enterprise_infor = $request->get('enterprise_infor');
                $enterprise = $this->enterpriseRepo->updateByUserId($user->id, $enterprise_infor);
                $sub_fields = Arr::get($request, 'sub_field') ? Arr::get($request, 'sub_field') : [];
                $this->subFieldRepo->deleteEnterpriseId($enterprise->id);
                foreach ($sub_fields as $sub_field) {
                    $this->subFieldRepo->create(['field_id' => $sub_field, 'enterprise_id' => $enterprise->id]);
                }
            }
            return $this->handleSuccessJsonResponse($info);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    public function updatePassword(Request $request)
    {
        $password = $request->get('password');
        $new_password = $request->get('new_password');
        try {
            $id = auth()->user()->id;
            $token = Auth::attempt(['id' => $id, 'password' => $password]);
            if ($token) {
                $password = $this->userRepo->edit($id, ['password' => bcrypt($new_password)]);
                return $this->handleSuccessJsonResponse($token);
            } else {
                throw new Exception('Không nhập đúng mật khẩu');
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    public function deleteAccount(Request $request)
    {
        $password = $request->get('password');
        try {
            $id = auth()->user()->id;
            if (Auth::attempt(['id' => $id, 'password' => $password])) {
                $password = $this->userRepo->edit($id, ['status' => 0]);
                return $this->handleSuccessJsonResponse($password);
            } else {
                throw new Exception('Mật khẩu không đúng');
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    public function enterpriseRegister(Request $request)
    {
        try {
            $data = $request->except('sub_field');
            $sub_fields = $request->get('sub_field');
            $data['user_id'] = auth()->user()->id;
            $enterprise = $this->enterpriseRepo->create($data);
            if(!$enterprise) {
                throw new Exception('Thêm yêu cầu không thành công');
            }
            foreach ($sub_fields as $sub_field) {
                $subField = $this->subFieldRepo->create(['enterprise_id' => $enterprise->id, 'field_id' => $sub_field]);
                if(!$subField) {
                    throw new Exception('Thêm lĩnh vực phụ không thành công');
                }
            }
            return $this->handleSuccessJsonResponse();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    public function getDetailBrokerRegistration()
    {
        try {
            $broker = $this->brokerRepo->getDetailRegistration(auth()->user()->id);
            return $this->handleSuccessJsonResponse($broker);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    public function brokerRegister(Request $request)
    {
        try {
            $is_update = $request->get('isUpdate');
            $user_id  = auth()->user()->id;
            $data = $request->except(['brokerageAreas', 'isUpdate']);
            $brokerageAreas = $request->get('brokerageAreas');
            $data['user_id'] = $user_id;
            if($is_update) {
                $broker = $this->brokerRepo->createOrUpdate($user_id, $data);
                $this->brokerageAreaRepo->delete($broker->id);
            } else {
                $isRegister = $this->brokerRepo->checkRegisteredByUserId($user_id);
                if($isRegister) {
                    throw new Exception('Không thể đăng ký vì bạn đang có yêu cầu đăng ký chờ duyệt');
                }
                $broker = $this->brokerRepo->create($data);
                if(!$broker) {
                    throw new Exception('Thêm yêu cầu không thành công');
                }
            }
            foreach ($brokerageAreas as $brokerageArea) {
                $brokerageArea['broker_id'] = $broker->id;
                $brokerageArea = $this->brokerageAreaRepo->create($brokerageArea);
                if(!$brokerageArea) {
                    throw new Exception('Thêm khu vực và loại môi giới không thành công');
                }
            }
            return $this->handleSuccessJsonResponse();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 7200,
            'user' => auth()->user()
        ]);
    }
}
