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
        $this->loadModel('T_user');
    }
    public function index()
    {
        $this->loadComponent('Paginator');
        $t_feed = $this->Paginator->paginate($this->T_feed->find()->order(['id' => 'DESC']));
        $t_user = $this->Paginator->paginate($this->T_user->find());
        $this->set(compact('t_feed','t_user'));
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

            $session = $this->request->getSession();
            $t_feed->name = $session->read('name');
            $t_feed->user_id = $session->read('user_id');

            // $attachment = $this->request->getData('Upload_file');
            // debug($attachment);
            // exit;

            if(!$t_feed->getErrors){
                $attachment = $this->request->getData('Upload_file');
                if(!$attachment->getError()){
                    $name = $attachment->getClientFilename();
                    $type = $attachment->getClientMediaType();
                    $size = $attachment->getSize();
                    $tmpName = $attachment->getStream()->getMetadata('uri');
                    $error = $attachment->getError();
                    if($type=="video/mp4" || $type=="video/ogg"){
                        $targetPath= WWW_ROOT.'video'.DS.$name;
                    }
                    else {
                        $targetPath= WWW_ROOT.'img'.DS.$name;
                    }
                    if($name){
                        $attachment->moveTo($targetPath);
                        $t_feed->image_file_name=$name;
                    }
                }
            }    

            if ($this->T_feed->save($t_feed)) {
                // $this->Flash->success(__('Your chat has been saved.'));
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
            $t_feed->update_at = $today;

            if(!$t_feed->getErrors){
                $attachment = $this->request->getData('Upload_file');
                if(!$attachment->getError()){
                    $name = $attachment->getClientFilename();
                    $type = $attachment->getClientMediaType();
                    $size = $attachment->getSize();
                    $tmpName = $attachment->getStream()->getMetadata('uri');
                    $error = $attachment->getError();
                    if($type=="video/mp4" || $type=="video/ogg"){
                        $targetPath= WWW_ROOT.'video'.DS.$name;
                    }
                    else if($type=="image/jpeg"|| $type=="image/png"){
                        $targetPath= WWW_ROOT.'img'.DS.$name;
                    }
                    if($name){
                        $attachment->moveTo($targetPath);
                        $t_feed->image_file_name=$name;
                    }
                }
            }

            if ($this->T_feed->save($t_feed)) {
                // $this->Flash->success(__('Your chat has been updated.'));
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
            // $this->Flash->success(__('The feed has been deleted.'));
            return $this->redirect(['action' => 'index']);
        }
    }

}