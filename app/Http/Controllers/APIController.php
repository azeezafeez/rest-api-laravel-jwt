<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegistrationFormRequest;
use App\Http\Requests\LoginFormRequest;

class APIController extends Controller
{
    
	public $loginAfterSignUp = true;


	###################LOGIN##############################
	public function login(LoginFormRequest $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

	######################################################


    #########################REGISTER#############################
    public function register(RegistrationFormRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $reg= $user->save();

        

        return response()->json([
            'success'   =>  true,
            'data'      =>  "Registration successful"
        ], 200);
    }
    ##############################################################

    ###########################LOGOUT###################################
    public function logout(Request $request)
    {
        

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }
    ####################################################################


    public function shout(){
    	return "OH MY GOD!";
    }
}
