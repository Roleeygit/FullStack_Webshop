<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Http\Controllers\BaseController as BaseController;
use App\Rules\OnlyGmail;
use App\Models\User;

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
            return $this->sendError("Wrong registration datas", $validator->errors());
        }

        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);
        $user->save();

        return $this->sendResponse($user, "Registration was successfull!");
    }
}
