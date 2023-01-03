<?php

    class UsersController extends BaseController {

        public function create() {

            $this->outputHeadersFromMethod('POST');

            $request = new Request;
            $request->decodeHttpRequest();
            $data = $request->getBody();
            
            $database = new Database();
            $database->openConnection();
            
            $user = new User($database);

            if (empty($data['username'])) {
                $this->outputResponseWithMessage(400, "Error: Data is missing.");
            }
            
            if (!empty($data['username'])) {
                if ($user->create($data)) {
                    $this->outputResponseWithMessage(200, "New user added.");
                } else {
                    $this->outputResponseWithMessage(503, "User was not added.");
                }
            }

        }

        public function login() {

            $this->outputHeadersFromMethod('POST');

            $request = new Request;
            $request->decodeHttpRequest();
            $data = $request->getBody();
            
            $database = new Database();
            $database->openConnection();
            
            $user = new User($database);

            if (empty($data['username'])) {
                $this->outputResponseWithMessage(400, "Error: Data is missing.");
                exit;
            }
            
            if (!empty($data['username'])) {
                if ($user->login($data)) {
                    $this->outputResponseWithMessage(200, "1");
                    exit;
                } else {
                    $this->outputResponseWithMessage(200, "0");
                    exit;
                }
            }
        }

        public function read() {

            $this->outputHeadersFromMethod('GET');

            $request = new Request;
            $request->decodeHttpRequest();

            $database = new Database();
            $database->openConnection();

            $user = new User($database);

            $recordset = $user->selectAll();

            if ($recordset !== false) {
                http_response_code(200);
                echo json_encode($recordset);
            } else {
                $this->outputResponseWithMessage(404, "No user founded.");
            }

        }
    }