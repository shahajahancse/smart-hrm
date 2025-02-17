<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Auth extends API_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load Authorization Library or Load in autoload config file
        $this->load->library('Authorization_Token');
        $this->load->helper('api_helper');
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
            'email' => $this->input->post('username'),
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
            $user_info = api_auth($token);
            if ($user_info) {
                $user_info['user_info']->token = $token;
                $this->api_return([
                    'status' => true,
                    'message' => 'User login successful.',
                    'data' => $user_info['user_info'],
                ], 200);
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'User login unsuccessful.',
                    'data' => [],
                ], 404);
            }

        } else {
            $this->api_return([
                'status' => false,
                'message' => 'User login unsuccessful.',
                'data' => [],
            ], 404);
        }
    }
    public function logout()
    {
        $authorization = $this->input->get_request_header('Authorization');
        // Validate and sanitize the authorization value
        if (!empty($authorization) && is_string($authorization)) {
            $authorization = trim($authorization);
            // Verify the validity of the API key before deleting it
            $existingKey = $this->db->where('api_key', $authorization)->get('api_keys')->row();
            if ($existingKey) {
                // Delete the API key record
                $this->db->where('id', $existingKey->id)->delete('api_keys');
                // Success response
                $this->api_return([
                    'status' => true,
                    'message' => 'User logout successful.',
                    'data' => [],
                ], 200);
                
            } else {
                // Error response for invalid API key
                $this->api_return([
                    'status' => false,
                    'message' => 'User logout unsuccessful.',
                    'data' => [],
                ], 404);
            }
        } else {
            // Error response for missing or invalid authorization header
            $this->api_return([
                'status' => false,
                'message' => 'User logout unsuccessful.',
                'data' => [],
            ], 404);
        }
    }
    // Read data using username and password
    private function login_auth($data)
    {
      $sql = 'SELECT * FROM xin_employees WHERE email = ? AND is_active = ? AND status IN (?, ?, ?,?)';
      $binds = array($data['email'], 1, 1, 4, 5,0);
      $query = $this->db->query($sql, $binds);
        $options = array('cost' => 12);
        $password_hash = password_hash($data['password'], PASSWORD_BCRYPT, $options);
        if ($query->num_rows() > 0) {
            $rw_password = $query->result();
            if(password_verify($data['password'], $rw_password[0]->password)) {
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
            200
        );
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
            200
        );
    }
}
