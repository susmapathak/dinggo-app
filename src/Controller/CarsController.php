<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

/**
 * Cars Controller
 *
 */
class CarsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Cars->find();
        $cars = $this->paginate($query);

        $this->set(compact('cars'));
    }

    /**
     * View method
     *
     * @param string|null $id Car id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $car = $this->Cars->get($id, contain: ['Quotes']);
        $this->set(compact('car'));
    }

    public function import()
    {
        $httpClient = new Client();
         // Define the URL and data
        $url = 'https://app.dev.aws.dinggo.com.au/phptest/cars';
        $data = [
            'username' => env('API_USERNAME'),
            'key' => env('API_KEY')
        ];

        // Send a POST request
        $response = $httpClient->post($url, json_encode($data), [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]);

        // Check for errors
        if ($response->isOk()) {
            $responseData = json_decode($response->getBody()->getContents(), true);
            if ($responseData['success'] == 'ok') {
                $carsTable = TableRegistry::getTableLocator()->get('Cars');
                $cars = $responseData['cars'];
                foreach ($cars as $car) {
                    // Map API fields camelCase to DB fields snake_case
                    $mappedCarData = [
                        'license_plate' => $car['licensePlate'],
                        'license_state' => $car['licenseState'],
                        'vin' => $car['vin'],
                        'year' => $car['year'],
                        'colour' => $car['colour'],
                        'make' => $car['make'],
                        'model' => $car['model']
                    ];

                    // Check if the car already exists based on vin
                    $existingCar = $carsTable->find()->where(['vin' => $car['vin']])->first();
                    if($existingCar){
                        // Update the existing car record
                        $mappedCarData['id'] = $existingCar->id;
                        $carEntity = $carsTable->patchEntity($existingCar, $mappedCarData);
                    }else{
                        // Create a new car entity
                        $carEntity = $carsTable->newEntity($mappedCarData);
                    }
                    // Save the car entity
                    $carsTable->save($carEntity);
                }
            }
            $this->Flash->success('Cars imported successfully.');
        } else {
            $this->Flash->error('Failed to fetch cars data.');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function importQuotes($id){
        $car = $this->Cars->get($id, contain: []);
        $httpClient = new Client();
        // Define the URL and data
        $url = 'https://app.dev.aws.dinggo.com.au/phptest/quotes';
        $data = [
            'username' => env('API_USERNAME'),
            'key' => env('API_KEY'),
            "licensePlate" => $car->license_plate,
            "licenseState" => $car->license_state
        ];

        // Send a POST request
        $response = $httpClient->post($url, json_encode($data), [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]);


        // Check for errors
        if ($response->isOk()) {
            $responseData = json_decode($response->getBody()->getContents(), true);
            if ($responseData['success'] == 'ok') {
                $quotesTable = TableRegistry::getTableLocator()->get('Quotes');
                $quotes = $responseData['quotes'];
                foreach ($quotes as $quote) {
                    // Check if the quotes already exists based on repairer and car_id
                    $existingQuote = $quotesTable->find()->where(['repairer' => $quote['repairer'], 'car_id' => $car->id])->first();
                    if($existingQuote){
                        // Update the existing quote record
                        $quote['id'] = $existingQuote->id;
                        $quoteEntity = $quotesTable->patchEntity($existingQuote, $quote);
                    }else{
                        // Create a new quotes entity
                        $quote['car_id'] = $car->id;
                        $quoteEntity = $quotesTable->newEntity($quote);
                    }
                    // Save the quotes entity
                    $quotesTable->save($quoteEntity);
                }
                $this->Flash->success('Quotes imported successfully.');
            }else{
                $this->Flash->error('Failed to fetch Quotes data.');
            }
        } else {
            $this->Flash->error('Failed to fetch Quotes data.');
        }

        return $this->redirect(['action' => 'view', $id]);
    }
}
