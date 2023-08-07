<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\SessionEvent;
use App\Http\Controllers\ApiController;
use App\Models\BetModel;
use App\Models\BetsTogel;
use App\Models\BonusHistoryModel;
use App\Models\ConstantRekeningModel;
use App\Models\FreeBetModel;
use App\Models\MembersModel;
use App\Models\RekeningModel;
use App\Models\RekMemberModel;
use App\Models\TurnoverModel;
use App\Models\UserLogModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator; # pagination pake ini
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Livewire\WithPagination;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthController extends ApiController
{
    use WithPagination;
    public $perPage = 20;
    public $history = [];
    public $memberID;

    public function __construct()
    {
        $this->memberID = auth('api')->user()->id ?? null;
    }

    public function authenticate(Request $request)
    {
        $wap = $request->wap ?? null;
        $input = $request->all();
        $ipPublic = $request->ip ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $ipClient = explode(', ', $ipPublic);

        $fieldType = filter_var($request->user_account, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fieldType == 'email') {
            $validator = Validator::make($request->all(), [
                'user_account' => 'required|email',
                'password' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'user_account' => 'required',
                'password' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', 422, $validator->errors()->first());
        }

        $member = MembersModel::select('id', 'status', 'password')->where('email', $input['user_account'])
            ->orWhere('username', $input['user_account'])
            ->first();
        if ($member) {

            /**
             * -----------------------------------------------------------
             * NOTE about member's status :
             * Banned = Can't login anymore.
             * Suspend = Member can still login but can not perform deposit and withdraw.
             * -----------------------------------------------------------
             * Member's status based on DB: 0=banned, 1=active, 2=suspend
             * -----------------------------------------------------------
             */

            if ($member->status == 0) { // user yang di banned tidak boleh lagi login.
                return $this->errorResponse('Akun anda telah di blokir (banned)', 403);
                // } elseif ($member->status == 2) { // suspend masih boleh login, lihat note di atas.
                //     return $this->errorResponse('Akun anda telah di tangguhkan', 401);
            } elseif (Hash::check($input['password'], $member->password)) {
                SessionEvent::dispatch($member->id);
                $credentials = [$fieldType => $input['user_account'], 'password' => $input['password']];
            } else {
                return $this->errorResponse('Password anda salah', 401);
            }

            \Config::set('auth.defaults.guard', 'api');
            try {
                $token = auth('api')->attempt($credentials);
                if (!$token) {
                    return $this->errorResponse('Password anda salah', 401);
                }
            } catch (JWTException $e) {
                return $this->errorResponse('Tidak dapat membuat token', 500);
            }
            auth('api')->user()->update([
                'remember_token' => $token,
                'active' => 1,
                'last_login_at' => now(),
                'last_login_ip' => $ipClient[0] ?? $request->ip(),
            ]);

            $wap = $wap == 1 ? ' - WAP' : null;
            $user = auth('api')->user();
            UserLogModel::logMemberActivity(
                'Member Login',
                $user,
                $user,
                [
                    'target' => $user->username,
                    'activity' => 'Logged In' . $wap,
                    'ip_member' => $ipClient[0] ?? $request->ip(),
                ],
                'Successfully'
            );

        } else {
            return $this->errorResponse('Username tidak ditemukan', 401);
        }

        auth('api')->user()->authTokens->each(function ($item) {
            try {
                auth('api')->setToken($item->token)->invalidate();
                $item->delete();
            } catch (\Exception $exception) {
                //handle exception
            }
            $item->delete();
        });

        auth('api')->user()->authTokens()->create([
            'token' => $token,
        ]);
        return $this->createNewToken($token, $user);
    }

    public function getAuthenticatedMember()
    {
        try {
            $member = MembersModel::select(['id', 'username', 'last_login_at', 'last_login_ip', 'status'])->where('id', $this->memberID)->first();
            if (!$member) {
                return $this->errorResponse('Member tidak ditemukan', 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->errorResponse('Token expired', 404);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->errorResponse('Token invalid', 400);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return $this->errorResponse('Token absent', 500);
        }

        return $this->successResponse($member);
    }

    public function getBalanceMember()
    {
        try {
            $member = MembersModel::select(['credit'])->where('id', $this->memberID)->first();
            $balance = ['balance' => (float) $member->credit];
            return $this->successResponse($balance);
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->errorResponse('Token expired', 404);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->errorResponse('Token invalid', 400);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return $this->errorResponse('Token absent', 500);
        }

    }

    public function lastBetWin()
    {
        try {
            $id = auth('api')->user()->id;

            # Last Bet
            $queryLastBet = BetModel::select('bet', 'created_at')->where('bet', '>', 0)->where('created_by', $id);
            $queryLastBetTogel = BetsTogel::select('pay_amount AS bet', 'created_at')->where('created_by', $id);
            $lastBet = $queryLastBet->union($queryLastBetTogel)->orderBy('created_at', 'desc')->first();

            # Last Win
            $queryLastWin = BetModel::select('win', 'created_at')->where('win', '>', 0)->where('created_by', $id);
            $queryLastWinTogel = BetsTogel::select('win_nominal AS win', 'created_at')->whereNotNull('win_nominal')->where('created_by', $id);
            $lastWin = $queryLastWin->union($queryLastWinTogel)->orderBy('created_at', 'desc')->first();
            $data = [
                ['lastBet' => [$lastBet ?? ['bet' => 0, 'created_at' => auth('api')->user()->created_at]]],
                ['lastWin' => [$lastWin ?? ['win' => 0, 'created_at' => auth('api')->user()->created_at]]],
            ];
            return $this->successResponse($data);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');

        try {
            $user = auth('api')->user();
            $ip = auth('api')->user()->last_login_ip;

            JWTAuth::parseToken()->invalidate($token);

            UserLogModel::logMemberActivity(
                'Member Log Out',
                $user,
                $user,
                [
                    'target' => $user->username,
                    'activity' => 'Logged Out',
                    'ip_member' => $ip,
                ],
                'Successfully'
            );
            auth('api')->user()->update([
                'remember_token' => null,
                'active' => 0,
                // 'last_login_ip' => $request->ip,
            ]);

            return $this->successResponse(null, 'Member berhasil logout.', 200);
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->errorResponse('Token expired', 404);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->errorResponse('Token invalid', 400);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return $this->errorResponse('Token absent', 500);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth('api')->refresh(), auth('api')->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token, $userData = [])
    {
        return $this->successResponse([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL(),
            'user' => $userData,
            // 'member' => auth('api')->user(),
        ]);
    }

    //register member
    public function register(Request $request)
    {

        $date = Carbon::now();

        if ($request->has('ref')) {
            session(['referrer' => $request->query('ref')]);
        }

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'username' => 'required|unique:members|string|between:6,16|regex:/^[a-zA-Z0-9\s\-\+\(\)]+$/u|alpha_dash',
                    'email' => 'required|email|max:100|unique:members',
                    'password' => 'required|min:6|regex:/^\S*$/u',
                    'bank_name' => 'required',
                    'account_number' => 'required|numeric',
                    'account_name' => 'required',
                    // 'provider' => 'required',
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:7|unique:members',
                ],
                [
                    'password.regex' => 'Password tidak boleh menggunakan spasi.',
                    'phone.unique' => 'Nomor telepon sudah ada sebelumnya.',
                ]
            );

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 400);
            }

            $referal = MembersModel::where('username', $request->referral)->first();
            $rekeningDepoMember = RekeningModel::where('constant_rekening_id', '=', $request->bank_name)->where('is_depo', '=', 1)->first();
            $constantRekening = ConstantRekeningModel::where('id', $request->bank_name)->first();

            // also prevent error in here:
            // Don't let user continue register successfully when there is no Agent's bank set as Deposit.
            if (is_null($rekeningDepoMember) || empty($rekeningDepoMember)) {
                return $this->errorResponse('Silakan minta CS kami untuk siapkan bank ' . $constantRekening->name . ' untuk deposit. Terima kasih.', 400);
            }

            // check no rekening
            $noRekArray = RekeningModel::pluck('nomor_rekening')->toArray();
            $noMemberArray = RekMemberModel::pluck('nomor_rekening')->toArray();
            $noRekArrays = array_merge($noRekArray, $noMemberArray);
            if (in_array($request->account_number, $noRekArrays)) {
                return $this->errorResponse('Nomor rekening sudah ada sebelumnya.', 400);
            }

            # Check Referral
            if (is_null($referal)) {

                # Create Member
                $user = MembersModel::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone' => $request->phone,
                    'bonus_referal' => 0,
                ]);

                # Create Rekening Member
                $rekMember = RekMemberModel::create([
                    'username_member' => $request->username,
                    'rekening_id' => $rekeningDepoMember->id,
                    'constant_rekening_id' => $request->bank_name,
                    'nomor_rekening' => $request->account_number,
                    'nama_rekening' => $request->account_name,
                    'is_depo' => 1,
                    'is_default' => 1,
                    'is_wd' => 1,
                    'created_by' => $user->id,
                ]);

                # Update Rekening Withdraw
                MembersModel::where('username', $request->username)
                    ->update([
                        'rek_member_id' => $rekMember->id,
                    ]);

                # This is not used
                TurnoverModel::create([
                    'created_by' => $user->id,
                ]);
            } else {

                # Create Member
                $user = MembersModel::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'referrer_id' => $referal->id,
                    'phone' => $request->phone,
                    'bonus_referal' => 0,
                    'rekening_tujuan_depo_id' => null,
                ]);

                # Create Rekening Member
                $rekMember = RekMemberModel::create([
                    'username_member' => $request->username,
                    'rekening_id' => $rekeningDepoMember->id,
                    'constant_rekening_id' => $request->bank_name,
                    'nomor_rekening' => $request->account_number,
                    'nama_rekening' => $request->account_name,
                    'is_depo' => 1,
                    'is_default' => 1,
                    'is_wd' => 1,
                    'created_by' => $user->id,
                ]);

                # Update Rekening Withdraw
                MembersModel::where('username', $request->username)
                    ->update([
                        'rek_member_id' => $rekMember->id,
                    ]);

                # This is not used
                TurnoverModel::create([
                    'created_by' => $user->id,
                ]);
            }

            # This is not used
            $freeBet = FreeBetModel::get();
            foreach ($freeBet as $value) {
                BonusHistoryModel::create([
                    'free_bet_id' => $value->id,
                    'constant_bonus_id' => 4,
                    'type' => 'uang',
                    'is_use' => 0,
                    'created_by' => $user->id,
                    'created_at' => Carbon::now(),
                ]);
            }

            $ipPublic = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER["HTTP_CF_CONNECTING_IP"] ?? $_SERVER['HTTP_X_FORWARDED'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['HTTP_FORWARDED'] ?? $_SERVER['HTTP_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? ' - ';
            $ipClient = explode(', ', $ipPublic);

            # Update  IP Member
            $user->update([
                // 'last_login_ip' => $request->ip ?? request()->getClientIp(),
                'last_login_ip' => $ipClient[0] ?? $request->ip(),
            ]);

            # Create Activity Log
            UserLogModel::logMemberActivity(
                'Member Registration',
                $user,
                $user,
                [
                    'target' => $user->username,
                    'activity' => 'Registered',
                    // 'ip' => $request->ip ?? request()->getClientIp(),
                    'ip_member' => $ipClient[0] ?? $request->ip(),
                ],
                'Successfully'
            );

            return $this->successResponse(null, 'Member berhasil didaftar.', 201);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'old_password' => 'required',
                    'new_password' => 'required|min:6|regex:/^\S*$/u',
                    // 'new_password' => [
                    //     'required',
                    //     'string',
                    //     new IsValidPassword(),
                    // ],
                    'confirm_password' => ['same:new_password'],
                ],
                [
                    'old_password.required' => 'Password lama tidak boleh kosong.',
                    'new_password.required' => 'Password baru tidak boleh kosong.',
                    'new_password.min' => 'Minimal password harus  6 karakter.',
                    'new_password.regex' => 'Password baru tidak boleh menggunakan spasi.',
                    'confirm_password.same' => 'Konfirmasi password dan password baru harus sama.',
                ]
            );

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', 422, $validator->errors()->first());
            }

            if (Hash::check($request->old_password, auth('api')->user()->password)) {
                MembersModel::find(auth('api')->user()->id)->update(['password' => bcrypt($request->new_password)]);

                $user = auth('api')->user();
                UserLogModel::logMemberActivity(
                    'Password Change',
                    $user,
                    $user,
                    [
                        'target' => $user->username,
                        'activity' => 'Password Change',
                        'ip_member' => auth('api')->user()->last_login_ip,
                    ],
                    'Berhasil Ganti Password.'
                );
                // auth('api')->user()->update([
                //     'last_login_ip' => $request->ip,
                // ]);

                return $this->successResponse(null, 'Berhasil Ganti Password.', 201);
            } else {
                return $this->errorResponse('Password lama yang anda masukan salah', 400);
            }
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    // pagination
    public function paginate($items, $perPage, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    // function  probation
    public function probationLogin(Request $request)
    {
        $input = $request->all();

        $fieldType = filter_var($request->user_account, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fieldType == 'email') {
            $validator = Validator::make($request->all(), [
                'user_account' => 'required|email',
                'password' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'user_account' => 'required',
                'password' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', 422, $validator->errors()->first());
        }

        $member = MembersModel::where('email', $input['user_account'])
            ->orWhere('username', $input['user_account'])
            ->first();

        if ($member) {
            if ($member->status == 0) {
                return $this->errorResponse('Member has been banned', 401);
            } elseif ($member->status == 2) {
                return $this->errorResponse('Member has been suspend', 401);
            } elseif ($member->status == 1) {
                $credentials = [$fieldType => $input['user_account'], 'password' => $input['password']];
            }

            \Config::set('auth.defaults.guard', 'api');

            try {
                $token = auth('api')->attempt($credentials);
                if (!$token) {
                    return $this->errorResponse('Password is wrong', 401);
                }
            } catch (JWTException $e) {
                return $this->errorResponse('Could not create token', 500);
            }

        } else {
            return $this->errorResponse('Username not found', 401);
        }

        auth('api')->user()->authTokens->each(function ($item) {
            try {
                auth('api')->setToken($item->token)->invalidate();
            } catch (\Exception $exception) {
                //handle exception
            }
            $item->delete();
        });

        auth('api')->user()->authTokens()->create([
            'token' => $token,
        ]);
        return $this->createNewToken($token, auth('api')->user());
    }

    public function probationRegister(Request $request)
    {

        $date = Carbon::now();

        if ($request->has('ref')) {
            session(['referrer' => $request->query('ref')]);
        }

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'username' => 'required|unique:members|string|between:6,16|regex:/^[a-zA-Z0-9\s\-\+\(\)]+$/u|alpha_dash',
                    'email' => 'required|email|max:100|unique:members',
                    'password' => 'required|min:6|regex:/^\S*$/u',
                    'bank_name' => 'required',
                    'account_number' => 'required',
                    'account_name' => 'required',
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:7',
                ],
                [
                    'password.required' => 'Password tidak boleh kosong.',
                    'password.min' => 'Password harus minimal 6 karakter.',
                    'password.regex' => 'Password tidak boleh menggunakan spasi.',
                ]
            );

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 400);
            }

            $referal = MembersModel::where('username', $request->referral)->first();
            $rekeningDepoMember = RekeningModel::where('constant_rekening_id', '=', $request->bank_name)->where('is_depo', '=', 1)->first();

            // check no rekening
            $noRekArray = RekeningModel::pluck('nomor_rekening')->toArray();
            $noMemberArray = RekMemberModel::pluck('nomor_rekening')->toArray();
            $noRekArrays = array_merge($noRekArray, $noMemberArray);
            if (in_array($request->account_number, $noRekArrays)) {
                return $this->errorResponse('Nomor rekening yang anda masukkan telah digunakan', 400);
            }
            if (is_null($referal)) {
                $user = MembersModel::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone' => $request->phone,
                    'bonus_referal' => 0,
                ]);
                $rekMember = RekMemberModel::create([
                    'username_member' => $request->username,
                    'rekening_id' => $rekeningDepoMember->id,
                    'constant_rekening_id' => $request->bank_name,
                    'nomor_rekening' => $request->account_number,
                    'nama_rekening' => $request->account_name,
                    'is_depo' => 1,
                    'is_default' => 1,
                    'is_wd' => 1,
                    'created_by' => $user->id,
                ]);
                MembersModel::where('username', $request->username)
                    ->update([
                        'rek_member_id' => $rekMember->id,
                    ]);
                TurnoverModel::create([
                    'created_by' => $user->id,
                ]);
            } else {
                $user = MembersModel::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'referrer_id' => $referal->id,
                    'phone' => $request->phone,
                    'bonus_referal' => 0,
                    'rekening_tujuan_depo_id' => null,
                ]);
                $rekMember = RekMemberModel::create([
                    'username_member' => $request->username,
                    'rekening_id' => $rekeningDepoMember->id,
                    'constant_rekening_id' => $request->bank_name,
                    'nomor_rekening' => $request->account_number,
                    'nama_rekening' => $request->account_name,
                    'is_depo' => 1,
                    'is_default' => 1,
                    'is_wd' => 1,
                    'created_by' => $user->id,
                ]);
                MembersModel::where('username', $request->username)
                    ->update([
                        'rek_member_id' => $rekMember->id,
                    ]);
                TurnoverModel::create([
                    'created_by' => $user->id,
                ]);
            }

            return $this->successResponse(null, 'Member successfully registered.', 201);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function probationUpdateAccount(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required|integer',
                    // 'username' => 'required|unique:members|string|between:6,16|regex:/^[a-zA-Z0-9\s\-\+\(\)]+$/u|alpha_dash',
                    'email' => 'required|email|max:100',
                    'password' => 'min:6|regex:/^\S*$/u',
                    'bank_name' => 'required|integer',
                    // 'account_number' => 'required',
                    // 'account_name' => 'required',
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:7',
                ]
            );

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 400);
            }
            $checkEmailUser = MembersModel::where('email', $request->email)->whereNotIn('id', [$request->id])->first();
            if ($checkEmailUser) {
                return $this->errorResponse('The email has already been taken', 400);
            }
            $checkUser = MembersModel::find($request->id);
            if ($checkUser == null) {
                return $this->errorResponse('User does not exist', 400);
            }

            // $referal = MembersModel::where('username', $request->referral)->first();
            $rekeningDepoMember = RekeningModel::where('constant_rekening_id', '=', $request->bank_name)->where('is_wd', '=', 1)->first();
            if ($rekeningDepoMember == null) {
                return $this->errorResponse('Bank not found', 400);
            }
            $checkUser->update([
                // 'username' => $request->username,
                'email' => $request->email,
                // 'password' => bcrypt($request->password),
                // 'referrer_id' => $referal == null ? "" : $referal->id,
                'phone' => $request->phone,
            ]);
            $rekMember = RekMemberModel::where('created_by', $request->id)->update([
                'rekening_id' => $rekeningDepoMember->id,
                'constant_rekening_id' => $request->bank_name,
                // 'nomor_rekening' => $request->account_number,
                // 'nama_rekening' => $request->account_name,
            ]);
            return $this->successResponse(null, 'Member successfully updated', 201);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function probationDeleteAccount(Request $request)
    {
        try {
            $checkUser = MembersModel::find($request->id);
            if (is_null($checkUser)) {
                return $this->errorResponse('User does not exist', 400);
            }
            $user = $checkUser->id;
            $member = MembersModel::find($user);
            if ($member) {
                $rekMember = RekMemberModel::find($member->rek_member_id);
                $member->delete();
                $rekMember->delete();
                return $this->successResponse(null, 'account deleted successfully', 200);
            }
            return $this->errorResponse('account not found!', 400);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function probationAccountList()
    {
        try {
            $members = DB::select('SELECT
                    members.id,
                    members.username,
                    members.phone,
                    members.email,
                    b.name as name_bank,
                    a.nama_rekening,
                    a.nomor_rekening
                FROM
                    members
                    left join rek_member as a on a.id = members.rek_member_id
                    left join constant_rekening as b on b.id = a.constant_rekening_id
                WHERE
                    members.id >= 50
                    and members.deleted_at is null');
            $data = $this->paginate($members, 10);
            if ($members) {
                return $this->successResponse($data, 'account list successfully displayed', 200);
            }
            return $this->successResponse('account list does not exist', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }
}
