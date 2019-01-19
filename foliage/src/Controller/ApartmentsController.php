<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
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

            if(isset($data['step']) && $data['step'] === 'Prüfen'){ //step 1
                //start Process
                $data['id'] = $id;
                $data['step'] = 'step1';
                $this->sendApiRequest($data);

            }elseif(isset($data['step2'])){
                $data['step'] = 'step2';
                //step 2
                //get Availability http://localhost:8080/engine-rest/history/variable-instance/593ede52-1aac-11e9-9c41-0250f2000001 - от куда взять айди?
                //http://localhost:8080/engine-rest/process-instance просто лист процессов, ничего не дает 46d4b7fa-1b75-11e9-b149-0250f2000001
                //http://localhost:8080/engine-rest/history/variable-instance?processInstanceIdIn=46d4b7fa-1b75-11e9-b149-0250f2000001 vot bl
                $this->getAvailabilityWorkerResult();
                
            }elseif (isset($data['step3'])) {
                $data['step'] = 'step3';
                //step 3
                //get map with prices
            }
            //schliesslich die daten speichern
            $this->set('data', $data);
        }

        // if($this->request->is('post')){
        //     $data = $this->request->getData();
        //     if(!empty($data)){
        //         $data['id'] = $id;
        //         $this->sendApiRequest($data);
        //         $this->set('data', $data);
        //     }
        // }

        $this->viewBuilder()->setLayout('main');
        $this->viewBuilder()->setTemplate('show');
        $apartment = $this->Apartments->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('apartment', $apartment);
    }

    private function getAvailabilityWorkerResult(){
        $camunda = $this->request->session()->read('camunda');
        $url = 'http://localhost:8080/engine-rest/history/variable-instance?processInstanceIdIn=' . $camunda->id;
        $content = file_get_contents($url, true);

        $json = json_decode($content);
        $availability = 'not found';
        for ($i=0; $i < sizeof($json); $i++) { 
            $availability= $availability;

            if($json[$i]->name === 'available'){
                $available = $json[$i]->value;
                break;
            }
        }

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

        $curl_req = curl_init();
        curl_setopt($curl_req, CURLOPT_URL, 'http://localhost:8080/engine-rest/process-definition/foliage_apartments:3:fa762c1a-1a8d-11e9-9c41-0250f2000001/start');
        curl_setopt($curl_req, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_req, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl_req, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_req, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($data_string)]);

        $result = curl_exec($curl_req);

        // $this->set('response', );
        //$_SESSION['camunda'] = json_decode($result);
        //Configure::write('Camunda', json_decode($result));

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
