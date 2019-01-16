<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Rent Controller
 *
 * @property \App\Model\Table\RentTable $Rent
 *
 * @method \App\Model\Entity\Rent[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RentController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $rent = $this->paginate($this->Rent);

        $this->set(compact('rent'));
    }

    /**
     * View method
     *
     * @param string|null $id Rent id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rent = $this->Rent->get($id, [
            'contain' => []
        ]);

        $this->set('rent', $rent);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rent = $this->Rent->newEntity();
        if ($this->request->is('post')) {
            $rent = $this->Rent->patchEntity($rent, $this->request->getData());
            if ($this->Rent->save($rent)) {
                $this->Flash->success(__('The rent has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rent could not be saved. Please, try again.'));
        }
        $this->set(compact('rent'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Rent id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rent = $this->Rent->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rent = $this->Rent->patchEntity($rent, $this->request->getData());
            if ($this->Rent->save($rent)) {
                $this->Flash->success(__('The rent has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rent could not be saved. Please, try again.'));
        }
        $this->set(compact('rent'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Rent id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rent = $this->Rent->get($id);
        if ($this->Rent->delete($rent)) {
            $this->Flash->success(__('The rent has been deleted.'));
        } else {
            $this->Flash->error(__('The rent could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
