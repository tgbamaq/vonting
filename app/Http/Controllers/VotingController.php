<?php

namespace App\Http\Controllers;

use App\Models\{
    Voting,
    User
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VotingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $voting = Voting::all();
        return response()->json($voting, 200);
    }

    public function importJson()
    {

        $client = new \GuzzleHttp\Client();
        $url = "https://vontingapi.onrender.com/voting";
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);

        $responseBody = json_decode($response->getBody(), true);

        foreach($responseBody as $res) {
            if(is_null(Voting::whereQuote($res['quote'])->first())) {
                Voting::create($res);
            }
        }
        return true;
    }

    public function token(Request $request)
    {
        if(is_null(User::whereEmail('voting@email.com')->first())) {
            $password = Hash::make('1@bamaq');
            $user = User::create([
                'name' => 'voting',
                'email' => 'voting@email.com',
                'password' => $password,
            ]);
            $token = $user->createToken('api');
            return ['token' => $token->plainTextToken];
        }
        else {
            return true;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'client' => 'required',
            'quote' => 'required',
            'group' => 'required',
            'vote' => 'required',
        ]);
        if(is_null(Voting::whereQuote($request->quote)->first())) {
            Voting::create($request->all());
            return response()->json([
                'message' => 'Obrigado pela sua participação!',
                'status' => 201
            ], 201);
        } else {
            return response()->json([
                'message' => 'Seu voto ja foi computado.',
                'status'  => 200
            ], 200);
        }
    }

}
