<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Dashboard extends API_Controller
{
    public function __construct() {
        parent::__construct();  
        $this->load->helper('api_helper');      
    }

    /**
     * demo method 
     *
     * @link [api/user/demo]
     * @method POST
     * @return Response|void
     */
    public function test()
    {
        $user_info = api_auth('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZ');
        if ($user_info['status'] == true) {
            // code...
        }
        dd($user_info);
    }

    /**
     * view method
     *
     * @link [api/user/view]
     * @method POST
     * @return Response|void
     */
    public function view()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration [Return Array: User Token Data]
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            'requireAuthorization' => true,
        ]);

        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'user_data' => $user_data['token_data']
                ],
            ],
        200);
    }
}