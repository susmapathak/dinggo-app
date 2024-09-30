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
        $car = $this->Cars->get($id, contain: []);
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

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
    //     $car = $this->Cars->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $car = $this->Cars->patchEntity($car, $this->request->getData());
    //         if ($this->Cars->save($car)) {
    //             $this->Flash->success(__('The car has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The car could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('car'));
    // }

    /**
     * Edit method
     *
     * @param string|null $id Car id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function edit($id = null)
    // {
    //     $car = $this->Cars->get($id, contain: []);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $car = $this->Cars->patchEntity($car, $this->request->getData());
    //         if ($this->Cars->save($car)) {
    //             $this->Flash->success(__('The car has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The car could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('car'));
    // }

    /**
     * Delete method
     *
     * @param string|null $id Car id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $car = $this->Cars->get($id);
    //     if ($this->Cars->delete($car)) {
    //         $this->Flash->success(__('The car has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The car could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }
}
