<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Apartments Controller
 *
 * @property \App\Model\Table\ApartmentsTable $Apartments
 *
 * @method \App\Model\Entity\Apartment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApartmentsController extends AppController{

    /*user section start*/
    public function show($id = null){
        if($this->request->is('post')){
            $data = $this->request->getData();
            if(!empty($data)){
                $data['id'] = $id;
                $this->sendApiRequest($data);
                $this->set('data', $data);
            }
        }

        $this->viewBuilder()->setLayout('main');
        $this->viewBuilder()->setTemplate('show');
        $apartment = $this->Apartments->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('apartment', $apartment);
    }

    /**
     * @author mischa
     * @param $data array with the data to be sent to camunda engine
     */
    private function sendApiRequest($data){
        $dataJSON = [
            "variables" => [
                "from" => [
                    "value" => $data['from'], 
                    "type" => "String"
                ],
                "to" => [
                    "value" => $data['to'], 
                    "type" => "String"
                ],
                "id" => [
                    "value" => $data['id'], 
                    "type" => "Integer"
                ]
            ]
        ];

        $data_string = json_encode($dataJSON);

        $curl_req = curl_init();
        curl_setopt($curl_req, CURLOPT_URL, 'http://localhost:8080/engine-rest/process-definition/foliage_apartments:3:fa762c1a-1a8d-11e9-9c41-0250f2000001/start');
        curl_setopt($curl_req, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_req, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl_req, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_req, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($data_string)]);

        $result = curl_exec($curl_req);
        $this->set('response', json_decode($result));

        curl_close($curl_req);
    }

    /*user section end*/

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $apartments = $this->paginate($this->Apartments);

        $this->set(compact('apartments'));
    }

    /**
     * View method
     *
     * @param string|null $id Apartment id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $apartment = $this->Apartments->get($id, [
            'contain' => []
        ]);

        $this->set('apartment', $apartment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $apartment = $this->Apartments->newEntity();
        if ($this->request->is('post')) {
            $apartment = $this->Apartments->patchEntity($apartment, $this->request->getData());
            if ($this->Apartments->save($apartment)) {
                $this->Flash->success(__('The apartment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The apartment could not be saved. Please, try again.'));
        }
        $this->set(compact('apartment'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Apartment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $apartment = $this->Apartments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $apartment = $this->Apartments->patchEntity($apartment, $this->request->getData());
            if ($this->Apartments->save($apartment)) {
                $this->Flash->success(__('The apartment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The apartment could not be saved. Please, try again.'));
        }
        $this->set(compact('apartment'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Apartment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $apartment = $this->Apartments->get($id);
        if ($this->Apartments->delete($apartment)) {
            $this->Flash->success(__('The apartment has been deleted.'));
        } else {
            $this->Flash->error(__('The apartment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
