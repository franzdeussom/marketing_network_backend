<?php 
namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Session;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Session as FacadesSession;

     class Token{
        private static $instance = null;
        private $listTokenUserOnline;
        private $request;

        public function __construct()
        {   
            $this->listTokenUserOnline = [];
            
        }

        public static function getInstance(){
            if(self::$instance == null){
                self::$instance = new self();
            }
            
            return self::$instance;
        }

        public function addNewToken(string $id, string $token){
            //$this->listTokenUserOnline[$id] = $token;
           // array_push( $this->listTokenUserOnline, $token);
                //$this->request->session()->put($token, $token);
                //session($token, $token);
        }

        public function generateToken(string $id): string{
            return sha1($id);
        }

        public function isTokenOk(string $token): bool{
                
            return session()->get($token) !== null;
        }

        public function logout($token){
            //$this->request->session()->forget($token);
             session()->forget($token);
        }

        public function getToken($token){
            return session($token);
        }
        public function getListToken() {
            return ($this->listTokenUserOnline);
        }
    }
?>