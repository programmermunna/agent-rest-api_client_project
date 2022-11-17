<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Models\BetModel;
use App\Models\BetsTogel;
use App\Models\BonusHistoryModel;
use App\Models\DepositModel;
use App\Models\FreeBetModel;
use App\Models\MembersModel;
use App\Models\MemberToken;
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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Livewire\WithPagination;
use Tymon\JWTAuth\Exceptions\JWTException;

# pagination pake ini

# pagination pake ini

class JWTAuthController extends ApiController
{
    use WithPagination;
    public $perPage = 20;
    public $history = [];
    public function authenticate(Request $request)
    {

        $input = $request->all();
        $ipPublic = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER["HTTP_CF_CONNECTING_IP"] ?? $_SERVER['HTTP_X_FORWARDED'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['HTTP_FORWARDED'] ?? $_SERVER['HTTP_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? ' - ';
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

        $member = MembersModel::where('email', $input['user_account'])
            ->orWhere('username', $input['user_account'])
            ->first();
        if ($member) {
            # check maintenance
            $maintenanceUrl = config('cikatechMaster.url_check_maintenance_agent');
            $headers = [
                'secret' => config('cikatechMaster.secret_url'),
            ];
            $requestCikatechMaster = [
                'agent_name' => config('cikatechMaster.agent_name'),
                'ip' => config('cikatechMaster.agent_ip'),
            ];
            $res = Http::asForm()
                ->withHeaders($headers)
                ->post($maintenanceUrl, $requestCikatechMaster)->json();

            if ($res['data']['status'] == 1) {
                if (!in_array($member->id, [2, 3, 21])) {
                    return $this->errorResponse('Maaf, kita sedang Maintenance!.', 503);
                }
            }
            if ($member->status == 0) {
                return $this->errorResponse('Akun anda telah di blokir', 401);
            } elseif ($member->status == 2) {
                return $this->errorResponse('Akun anda telah di tangguhkan', 401);
            } elseif ($member->status == 1) {
                $credentials = [$fieldType => $input['user_account'], 'password' => $input['password']];
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

            auth('api')->user();

            $user = auth('api')->user();
            UserLogModel::logMemberActivity(
                'Member Login',
                $user,
                $user,
                [
                    'target' => $user->username,
                    'activity' => 'Logged In',
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
            } catch (\Exception$exception) {
                //handle exception
            }
            $item->delete();
        });

        auth('api')->user()->authTokens()->create([
            'token' => $token,
        ]);
        return $this->createNewToken($token);
    }

    public function getAuthenticatedMember()
    {
        try {
            $member = MembersModel::select(['id', 'username', 'credit', 'last_login_at', 'last_login_ip'])->where('id', auth('api')->user()->id)->first();
            if (!$member) {
                return $this->errorResponse('Member tidak ditemukan', 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException$e) {
            return $this->errorResponse('Token expired', 404);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException$e) {
            return $this->errorResponse('Token invalid', 400);
        } catch (Tymon\JWTAuth\Exceptions\JWTException$e) {
            return $this->errorResponse('Token absent', 500);
        }

        return $this->successResponse($member);
    }

    public function getBalanceMember()
    {
        try {
            $balance = ['balance' => (float) auth('api')->user()->credit];
            return $this->successResponse($balance);
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }

    }

    public function lastBetWin()
    {
        try {
            $bet = BetModel::query();
            $betTogel = BetsTogel::query();
            return $this->successResponse($balance);
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function lastBet()
    {
        try {

            $id = auth('api')->user()->id;
            $lastBet = DB::select("
                            SELECT
                                bets.bet,
                                bets.created_at,
                                members.username
                            FROM
                                bets
                            INNER JOIN members ON members.id = bets.created_by
                            WHERE
                                (
                                    bets.created_by = $id
                                ) AND bets.deleted_at IS NULL

                            UNION ALL

                            SELECT
                                bets_togel.bet_amount AS bet,
                                bets_togel.created_at,
                                members.username
                            FROM
                                bets_togel
                            INNER JOIN members ON members.id = bets_togel.created_by
                            WHERE
                                bets_togel.created_by = $id AND bets_togel.deleted_at IS NULL
                            ORDER BY created_at DESC
                            LIMIT 1
                        ");
            // $lastBet = BetModel::join('members', 'members.id', '=', 'bets.created_by')
            // ->select([
            //     'bets.bet',
            //     'bets.created_at',
            //     'bets.created_by',
            // ])->where('bets.type', 'Lose')
            // ->where('bets.created_by', auth('api')->user()->id)
            // ->latest()
            // ->limit(1)->first();

            // $getMember = MembersModel::where('id', auth('api')->user()->id)->select('is_cash')->first();
            // $dt = Carbon::now();

            // if ($dt->dayOfWeek == Carbon::MONDAY && $getMember->is_cash === 0) {
            //     $date = Carbon::now()->subDays(7);
            //     $date->format('Y-m-d');
            //     $enableCashback = ImageContent::where('type', 'cashback')->where('enabled', 1)->select('enabled')->first();
            //     $cbMember = BetModel::join('members', 'members.id', '=', 'bets.created_by')
            //     ->select(
            //         'members.id AS member_id',
            //         DB::raw("(sum(bets.win)) - (sum(bets.bet)) as Balance"),
            //     )
            //         ->where('bets.created_at', '>=', $date)
            //         ->where('bets.created_by', auth('api')->user()->id)
            //         ->groupBy('bets.created_by')->first();
            //     if (is_null($cbMember) && is_null($enableCashback)) {
            //         return $this->successResponse(null, 'Belum Pernah Melakukan Betting', 200);
            //     } elseif ($cbMember->Balance < 0) {
            //         if ($cbMember->Balance > (-50000)) {
            //             'no cashback';
            //         } elseif ($cbMember->Balance <= -50000 && $cbMember->Balance >= -10000000) {
            //             #tambah cashback to credit member
            //             $member = MembersModel::find($cbMember->member_id);
            //             $data1 = $cbMember->Balance - $cbMember->Balance - $cbMember->Balance;
            //             $cashback5 = $data1 * 5 / 100;
            //             $member->update([
            //                 'credit' => $cashback5,
            //                 'is_cash' => 1,
            //             ]);

            //             #create memo after get cashback
            //             $createMemo = MemoModel::create([
            //                 'member_id' => $cbMember->member_id,
            //                 'sender_id' => 1,
            //                 'subject' => 'CASHBACK 5%',
            //                 'is_reply' => 1,
            //                 'is_bonus' => 1,
            //                 'content' => 'Selamat Anda Mendapatkan CASHBACK 5% = '. $cashback5,
            //                 'created_at' => Carbon::now(),
            //             ]);
            //         } elseif ($cbMember->Balance <= -10001000 && $cbMember->Balance >= -100000000) {
            //             #tambah cashback to credit member
            //             $member = MembersModel::find($cbMember->member_id);
            //             $data1 = $cbMember->Balance - $cbMember->Balance - $cbMember->Balance;
            //             $cashback7 = $data1 * 7 / 100;
            //             $member->update([
            //                 'credit' => $cashback7,
            //                 'is_cash' => 1,
            //             ]);

            //             #create memo after get cashback
            //             $createMemo = MemoModel::create([
            //                 'member_id' => $cbMember->member_id,
            //                 'sender_id' => 1,
            //                 'subject' => 'CASHBACK 7%',
            //                 'is_reply' => 1,
            //                 'is_bonus' => 1,
            //                 'content' => 'Selamat Anda Mendapatkan CASHBACK 7% = '.$cashback7,
            //                 'created_at' => Carbon::now(),
            //             ]);
            //         } elseif ($cbMember->Balance <= -100001000 && $cbMember->Balance >= -100000000000) {
            //             #tambah cashback to credit member
            //             $member = MembersModel::find($cbMember->member_id);
            //             $data1 = $cbMember->Balance - $cbMember->Balance - $cbMember->Balance;
            //             $cashback10 = $data1 * 10 / 100;
            //             $member->update([
            //                 'credit' => $cashback10,
            //                 'is_cash' => 1,
            //             ]);

            //             #create memo after get cashback
            //             $createMemo = MemoModel::create([
            //                 'member_id' => $cbMember->member_id,
            //                 'sender_id' => 1,
            //                 'subject' => 'CASHBACK 10%',
            //                 'is_reply' => 1,
            //                 'is_bonus' => 1,
            //                 'content' => 'Selamat Anda Mendapatkan CASHBACK 10% = '.$cashback10,
            //                 'created_at' => Carbon::now(),
            //             ]);
            //         }
            //     }
            // }

            // #update is_cash to be 0
            // if ($dt->dayOfWeek == Carbon::SUNDAY) {
            //     $member = MembersModel::where('id', auth('api')->user()->id);
            //     $member->update([
            //         'is_cash' => 0,
            //     ]);
            // }

            return $this->successResponse($lastBet);
        } catch (\Throwable$th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function lastWin()
    {
        try {
            $cekKondisi = DepositModel::where('approval_status', 1)
                ->where('created_by', auth('api')->user()->id)
                ->orderBy('approval_status_at', 'asc')->count();
            // dd($cekKondisi);
            if (is_null($cekKondisi)) {
                'Tidak ada data';
            } elseif ($cekKondisi >= 0 && $cekKondisi <= 2) {
                $member = MembersModel::where('id', auth('api')->user()->id)->first();
                $member->update(['is_next_deposit' => 1]);
            } elseif ($cekKondisi > 2 && $cekKondisi <= 3) {
                $member = MembersModel::where('id', auth('api')->user()->id)->first();
                $member->update(['is_next_deposit' => 0]);
            }
            // $lastWin = BetModel::join('members', 'members.id', '=', 'bets.created_by')
            // ->select([
            //     'bets.win',
            //     'bets.created_at',
            //     'bets.created_by',

            // ])->where('bets.type', 'Win')
            // ->where('bets.created_by', auth('api')->user()->id)
            // ->latest()
            // ->limit(1)->get();
            $id = auth('api')->user()->id;
            $lastWin = DB::select("
                            SELECT
                                bets.win,
                                bets.created_at,
                                members.username
                            FROM
                                bets
                            INNER JOIN members ON members.id = bets.created_by
                            WHERE
                                (
                                    bets.created_by = $id
                                ) AND bets.deleted_at IS NULL

                            UNION ALL

                            SELECT
                                bets_togel.win_nominal AS win,
                                bets_togel.created_at,
                                members.username
                            FROM
                                bets_togel
                            INNER JOIN members ON members.id = bets_togel.created_by
                            WHERE
                                bets_togel.win_lose_status = 1 AND bets_togel.created_by = $id AND bets_togel.deleted_at IS NULL
                            ORDER BY created_at DESC
                            LIMIT 1
                        ");
            return $this->successResponse($lastWin);
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function history()
    {
        try {
            $date = Carbon::now()->subDays(7);
            $history = BetModel::join('members', 'members.id', '=', 'bets.created_by')
                ->join('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
                ->select([
                    'bets.id as betsId',
                    'bets.constant_provider_id',
                    'bets.bet_id',
                    'bets.game_id',
                    'bets.credit',
                    'bets.deskripsi',
                    'bets.created_by',
                    'bets.bet',
                    'bets.win',
                    'bets.created_at',
                    'bets.player_wl',
                    'members.id as memberId',
                    'members.username',
                    'constant_provider.constant_provider_name',
                ])
                ->orderBy('bets.created_at', 'desc')
                ->where('bets.created_by', auth('api')->user()->id)
                ->where('bets.created_at', '>=', $date);
            $this->history = $history->get()->toArray();
            $arrHistory = $this->paginate($this->history, $this->perPage);
            if ($arrHistory != null) {
                return $this->successResponse($arrHistory);
            } else {
                return $this->successResponse('Tidak ada histori', 204);
            }
        } catch (\Throwable$th) {
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
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException$e) {
            return $this->errorResponse('Token expired', 404);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException$e) {
            return $this->errorResponse('Token invalid', 400);
        } catch (Tymon\JWTAuth\Exceptions\JWTException$e) {
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
        return $this->createNewToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return $this->successResponse([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL(),
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
                    'account_number' => 'required',
                    'account_name' => 'required',
                    // 'provider' => 'required',
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
            // $referrer = MembersModel::whereUsername(session()->pull('referrer'))->first();

            $referal = MembersModel::where('username', $request->referral)->first();
            $rekeningDepoMember = RekeningModel::where('constant_rekening_id', '=', $request->bank_name)->where('is_depo', '=', 1)->first();
            //bank agent
            // $bankAgent = [];
            // for ($i=1; $i <= 14 ; $i++) {
            //     array_push($bankAgent, RekeningModel::where('constant_rekening_id', $i)->where('is_depo', 1)->inRandomOrder()->take(1)->first());
            // }
            // dd($bankAgent[0]);

            // check no rekening
            $noRekArray = RekeningModel::pluck('nomor_rekening')->toArray();
            $noMemberArray = RekMemberModel::pluck('nomor_rekening')->toArray();
            $noRekArrays = array_merge($noRekArray, $noMemberArray);
            if (in_array($request->account_number, $noRekArrays)) {
                return $this->errorResponse('Nomor rekening yang anda masukkan telah digunakan', 400);
            }
            if (is_null($referal)) {
                // $dataRekening = RekeningTujuanDepo::create([
                //     'rekening_id_tujuan_depo1' => $bankAgent[0] == [] ? Null : $bankAgent[0]['id'],
                //     'rekening_id_tujuan_depo2' => $bankAgent[1] == [] ? Null : $bankAgent[1]['id'],
                //     'rekening_id_tujuan_depo3' => $bankAgent[2] == [] ? Null : $bankAgent[2]['id'],
                //     'rekening_id_tujuan_depo4' => $bankAgent[3] == [] ? Null : $bankAgent[3]['id'],
                //     'rekening_id_tujuan_depo5' => $bankAgent[4] == [] ? Null : $bankAgent[4]['id'],
                //     'rekening_id_tujuan_depo6' => $bankAgent[5] == [] ? Null : $bankAgent[5]['id'],
                //     'rekening_id_tujuan_depo7' => $bankAgent[6] == [] ? Null : $bankAgent[6]['id'],
                //     'rekening_id_tujuan_depo8' => $bankAgent[7] == [] ? Null : $bankAgent[7]['id'],
                //     'rekening_id_tujuan_depo9' => $bankAgent[8] == [] ? Null : $bankAgent[8]['id'],
                //     'rekening_id_tujuan_depo10' => $bankAgent[9] == [] ? Null : $bankAgent[9]['id'],
                //     'rekening_id_tujuan_depo11' => $bankAgent[10] == [] ? Null : $bankAgent[10]['id'],
                //     'rekening_id_tujuan_depo12' => $bankAgent[11] == [] ? Null : $bankAgent[11]['id'],
                //     'rekening_id_tujuan_depo13' => $bankAgent[12] == [] ? Null : $bankAgent[12]['id'],
                //     'rekening_id_tujuan_depo14' => $bankAgent[13] == [] ? Null : $bankAgent[13]['id'],
                // ]);

                $user = MembersModel::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    // 'referrer_id' => $referal->id,
                    // 'constant_rekening_id' => $request->bank_name,
                    // 'nomor_rekening' => $request->account_number,
                    // 'nama_rekening' => $request->account_name,
                    'phone' => $request->phone,
                    // 'info_dari' => $request->provider,
                    // 'referrer_id' => $referrer ? $referrer->id : '',
                    // 'referrer_id' => $request->referral,
                    'bonus_referal' => 0,
                    // 'rekening_tujuan_depo_id' => $dataRekening->id,
                ]);
                // $updateRek = RekeningTujuanDepo::where('id', $user->rekening_tujuan_depo_id)->first();
                // $updateRek->update([
                //     'created_by' => $user->id
                // ]);
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
                // $dataRekening = RekeningTujuanDepo::create([
                //     'rekening_id_tujuan_depo1' => $bankAgent[0] == [] ? Null : $bankAgent[0]['id'],
                //     'rekening_id_tujuan_depo2' => $bankAgent[1] == [] ? Null : $bankAgent[1]['id'],
                //     'rekening_id_tujuan_depo3' => $bankAgent[2] == [] ? Null : $bankAgent[2]['id'],
                //     'rekening_id_tujuan_depo4' => $bankAgent[3] == [] ? Null : $bankAgent[3]['id'],
                //     'rekening_id_tujuan_depo5' => $bankAgent[4] == [] ? Null : $bankAgent[4]['id'],
                //     'rekening_id_tujuan_depo6' => $bankAgent[5] == [] ? Null : $bankAgent[5]['id'],
                //     'rekening_id_tujuan_depo7' => $bankAgent[6] == [] ? Null : $bankAgent[6]['id'],
                //     'rekening_id_tujuan_depo8' => $bankAgent[7] == [] ? Null : $bankAgent[7]['id'],
                //     'rekening_id_tujuan_depo9' => $bankAgent[8] == [] ? Null : $bankAgent[8]['id'],
                //     'rekening_id_tujuan_depo10' => $bankAgent[9] == [] ? Null : $bankAgent[9]['id'],
                //     'rekening_id_tujuan_depo11' => $bankAgent[10] == [] ? Null : $bankAgent[10]['id'],
                //     'rekening_id_tujuan_depo12' => $bankAgent[11] == [] ? Null : $bankAgent[11]['id'],
                //     'rekening_id_tujuan_depo13' => $bankAgent[12] == [] ? Null : $bankAgent[12]['id'],
                //     'rekening_id_tujuan_depo14' => $bankAgent[13] == [] ? Null : $bankAgent[13]['id'],
                // ]);

                $user = MembersModel::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'referrer_id' => $referal->id,
                    // 'constant_rekening_id' => $request->bank_name,
                    // 'nomor_rekening' => $request->account_number,
                    // 'nama_rekening' => $request->account_name,
                    'phone' => $request->phone,
                    // 'info_dari' => $request->provider,
                    // 'referrer_id' => $referrer ? $referrer->id : '',
                    // 'referrer_id' => $request->referral,
                    'bonus_referal' => 0,
                    // 'rekening_tujuan_depo_id' => $dataRekening->id,
                    'rekening_tujuan_depo_id' => null,
                ]);
                // $updateRek = RekeningTujuanDepo::where('id', $user->rekening_tujuan_depo_id)->first();
                // $updateRek->update([
                //     'created_by' => $user->id
                // ]);
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

            $user->update([
                // 'last_login_ip' => $request->ip ?? request()->getClientIp(),
                'last_login_ip' => $ipClient[0] ?? $request->ip(),
            ]);

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

        } catch (\Throwable$th) {
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
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    # Force Logout All Member if in cikateck master Maintenance
    public function forceLogout(Request $request)
    {
        try {
            MembersModel::query()->update([
                'remember_token' => null,
                'active' => 0,
            ]);
            MemberToken::truncate();
            $projectDir = base_path();

            //$commandResult = exec("cd $projectDir && php artisan jwt:secret -f");
            //$commandResult = exec("bash ~/logallmemberout.sh");//
            $commandResult = exec("cd $projectDir && php artisan jwt:secret -f"); //
            Log::info($commandResult);
            //Artisan::call('jwt:secret -f');
            //Artisan::call('optimize');
            return $this->successResponse('Success force logout all members');

        } catch (\Throwable$th) {
            Log::error($th);
            return $this->errorResponse('Internal Error Server!.', 500);
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
            } catch (\Exception$exception) {
                //handle exception
            }
            $item->delete();
        });

        auth('api')->user()->authTokens()->create([
            'token' => $token,
        ]);
        return $this->createNewToken($token);
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

        } catch (\Throwable$th) {
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

        } catch (\Throwable$th) {
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
        } catch (\Throwable$th) {
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
        } catch (\Throwable$th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }
}
