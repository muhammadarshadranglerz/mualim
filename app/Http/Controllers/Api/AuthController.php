<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendContact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required',
            'organization' => 'required',
            'designation' => 'required',
            'qualification' => 'required',
            'experience' => 'required|integer',
            'cnic' => 'required',
            'phone' => 'required|unique:users',
            'password' => 'required|min:6',
            // 'confirm_password' => 'confirmed:password',
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 400,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'organization' => $request->organization,
            'designation' => $request->designation,
            'qualification' => $request->qualification,
            'experience' => $request->experience,
            'cnic' => $request->cnic,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'subject_id' => $request->subject_id,
        ]);
        if ($request->file('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads');
            $file->move($destinationPath, $fileName);
            $user->image = 'uploads/' . $fileName;
            $user->save();
        }
        
        $token = $user->createToken('Arshad')->plainTextToken;
        $user->roles()->attach(2); // Simple user role

        return response([
            'status' => 201,
            'success' => 'Successfully Registed!',
            'data' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all(),
            ], 404);
        }

        $user = User::where('phone', $request->phone)->first();
        if (isset($user) && $user->action == 0) {
            return response([
                'errors' => 'Your Account has been deactivated',
            ], 404);
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials was invalid'],
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;
        return response()->json([
            'success' => 'successfully login',
            'token' => $token,
            'user' => $user,
        ], 201);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function email(Request $request)
    {
        $user = User::find(Auth::id());
        $user->email = $request->email;
        $user->save();
        return response()->json([
            'success' => 'successfully email updated',
            'user' => $user,
        ], 201);
    }

    public function logout()
    {

        DB::table('personal_access_tokens')->where(['tokenable_id' => Auth::id()])->delete();
        return response()->json(['success' => 'logout succefully'], 200);
    }

    public function forgot_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
        ]);
        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all(),
            ], 404);
        }

        $user = User::where('email', $request->email)->first();
        $data['email'] = $user->email;
        $data['token'] = Str::random(30);
        $data['url'] = url('api/token_confirm', $data['token']);
        try {
            Mail::to($data['email'])->send(new SendContact($data));
            DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => $data['token'],
                'created_at' => Carbon::now(),
            ]);
            return response()->json(['success' => 'Success! password reset link has been sent to your email']);

        } catch (\Swift_TransportException $e) {
            if ($e->getMessage()) {
                return response()->json(['failed' => 'Failed! there is some issue with email providered.']);
            }
        }
    }

    public function tokenConfirm($token)
    {
        $token_confirm = DB::table('password_resets')
            ->where([
                'token' => $token,
            ])
            ->first();
        if ($token_confirm) {
            return view('auth.passwords.api-reset', compact('token'));
        } else {
            return response()->json(['failed' => 'Failed! reset link has been expired']);
        }

    }

    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        $token = DB::table('password_resets')
            ->where([
                'token' => $request->token,
            ])
            ->first();
        $user = User::where('email', $token->email)
            ->update(['password' => Hash::make($request->password)]);
        DB::table('password_resets')->where(['email' => $request->email])->delete();

        $user = User::where('email', $token->email)->first();
        return 'Success! password has been reset Successfully';

    }

}
