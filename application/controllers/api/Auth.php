<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Auth extends API_Controller
{
    public function __construct() {
        parent::__construct();        

        // Load Authorization Library or Load in autoload config file
        $this->load->library('authorization_token');
    }

    /**
     * Check API Key
     *
     * @return key|string
     */
    private function key()
    {
        // use database query for get valid key

        return 1452;
    }


    /**
     * login method 
     *
     * @link [api/user/login]
     * @method POST
     * @return Response|void
     */
    public function login()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
        ]);

        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
        );
        $auth = $this->login_auth($data);


        if ($auth['status'] == true) {
            // you user authentication code will go here, you can compare the user with the database or whatever
            $payload = [
                'id' => $this->input->post('username'),
                'other' => $this->input->post('password')
            ];
            // generate a token
            $token = $this->authorization_token->generateToken($data);

            $row = $this->db->where('user_id', $auth['user_id'])->get('api_keys')->row();

            if (empty($row)) {
                $this->db->insert('api_keys', array('api_key' => $token, 'user_id' => $auth['user_id']));
            } else {
                $this->db->where('user_id', $auth['user_id'])->update('api_keys', array('api_key' => $token));
            }

            // return data
            $this->api_return(
                [
                    'status' => true,
                    "result" => [
                        'token' => $token,
                    ],
                    
                ],
                200
            );

        } else {
            // return data
            $this->api_return(
                [
                    'status' => false,
                    "result" => [
                        'token' => '',
                    ],
                    
                ],
                404
            );      
        }
    }

    // Read data using username and password
    private function login_auth($data) {
     
        $sql = 'SELECT * FROM xin_employees WHERE username = ? AND is_active = ?';
        $binds = array($data['username'],1);
        $query = $this->db->query($sql, $binds);
                
        
        $options = array('cost' => 12);
        $password_hash = password_hash($data['password'], PASSWORD_BCRYPT, $options);
        if ($query->num_rows() > 0) {
            $rw_password = $query->result();
            if(password_verify($data['password'],$rw_password[0]->password)){
                $data = array(
                    'user_id' => $rw_password[0]->user_id, 
                    'status' => true,
                );
                return $data;
            } else {
                $data = array(
                    'user_id' => '', 
                    'status' => false,
                );
                return $data;
            }
        } else {
            $data = array(
                'user_id' => '', 
                'status' => false,
            );
            return $data;
        }
    }


    /**
     * demo method 
     *
     * @link [api/user/demo]
     * @method POST
     * @return Response|void
     */
    public function demo()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration
        $this->_apiConfig([
            /**
             * By Default Request Method `GET`
             */
            'methods' => ['POST'], // 'GET', 'OPTIONS'

            /**
             * Number limit, type limit, time limit (last minute)
             */
            'limit' => [5, 'ip', 'everyday'],

            /**
             * type :: ['header', 'get', 'post']
             * key  :: ['table : Check Key in Database', 'key']
             */
            'key' => ['POST', $this->key() ], // type, {key}|table (by default)
        ]);
        
        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => "Return API Response",
            ],
        200);
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