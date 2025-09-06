<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Cinema;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Genre;
use App\Models\GenreMovie;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cinemas = Cinema::with('location')->get();
        $query = $request->input('q');
        $genre_id = $request->input('genre_id');

        $movies = Movie::query();

        if ($cinema_id = $request->input('cinema_id')) {
            $movies->whereHas('showtime.room.cinema', function ($query) use ($cinema_id) {
                $query->where('id', $cinema_id);
            });
        }

        if ($query) {
            $movies->where('title', 'LIKE', '%' . $query . '%');
        }

        if ($genre_id) {
            // Nếu movie có genre_movie_id trỏ tới bảng genre_movies
            $movies->whereHas('genre_movie', function ($q) use ($genre_id) {
                $q->where('genre_id', $genre_id);
            });
        }

        $movies = $movies->get();
        $genres = Genre::all();

        return view('Customer.index', compact('movies', 'genres', 'query', 'genre_id', 'cinemas'));
    }

    public function about() {
        return view('Customer.about');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $password = bcrypt($request->password);
        $array = [];
        $array = Arr::add($array, 'email', $request->email);
        $array = Arr::add($array, 'gender', $request->gender);
        $array = Arr::add($array, 'phone_number', $request->phone_number);
        $array = Arr::add($array, 'name', $request->name);
        $array = Arr::add($array, 'birth_date', $request->birth_date);
        $array = Arr::add($array, 'password', $password);
        Customer::create($array);
        return Redirect::route('customers.login');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customers = Customer::all();
        return view('Admin.customers', compact('customers'));
    }

    public function account() {
        $customer = session('customer');
        return view('Customer.account', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('Customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'gender'       => 'required|in:1,2', // 1 = Nam, 2 = Nữ
            'birth_date'   => 'nullable|date',
            'phone_number' => 'nullable|string|max:255',
        ]);

        $customer = Customer::findOrFail($id);

        $customer->update([
            'name'         => $request->name,
            'email'        => $request->email,
            'gender'       => $request->gender,
            'birth_date'   => $request->birth_date,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('customers.account')->with('success', 'Cập nhật thông tin tài khoản thành công! Thông tin tài khoản của bạn sẽ thay đổi vào lần đăng nhập tiếp theo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function login() {
        return view('Customer.login_customer');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $customer = Customer::where('email', $credentials['email'])->first();

        if (!$customer || !Hash::check($credentials['password'], $customer->password)) {
            return back()->withErrors([
                'email' => 'Email hoặc mật khẩu không đúng.',
            ]);
        }

        // Đăng nhập thủ công bằng session
        session(['customer_id' => $customer->id]);

        // Luu thông tin tài khoản vào session
        Session::put('customer', $customer);

        return redirect()->intended(route('customers.index'));
    }

    public function logout(Request $request)
    {
        session()->forget('customer_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customers.login');
    }
}
