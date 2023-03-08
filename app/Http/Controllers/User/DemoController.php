<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DemoController extends Controller
{
    public function postDemo(Request $request)
    {
        $inputs = $request->all();
        // $arr = json_decode($inputs['inputs'], true);
        Log::info($inputs);
        Log::info('Huuphuoc');
    }

    public function testDiscord()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

        error_reporting(E_ALL);

        define('OAUTH2_CLIENT_ID', '1082120523250683974');
        define('OAUTH2_CLIENT_SECRET', 'rQvo7QfT4UlCUeNK3Rbb3kTlP8r2A5G5');

        $authorizeURL = 'https://discord.com/api/oauth2/authorize';
        $tokenURL = 'https://discord.com/api/oauth2/token';
        $apiURLBase = 'https://discord.com/api/users/@me';
        $revokeURL = 'https://discord.com/api/oauth2/token/revoke';

        session_start();

        // Start the login process by sending the user to Discord's authorization page
        if ($this->get('action') == 'login') {
            $params = array(
                'client_id' => OAUTH2_CLIENT_ID,
                'redirect_uri' => 'http://localhost:8088/join-discord',
                'response_type' => 'code',
                'scope' => 'identify guilds guilds.join'
            );

            // Redirect the user to Discord's authorization page
            header('Location: '. $authorizeURL . '?' . http_build_query($params));
            die();
        }

        // When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
        if ($this->get('code')) {
            // Exchange the auth code for a token
            $token = $this->apiRequest($tokenURL, array(
                "grant_type" => "authorization_code",
                'client_id' => OAUTH2_CLIENT_ID,
                'client_secret' => OAUTH2_CLIENT_SECRET,
                'redirect_uri' => 'http://localhost:8088/join-discord',
                'code' => $this->get('code')
            ));

            $logout_token = $token->access_token;
            $_SESSION['access_token'] = $token->access_token;

            header('Location: http://localhost:8088/join-discord');
        }

        if ($this->session('access_token')) {
            $user = $this->apiRequest($apiURLBase);

            $guild_ID = '1082118121172774982';
            $addUserToGuild = $this->addUserToGuild($user->id, $this->session('access_token'), $guild_ID);
            $_SESSION['userData'] = [
                'name' => $user->username,
                'discord_id' => $user->id,
                'avatar' => $user->avatar,
                'guilds' => $this->getUsersGuilds($this->session('access_token')),
                'hello' => $user
            ];

            echo '<!doctype html>
                    <html>
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <link href="/css/discord.css" rel="stylesheet">
                            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                        </head>
                        <body>
                            <div class="text-center w-50" style="margin: 20px auto">
                                <p class="alert alert-success">Ban da duoc them vao nhom chat</p>
                                <p class="alert alert-info">Welcome, ' . $user->username .'</p>
                                
                                <a href="?action=logout">
                                    <p style="border: 1px; border-radius: 10px; background-color:#7289da; padding: 10px">
                                        <span class="text-white font-semibold text-xl"><i class="fa-brands fa-discord"></i> Logout with Discord</span>
                                    </p>
                                </a>
                                <a href="'. route("test.demo") .'">
                                    <p style="border: 1px; border-radius: 10px; background-color:#7289da; padding: 10px">
                                        <span class="text-white font-semibold text-xl"><i class="fa-brands fa-discord"></i> Demo</span>
                                    </p>
                                </a>
                            </div>    
                        </body>
                    </html>';
    
        } else {
            echo '<!doctype html>
                    <html>
                        <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link href="/css/discord.css" rel="stylesheet">
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                        </head>
                        <body>
                            <div class="flex items-center justify-center h-screen bg-discord-gray">
                                <a href="?action=login" class="bg-discord-blue px-5 py-3 rounded-md hover:bg-gray-600 transition">
                                    <span class="text-white font-semibold text-xl"><i class="fa-brands fa-discord mr-2"></i> Login with Discord</span>
                                </a>
                            </div>
                        </body>
                    </html>';
        }

        if ($this->get('action') == 'logout') {
            $user = $this->apiRequest($apiURLBase);
            $guild_ID = '1082118121172774982';
            // $this->kickUserToGuild($user->id, $this->session('access_token'), $guild_ID);
            // This should logout you
            $this->logout($revokeURL, array(
                'token' => $this->session('access_token'),
                'token_type_hint' => 'access_token',
                'client_id' => OAUTH2_CLIENT_ID,
                'client_secret' => OAUTH2_CLIENT_SECRET,
            ));
            unset($_SESSION['access_token']);
            header('Location: http://localhost:8088/demo');
            die();
        }
    }

    public function kick()
    {
        $guild_ID = '1082118121172774982';
        $this->kickUserToGuilds(1072008253669654548, $guild_ID);
        
        return redirect()->route('test.demo')->with('kick_succees', __('Kich thanh cong'));
    }

    function apiRequest($url, $post = FALSE, $headers = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($ch);


        if ($post)
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

        $headers[] = 'Accept: application/json';

        if ($this->session('access_token'))
            $headers[] = 'Authorization: Bearer ' . $this->session('access_token');

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        return json_decode($response);
    }

    function get($key, $default = NULL)
    {
        return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
    }

    function session($key, $default = NULL)
    {
        return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
    }

    function addUserToGuild($discord_ID, $token, $guild_ID)
    {
        $payload = [
            'access_token' => $token,
        ];

        $discord_api_url = 'https://discordapp.com/api/guilds/' . $guild_ID . '/members/' . $discord_ID;

        $bot_token = "MTA4MjEyMDUyMzI1MDY4Mzk3NA.GtPpnq.6kOIWHunMuM7Lm5-up_Sj99smIssGPdWEJMpMQ";
        $header = array("Authorization: Bot $bot_token", "Content-Type: application/json");

        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $discord_api_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); //must be put for this method..
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload)); //must be a json body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($ch);

        if (!$result) {
            echo curl_error($ch);
        } else {
            return true;
        }
    }

    function kickUserToGuild($discord_ID, $token, $guild_ID)
    {
        $payload = [
            'access_token' => $token,
        ];

        $discord_api_url = 'https://discordapp.com/api/guilds/' . $guild_ID . '/members/' . $discord_ID;

        $bot_token = "MTA4MjEyMDUyMzI1MDY4Mzk3NA.GtPpnq.6kOIWHunMuM7Lm5-up_Sj99smIssGPdWEJMpMQ";
        $header = array("Authorization: Bot $bot_token", "Content-Type: application/json");

        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $discord_api_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); //must be put for this method..
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload)); //must be a json body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($ch);

        if (!$result) {
            echo curl_error($ch);
        } else {
            return true;
        }
    }

    function kickUserToGuilds($discord_ID, $guild_ID)
    {
        $discord_api_url = 'https://discordapp.com/api/guilds/' . $guild_ID . '/members/' . $discord_ID;

        $bot_token = "MTA4MjEyMDUyMzI1MDY4Mzk3NA.GtPpnq.6kOIWHunMuM7Lm5-up_Sj99smIssGPdWEJMpMQ";
        $header = array("Authorization: Bot $bot_token", "Content-Type: application/json");

        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $discord_api_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); //must be put for this method..
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload)); //must be a json body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($ch);

        if (!$result) {
            echo curl_error($ch);
        } else {
            return true;
        }
    }


    function getUsersGuilds($auth_token)
    {
        //url scheme /users/@me/guilds
        $discord_api_url = "https://discordapp.com/api";
        $header = array("Authorization: Bearer $auth_token", "Content-Type: application/x-www-form-urlencoded");
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $discord_api_url . '/users/@me/guilds');
        curl_setopt($ch, CURLOPT_POST, false);
        //curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        $result = json_decode($result, true);
        return $result;
    }

    function logout($url, $data = array())
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
            CURLOPT_POSTFIELDS => http_build_query($data),
        ));
        $response = curl_exec($ch);
        return json_decode($response);
    }
}
