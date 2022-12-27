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

        // $responseBody = json_decode($response->getBody(), true);

        $responseBody = [
            [
                "client" => "NIVALDO VIANA",
                "quote" => "3330",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "ELISANDRO MOTA DA SILVA",
                "quote" => "4624",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "MICHAELE CARVALHO DOS SANTOS",
                "quote" => "1711",
                "group" => "005026"
            ],
            [
                "client" => "ANTONIO CARLOS BORGES ALMEIDA",
                "quote" => "3237",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "ANA CLEIDE DE OLIVEIRA AVILA",
                "quote" => "0096",
                "group" => "005026"
            ],
            [
                "client" => "ANA KAROLINY MARIM CARDOSO",
                "quote" => "1288",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "DANIEL BARBOSA MARQUES DE AZEVEDO",
                "quote" => "4246",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "BRIAN HENRIQUE MENDES DE SOUZA",
                "quote" => "2125",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "CLAUDIO HENRIQUE FERREIRA ZICA",
                "quote" => "1163",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "EDVAN GONCALVES DA SILVA",
                "quote" => "2221",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "Priscila Barbara Nigri De Olivera",
                "quote" => "3527",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "ADENILSON ROCHA SANTOS",
                "quote" => "3733",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "ALEXANDRO DOS REIS JUNIOR",
                "quote" => "3425",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "LUCIANO GONTIJO SILVA",
                "quote" => "3537",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "MALLONE ARAUJO PIRES",
                "quote" => "2168",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "DONIZETE RODRIGUES DE FARIA",
                "quote" => "1572",
                "group" => "005026",
                "vote" => "nao"
            ],
            [
                "client" => "GUSTAVO FERRAZ TORQUETTE",
                "quote" => "2786",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "THIAGO LUIZ VERONESE",
                "quote" => "3289",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "ANDRE LUIZ AVELAR PAPI",
                "quote" => "4164",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "ANTONIO GUERRA SOBRINHO",
                "quote" => "2774",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "Thamara De Souza Andrade",
                "quote" => "3584",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "FABRICIO DE SOUZA POLICARPO",
                "quote" => "0794",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "DANIELLI MARTINS LISBOA DORIGUETTO",
                "quote" => "1439",
                "group" => "005026",
                "vote" => "sim"
            ],
            [
                "client" => "YASMIN DE ABREU DELFINO",
                "quote" => "2599",
                "group" => "005026",
                "vote" => "sim"
            ]
        ];

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
