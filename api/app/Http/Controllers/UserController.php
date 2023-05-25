<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Http\Controllers\BaseController as BaseController;
use App\Rules\OnlyGmail;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends BaseController
{
    public function register(Request $request)
    {
        $input = $request->all();

        DB::statement("ALTER TABLE users AUTO_INCREMENT = 1;");

        $validator = Validator::make($input,
            [
                "username" => "required|unique:users|min:5",
                "email" => ["required","unique:users","email", new OnlyGmail],
                "password" => "required|min:6",
                "confirm_password" => "required|same:password"
            ],
            [
                "username.required" => "The username field is required!",
                "username.unique" => "This username is already taken!",
                "username.min" => "The username should be at least 5 character long!",

                "email.required" => "The email filed is required!",
                "email.unique" => "This email address is already in use!",
                "email.email" => "Please write a valid email format(@)!",

                "password.required" => "The password field is required!",
                "password.min" => "The password should be at least 6 character long!",

                "confirm_password.required" => "You need to write your password again!",
                "confirm_password.same" => "Your passwords don't match!"
            ]
        );

        if($validator->fails())
        {
            return $this->sendError("Wrong registration data(s)");
        }

        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);
        $user->sendEmailVerificationNotification();
        $user->save();

        return $this->sendResponse($user, "Registration was successfull!");
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, 
            [
                "username_or_email" => "required",
                "password" => "required"
            ],
            [
                "username_or_email.required" => "Filling this field is required!",
                "password.required" => "Filling the password field is required!"
            ]

        );

        if($validator->fails())
        {
        return $this->sendError("Validation error");
        }

        $user = User::where("username", $input["username_or_email"])
                    ->orWhere("email", $input["username_or_email"])
                    ->first();

        if (!$user) 
        {
            return $this->sendError("User not found!");
        }

        if (!Hash::check($input["password"], $user->password)) 
        {
            return $this->sendError("Incorrect password!");
        }

        $authUser = Auth::login($user);

        $credentials = 
        [
            filter_var($input["username_or_email"], FILTER_VALIDATE_EMAIL) ? "email" : "username" => $input["username_or_email"],
            "password" => $input["password"],
        ];

        if(Auth::attempt($credentials))
        {
            $authUser = Auth::user();
            $success["token"] = $authUser->createToken("TestToken")->plainTextToken;
            $success["username"] = $authUser->username;
            $success["email"] = $authUser->email;

            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->save();

            return $this->sendResponse($success, "Login was successfull!");
        }
        else
        {
            return $this->sendError("Something went wrong with the login. Please try again!");
        }

    }

    public function logout(Request $request)
    {
        $user = auth("sanctum")->user();
        
        if ($user && $user->hasVerifiedEmail()) 
        {
            $user->currentAccessToken()->delete();
            return $this->sendResponse("Logout was successful!");
        }
        
        return $this->sendResponse("User not authenticated or email not verified.", 401);
    }


}
