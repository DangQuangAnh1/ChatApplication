<?php
// src/Controller/ArticlesController.php

namespace App\Controller;

class ChatController extends AppController
{   
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
        $this->loadModel('T_feed');
    }
    public function index()
    {
        $this->loadComponent('Paginator');
        $t_feed = $this->Paginator->paginate($this->T_feed->find()->order(['id' => 'DESC']));
        $this->set(compact('t_feed'));
    }
    public function view($id = null)
    {
        $t_feed = $this->T_feed->findById($id)->firstOrFail();
        $this->set(compact('t_feed'));
    }
    public function add()
    {
        $t_feed = $this->T_feed->newEmptyEntity();
        if ($this->request->is('post')) {
            $t_feed = $this->T_feed->patchEntity($t_feed, $this->request->getData());
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            date_default_timezone_get();
            $today = date('Y-m-d H:i:s');
            $t_feed->create_at = $today;
            $t_feed->update_at = $today;

            // Hardcoding the user_id is temporary, and will be removed later
            // when we build authentication out.
            //$t_feed->id = 1;

            if ($this->T_feed->save($t_feed)) {
                $this->Flash->success(__('Your chat has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your chat.'));
        }
        $this->set('t_feed', $t_feed);
    }
    public function edit($id)
    {
        $t_feed = $this->T_feed
            ->findById($id)
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $this->T_feed->patchEntity($t_feed, $this->request->getData());
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            date_default_timezone_get();
            $today = date('Y-m-d H:i:s');
            //$t_feed->create_at = $today;
            $t_feed->update_at = $today;
            if ($this->T_feed->save($t_feed)) {
                $this->Flash->success(__('Your chat has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your chat.'));
        }

        $this->set('t_feed', $t_feed);
    }
    public function delete($id) {
        $this->request->allowMethod(['post', 'delete']);

        $t_feed = $this->T_feed->findById($id)->firstOrFail();
        if ($this->T_feed->delete($t_feed)) {
            $this->Flash->success(__('The feed has been deleted.'));
            return $this->redirect(['action' => 'index']);
        }
    }

}