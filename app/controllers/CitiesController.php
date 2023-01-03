<?php

    class CitiesController extends BaseController {

        public function read() {

            $this->outputHeadersFromMethod('GET');

            $request = new Request;
            $request->decodeHttpRequest();

            $database = new Database();
            $database->openConnection();

            $city = new City($database);

            $recordset = $city->selectAll();

            if ($recordset !== false) {
                http_response_code(200);
                echo json_encode($recordset);
            } else {
                $this->outputResponseWithMessage(404, "No city founded.");
            }
        }

        public function create() {

            $this->outputHeadersFromMethod('POST');
        
            $request = new Request;
            $request->decodeHttpRequest();
            $data = $request->getBody();
            
            $database = new Database();
            $database->openConnection();
            
            $city = new City($database);
            
            if (empty($data['name'])) {
                $this->outputResponseWithMessage(400, "Error: Data is missing.");
            }
            if (!empty($data['name'])) {
        
                if ($city->create($data)) {
                    $this->outputResponseWithMessage(200, "A new city has been added.");
                } else {
                    $this->outputResponseWithMessage(503, "City was not added.");
                }
            }
        }

        public function delete() {

            $this->outputHeadersFromMethod('DELETE');
                
            $request = new Request;
            $request->decodeHttpRequest();
            $data = $request->getBody();
        
            $database = new Database();
            $database->openConnection();
        
            $city = new City($database);
        
            if (empty($data['id'])) {
                $this->outputResponseWithMessage(400, "Error: Data is missing.");
            }

            if (!empty($data['id'])) {
                if ($city->delete($data)) {
                    $this->outputResponseWithMessage(200, "City has been deleted.");
                } else {
                    $this->outputResponseWithMessage(503, "City was not deleted.");
                }
            }
        }

        public function update() {

            $this->outputHeadersFromMethod('PUT');
        
            $request = new Request;
            $request->decodeHttpRequest();
            $data = $request->getBody();
        
            $database = new Database();
            $database->openConnection();
        
            $city = new City($database);
        
            if (empty($data['id']) && empty($data['name'])) {
                $this->outputResponseWithMessage(400, "Error: Data is missing.");
            }

            if (!empty($data['id']) && !empty($data['name'])) {
        
                if ($city->update($data)) {
                    $this->outputResponseWithMessage(200, "City has been updated.");
                } else {
                    $this->outputResponseWithMessage(503, "City was not updated.");
                }
            }
        }
    }