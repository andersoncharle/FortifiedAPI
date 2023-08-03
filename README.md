
# FortifiedAPI - Secure Laravel API with Sanctum!

🔒 FortifiedAPI is a secure Laravel API that utilizes Laravel Sanctum for user registration, login, and logout functionality. This guide will walk you through the steps to create and use the FortifiedAPI.

## Step 1: Create a New Laravel Project
Before creating your first Laravel project, you should ensure that your local machine has PHP and [Composer](https://getcomposer.org) installed.
After you have installed PHP and Composer, you may create a new Laravel project via the Composer `create-project` command:
```bash
composer create-project laravel/laravel FortifiedAPI
cd FortifiedAPI
```

Or, you may create new Laravel projects by globally installing the Laravel installer via Composer. 
```
composer global require laravel/installer
 
laravel new FortifiedAPI
```
The most recent versions of Laravel already include Laravel Sanctum. However, if your application's `composer.json` file does not include `laravel/sanctum`, you may follow the installation instructions below.

You may install Laravel Sanctum via the Composer package manager:

## Step 2: Publish Sanctum Configuration

```
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

```
Next, if you plan to utilize Sanctum to authenticate a SPA, you should add Sanctum's middleware to your `api` middleware group within your application's `app/Http/Kernel.php` file:

```
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
```

## Step 3: Connect Database

I am going to use the MYSQL database for this laravel 10 sanctum api authentication. So connect the database by updating.env like this:
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR_DB_NAME
DB_USERNAME=YOUR_DB_USERNAME
DB_PASSWORD=YOUR_DB_PASSWORD
```
I also changed the `id` of the user into `user_id` in the `create_users_table.php` migration file, and here is the code snippet:
```php '
$table->id('user_id');
```


Now run `php artisan migrate` command to migrate the database.

## Step 4: Set Up the User Model for Authentication

In your User model (usually located at `app/Models/User.php`), make sure to use the `HasApiTokens` trait:

```php
<?php
namespace  App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User  as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class  User  extends  Authenticatable {

use  HasApiTokens, HasFactory, Notifiable;


// define primary key
protected  $primaryKey=  'user_id';
// The attributes that are mass assignable.
protected  $fillable  = [
'name',
'email',
'password',
];
}

```

## Step 5: Create the AuthController
Create a new controller called `AuthController` in the `ApiAuth` directory; it's not necessary to use the `ApiAuth` directory.

To quickly generate an API resource controller that does not include the `create` or `edit` methods, use the `--api` switch when executing the `make:controller` command:

```bash
php artisan make:controller ApiAuth/AuthController --api
```
All necessary methods for registration, login, logout, and testing for authorized users are defined in authcontroller.

Now update this controller like this:
**app/Http/Controllers/API/ApiAuth/AuthController.php**

```php
<?php
namespace  App\Http\Controllers\ApiAuth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class  AuthController  extends  Controller{
/**
* Display a listing of the resource.
*/

public  function  index(Request  $request){
$data  =  "code with anderson";
$user  =  User::where('user_id', $request->user()->user_id)->get();
return  response()->json([$user, $data], 200);
}

public  function  registration(Request  $request)
{
$request->validate([
'name'  =>  'required|string|max:255',
'email'  =>  'required|email|unique:users,email',
'password'  =>  'required|confirmed|min:8',
]);

$user  =  User::create([
'name'  =>  $request->name,
'email'  =>  $request->email,
'password'  =>  Hash::make($request->password),
]);

if ($user) {
return  response()->json([
'status'  =>  'Request was successful',
'message'  =>  'User Created Successfully,Login to access the application',
'data'  =>  $user
], 201);
}

return  response()->json([
'status'  =>  'Error has occurred && Registration Failed...',
'message'  =>  'An error has occurred during registration. Please try again.'
], 401);
}

public  function  login(Request  $request)
{
$request->validate([
'email'  =>  'required|email',
'password'  =>  'required|min:8',
]);

$credentials  =  $request->only('email', 'password');
if (!Auth::attempt($credentials)) {
return  response()->json([
'status'  =>  'Error has occurred...',
'message'  =>  'Email & Password does not match with out record.'
], 401);
}

$user  =  User::where('email', $request->email)->first();
$token  =  $user->createToken('ApiToken'  .  $user->name)->plainTextToken;
return  response()->json([
'status'  =>  'Request was successful',
'message'  =>  'User Logged in Successfully',
'data'  =>  $user,
"token"  =>  $token
], 200);
}

public  function  logout(Request  $request){
$request->user()->tokens()->delete();
  return  response()->json(['message'  =>  'Logged out Successfully']);
}

}
```


## Step 6: Create API Routes

Define your API routes in `routes/api.php`. like:
```php
Route::post('register', [AuthController::class, 'registration']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware'  => ['auth:sanctum']], function () {
Route::get('test-api', [AuthController::class, 'index']);
Route::post('logout', [AuthController::class, 'logout']);
});
```


## Step 7: Run the application
using `php artisan serve` command.

## Step 8: Test the API

You can now test your FortifiedAPI using tools like Postman,thunder client or any front-end application that makes HTTP requests to your API..But for this tutorial, I've used [thunder client extension](https://marketplace.visualstudio.com/items?itemName=rangav.vscode-thunder-client) in vscode.

it's your time now to test your api like:
**Testing User Registration (POST /register)**
*To test user registration, send a POST request to the `/register` endpoint with the required parameters, such as `name`, `email`, `password`, and `password_confirmation`.*
```bash
http://127.0.0.1:8000/api/register
```

**Testing User Login (POST /login)**
*To test user login, send a POST request to the `/login` endpoint with the `email` and `password` of the registered user.*
```bash
http://127.0.0.1:8000/api/login
```


**Testing an Authorized User (GET /test-api)**
*View the thunder client output now. Remember to include a bearer token in your headers.*
*To test authorized user, send a GET request to the `/test-api` endpoint with the user's authentication token as a bearer token in the `Authorization` header.*
```bash
http://127.0.0.1:8000/api/test-api
```

**Testing User Logout (POST /logout)**
*To test user logout, send a POST request to the `/logout` endpoint with the user's authentication token as a bearer token in the `Authorization` header.*
```bash
http://127.0.0.1:8000/api/logout
```

That's it! You've successfully created and set up the 🔒FortifiedAPI with Laravel Sanctum, allowing for a secure user registration, login, and logout experience. Remember to further secure your API endpoints and add additional features to meet your application requirements.
Happy coding! 🚀
