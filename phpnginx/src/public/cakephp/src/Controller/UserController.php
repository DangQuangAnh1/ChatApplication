<?php

namespace App\Controller;

class UserController extends AppController
{
    public function initialize(): void
    {
        // delete session
        $session = $this->getRequest()->getSession();
        $session->delete('email');
        $session->delete('name');
        $session->delete('user_id');
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');
        $this->loadModel('T_user');
    }
    public function login()
    {
        // Object Initialization 
        $t_user = $this->T_user->newEmptyEntity();
        if ($this->request->is(['post', 'put'])) {
            $this->T_user->patchEntity($t_user, $this->request->getData());
            // Check email format
            if (!filter_var($t_user->email, FILTER_VALIDATE_EMAIL)) {
                $this->Flash->success(__('Invalid email format.'));
                return $this->redirect(['action' => 'login']);
            } else {
                // check user
                $check_user = $this->T_user->find();
                foreach ($check_user as $t) :
                    if ($t->email == $t_user->email && $t->password == $t_user->password) {
                        $this->Flash->success(__('Login Successfull.'));
                        $session = $this->getRequest()->getSession();
                        $session->write('user_id', $t->user_id);
                        $session->write('email', $t->email);
                        $session->write('name', $t->name);
                        return $this->redirect(['controller' => 'chat', 'action' => 'index']);
                        break;
                    }
                endforeach;
                // login failed notification
                $this->Flash->error(__('Incorrect email or password.'));
                return $this->redirect(['action' => 'login']);
            }
        }
    }
    public function regist()
    {
        $t_user = $this->T_user->newEmptyEntity();
        if ($this->request->is('post')) {
            $t_user = $this->T_user->patchEntity($t_user, $this->request->getData());
            // check email format
            if (!filter_var($t_user->email, FILTER_VALIDATE_EMAIL)) {
                $this->Flash->success(__('Invalid email format.'));
                return $this->redirect(['action' => 'regist']);
            } else {
                // Check email duplicates
                $check_user = $this->T_user->find();
                $is_checked = true;
                foreach ($check_user as $t) :
                    if ($t->email == $t_user->email) {
                        $this->Flash->success(__('Email has been registered before.'));
                        return $this->redirect(['action' => 'regist']);
                        $is_checked = false;
                        break;
                    }
                endforeach;
                if ($is_checked == true) {
                    if ($this->T_user->save($t_user)) {
                        $this->Flash->success(__('Regist successfull.'));
                        return $this->redirect(['action' => 'login']);
                    }
                    $this->Flash->error(__('Unable to regist.'));
                }
            }
        }
        $this->set('t_user', $t_user);
    }
    public function logout()
    {
    }
}
