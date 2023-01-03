<?php

    class FlightsController extends BaseController {

        public function read($parameters) {
            
            $this->outputHeadersFromMethod('GET');

            $request = new Request;
            $request->decodeHttpRequest();
            
            $database = new Database();
            $database->openConnection();
            
            $flight = new Flight($database);
            
            $recordset = $flight->selectAll();
            
            if ($recordset !== false) {
                http_response_code(200);
                echo json_encode($recordset);
            } else {
                $this->outputResponseWithMessage(404, "No flights founded.");
            }
        }

        public function create() {

            $this->outputHeadersFromMethod('POST');

            $request = new Request;
            $request->decodeHttpRequest();
            $data = $request->getBody();
            
            $database = new Database();
            $database->openConnection();
            
            $flight = new Flight($database);
            
            if (
                empty($data['departure']) &&
                empty($data['arrival']) &&
                empty($data['availableSeats'])
            ) {
                $this->outputResponseWithMessage(400, "Error: Data is missing.");
            }

            if (
                !empty($data['departure']) &&
                !empty($data['arrival']) &&
                !empty($data['availableSeats'])
            ) {
                if ($flight->create($data)) {
                    $this->outputResponseWithMessage(200, "A new flight has been added.");
                } else {
                    $this->outputResponseWithMessage(503, "Flight was not added.");
                }
            }

        }

        public function delete($parameters) {

            $id = (int)$parameters[1];

            $this->outputHeadersFromMethod('DELETE');

            $request = new Request;
            $request->decodeHttpRequest();
            
            $database = new Database();
            $database->openConnection();
            
            $flight = new Flight($database);
            
            if ($id < 0) {
                $this->outputResponseWithMessage(400, "Error: Data is missing.");
            }

            if ($flight->delete($id) === true) {

                $this->outputResponseWithMessage(200, "Flight has been deleted.");

            } else {
                $this->outputResponseWithMessage(503, "Flight was not deleted.");
            }

        }

        public function update() {

            $this->outputHeadersFromMethod('UPDATE');

            $request = new Request();
            $request->decodeHttpRequest();
            $data = $request->getBody();
            
            $database = new Database();
            $database->openConnection();
            
            $flight = new Flight($database);
            
            if (empty($data['id']) && empty($data['availableSeats'])) {
                $this->outputResponseWithMessage(400, "Error: Data is missing.");
            }

            if ($flight->update($data)) {
                $this->outputResponseWithMessage(200, "Flight has been updated.");
            } else {
                $this->outputResponseWithMessage(503, "Flight was not updated.");
            }
        }
    }