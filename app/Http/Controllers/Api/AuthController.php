<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
            'subject_id' => 'required',
            'email' => 'required|email|unique:users',
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
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'subject_id' => $request->subject_id,
        ]);

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
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 400,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::guard('web')->user();
            $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => [
                        'Invalid credentials',
                    ],
                ],
            ], 422);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        return response()->json([
            'success' => 'logout Successfully',

        ]);
    }

    
    //forgot password
    public function forgot_password(Request $request)
    {
        // return $request;
       //send mail to the user for forgot password
       $user = User::where('email', $request->email)->first();
       if (!$user) {
           return response()->json(['failed'=>'Failed! email is not registered.']);
       }
       $token = Str::random(60);
       $user->token = $token;
       $user->save();

       Mail::to($request->email)->send(new ForgotPassword($user->name, $token));
       if(Mail::failures() != 0) {
           return response()->json(['success'=>'Success! password reset link has been sent to your email']);
       }
       return response()->json(['failed'=>'Failed! there is some issue with email providered.']);
    }



    // After Register Users Send mail to the user for create thier Password
    public function forgotPasswordValidate($token)
    {
        $user = User::where('token', $token)->first();
        if ($user) {
            $email = $user->email;
            return view('admin.PasswordReset.change-password', compact('email'));
        }
        return redirect()->route('forgot_password')->with('failed', 'Password reset link is expired');
    }

    public function updatePassword(Request $request) {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {

            $user->password = Hash::make($request->password);
            $user->save();
            return view('admin.PasswordReset.popup');
        }
        return 'Failed! something went wrong';
    }



}
