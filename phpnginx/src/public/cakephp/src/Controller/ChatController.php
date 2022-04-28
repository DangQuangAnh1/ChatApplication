<?php

namespace App\Controller;

use App\Model\Entity\T_feed;

class ChatController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');
        $this->loadModel('T_feed');
        $this->loadModel('T_user');
    }
    public function index()
    {
        $this->loadComponent('Paginator');
        // find all element in t_feed table
        $t_feed = $this->Paginator->paginate($this->T_feed->find()->order(['id' => 'DESC']));
        // find all element of chatted 
        $t_user = $this->Paginator->paginate($this->T_user->find()->join([
            'table' => 't_feed',
            'type' => 'RIGHT',
            'conditions' => 'T_user.user_id = t_feed.user_id',
        ])->group('T_user.user_id'));
        $this->set(compact('t_feed', 't_user'));
    }
    public function view($id = null)
    {
        // find the element to view
        $t_feed = $this->T_feed->findById($id)->firstOrFail();
        $this->set(compact('t_feed'));
    }
    public function add()
    {
        $t_feed = $this->T_feed->newEmptyEntity();
        if ($this->request->is('post')) {
            // read info in form
            $t_feed = $this->T_feed->patchEntity($t_feed, $this->request->getData());
            // take real-time
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            date_default_timezone_get();
            $current_time = date('Y-m-d H:i:s');
            $t_feed->create_at = $current_time;
            $t_feed->update_at = $current_time;
            // read session
            $session = $this->request->getSession();
            $t_feed->name = $session->read('name');
            $t_feed->user_id = $session->read('user_id');
            // read upload file
            if (!$t_feed->getErrors) {
                $attachment = $this->request->getData('Upload_file');
                if (!$attachment->getError()) {
                    $name = $attachment->getClientFilename();
                    $type = $attachment->getClientMediaType();
                    if ($type == "video/mp4" || $type == "video/ogg") {
                        $targetPath = WWW_ROOT . 'video' . DS . $name;
                    } else {
                        $targetPath = WWW_ROOT . 'img' . DS . $name;
                    }
                    if ($name) {
                        $attachment->moveTo($targetPath);
                        $t_feed->image_file_name = $name;
                    }
                }
            }
            // save to data base
            if ($this->T_feed->save($t_feed)) {
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your chat.'));
        }
        $this->set('t_feed', $t_feed);
    }
    public function edit($id)
    {
        // find the element to edit
        $t_feed = $this->T_feed
            ->findById($id)
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            // read info in form
            $this->T_feed->patchEntity($t_feed, $this->request->getData());
            // take real-time
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            date_default_timezone_get();
            $today = date('Y-m-d H:i:s');
            $t_feed->update_at = $today;
            // read upload file
            if (!$t_feed->getErrors) {
                $attachment = $this->request->getData('Upload_file');
                if (!$attachment->getError()) {
                    $name = $attachment->getClientFilename();
                    $type = $attachment->getClientMediaType();
                    if ($type == "video/mp4" || $type == "video/ogg") {
                        $targetPath = WWW_ROOT . 'video' . DS . $name;
                    } else if ($type == "image/jpeg" || $type == "image/png") {
                        $targetPath = WWW_ROOT . 'img' . DS . $name;
                    }
                    if ($name) {
                        $attachment->moveTo($targetPath);
                        $t_feed->image_file_name = $name;
                    }
                }
            }
            // save to database
            if ($this->T_feed->save($t_feed)) {
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your chat.'));
        }
        $this->set('t_feed', $t_feed);
    }
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        // find the element to delete
        $t_feed = $this->T_feed->findById($id)->firstOrFail();
        // delete
        if ($this->T_feed->delete($t_feed)) {
            return $this->redirect(['action' => 'index']);
        }
    }
}