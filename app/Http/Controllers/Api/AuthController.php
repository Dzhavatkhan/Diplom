<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Rules\ReCaptcha;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getCaptcha()
    {
        try {
            $error = 0;
            $sitekey = env('GOOGLE_RECAPTCHA_KEY');
            return response()->json([
                "sitekey" => $sitekey,
                "error" => $error
            ]);
        } catch (\ErrorException $errors) {
            return response()->json([
                "sitekey" => $sitekey,
                "error" => $errors
            ]);
        }
    }
     public function registration (RegistrationRequest $request) {
        try {
            $avatar = $request->image;
            $avatar = time().'.'.$avatar->extension();
            $request->image->move(public_path('img/profiles'),$avatar );

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                "image" =>  $avatar,
                'password' => Hash::make($request->get('password')),
                'role_id' => 2
            ]);

            $token = $user->createToken('user_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Smth went wrong in AuthController.register'
            ], 403);
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|digits:10|numeric',
            'subject' => 'required',
            'message' => 'required',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);

        $input = $request->all();

        /*------------------------------------------
        --------------------------------------------
        Write Code for Store into Database
        --------------------------------------------
        --------------------------------------------*/
        dd($input);

        return redirect()->back()->with(['success' => 'Contact Form Submit Successfully']);
    }

    public function login(LoginRequest $request) {
        try {

            $user = User::with('chats')->where('login', $request->get('login'))->firstOrFail();

            if(!Hash::check($request->get('password'), $user->password)) {

                return response()->json([
                    'error' => 'Password wrong! :(',
                    'message' => 'Error in AuthController.login'
                ], 403);

            } else {

                $token = $user->createToken('user_token')->plainTextToken;
                $password = Hash::needsRehash($user->password);
                return response()->json([
                    'user' => $user,
                    'token' => $token,
                    'password' => $password
                ], 200);

            }

        } catch (\Exception $e) {

            if ($e instanceof ModelNotFoundException) {

                return response()->json([
                    'error_code' => 1,
                    'error' => $e->getMessage(),
                    'message' => 'Smth went wrong in AuthController.login'
                ], 403);

            } else {

                return response()->json([
                    'error' => $e->getMessage(),
                    'message' => 'Smth went wrong in AuthController.login'
                ], 403);

            }

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
