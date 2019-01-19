<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * @author Mischa
 * @property \App\Model\Table\ApartmentsTable $Apartments
 * @method \App\Model\Entity\Apartment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApartmentsController extends AppController{

    /**
     * @author Mischa
     * @param $id Integer. Default null, id von Apartment
     * @property steuert Aufrufe von Camunda Rest API je nach dem, auf welchem Schritt man sich befindet
     * @return void| setzt die Daten von Apartment(mit User) und von user eingegebene Daten ins Model
     * @return API-bezogene Daten werden in SESSION gespeichert (inkl. processInstanceIdIn)
     * @todo Refactoring, ausbauen von {ifelse}
     */
    public function show($id = null){
        if($this->request->is('post')){

            $data = $this->request->getData();

            if(isset($data['step']) && $data['step'] === 'Prüfen'){ //start Process
                $data['id'] = $id;
                $data['step'] = 'step1';
                $this->sendApiRequest($data);
            }elseif(isset($data['step2'])){ // get Verfügbarkeit des Apartments
                $data['step'] = 'step2';
                $this->getAvailabilityWorkerResult();
            }elseif (isset($data['step3'])) { // get Map mit Preisen when verfügbar ist
                $data['step'] = 'step3';
                $this->getAvailabilityWorkerResult();
                $this->getFaktorWorkerResult();
            }
            
            $this->set('data', $data);
        }
        /* allgemeine Logik START*/
        $this->viewBuilder()->setLayout('main');
        $this->viewBuilder()->setTemplate('show');
        $this->set('apartment', $this->Apartments->get($id, ['contain' => ['Users']]));
        /* allgemeine Logik END*/
    }

    /**
     * @author Mischa
     * @property Aufruf von Camunda Rest API http://localhost:8080/engine-rest/history/variable-instance
     * @property mit GET-Parameter {@param processInstanceIdIn}
     * @property processInstanceIdIn kommt aus Responce von ApartmentsController.sendApiRequest() als ID
     * @return void| setzt das Map mit Faktoren ins Model
     * @todo Refactor mit unterer Methode
     */
    private function getFaktorWorkerResult(){
        //todo
    }

    /**
     * @author Mischa
     * @property Aufruf von Camunda Rest API http://localhost:8080/engine-rest/history/variable-instance
     * @property mit GET-Parameter {@param processInstanceIdIn}
     * @property processInstanceIdIn kommt aus Responce von ApartmentsController.sendApiRequest() als ID
     */
    private function getAvailabilityWorkerResult(){
        $camunda = $this->request->session()->read('camunda');
        $url = 'http://localhost:8080/engine-rest/history/variable-instance?variableName=available&processInstanceIdIn=' . $camunda->id;
        $content = file_get_contents($url, true);

        $json = json_decode($content);
        $available = $json[0]->name == 'available' ? $json[0]->value : false;
        $this->set('available', $available);
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
        
        $definition_key = 'foliage_apartments:1:6fae56a5-1c18-11e9-82f8-0250f2000001';
        $curl_req = curl_init();
        curl_setopt($curl_req, CURLOPT_URL, 'http://localhost:8080/engine-rest/process-definition/'.$definition_key.'/start');
        curl_setopt($curl_req, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_req, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl_req, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_req, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($data_string)]);

        $result = curl_exec($curl_req);

        $session = $this->request->session();
        $session->write('camunda', json_decode($result)); 
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
