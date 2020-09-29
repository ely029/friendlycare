<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Patient;

use App\User;
use DB;
use Exception;
use Symfony\Component\HttpFoundation\Response;


class RegistrationController extends Controller
{

  public function patient()
  {
      $validator = \Validator::make(request()->all(), [
          'first_name' => 'required|max:255',
          'last_name' => 'required|max:255',
          'email' => 'required|string|email|max:50|unique:users',
          'middle_initial' => 'required|string|max:2',
          'gender' => 'required|max:1|string',
          'contact_number' => [
              'required',
              'between:10,15',
          ],
      ]);

      if ($validator->fails()) {
          return response()->json($validator->errors(), 422);
      }

      $request = request()->all();

      $request['role_id'] = 2;
      $request['password'] = bcrypt(request('password'));

      $user = User::create($request);



      // \Mail::send('emails.customer.successfully-registered', ['user' => $user], function ($message) use ($user) {
      //     $message->to($user->email, $user->first_name)->subject('Successfully Registered');
      // });

      $responseMessage = 'Successfully registered!';
      return response()->json($responseMessage, 201);
  }



}
