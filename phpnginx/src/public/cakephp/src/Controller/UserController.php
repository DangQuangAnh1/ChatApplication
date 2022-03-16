<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Null_;

class UserController extends AppController
{   
    public function initialize(): void
    {   
        $session = $this->getRequest()->getSession();
        $session->delete('email');
        $session->delete('name');
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
        $this->loadModel('T_user');
    }
    public function login()
    {
        $t_user = $this->T_user->newEmptyEntity();
        if ($this->request->is(['post', 'put'])) {
            $this->T_user->patchEntity($t_user, $this->request->getData());
            if (!filter_var($t_user->email, FILTER_VALIDATE_EMAIL)){
                $this->Flash->success(__('Invalid email format.'));
                return $this->redirect(['action' => 'login']);
            }
            else{
                $t_user_2 = $this->T_user->find();
                $check=0;
                foreach ($t_user_2 as $t):
                    if($t->email==$t_user->email && $t->password==$t_user->password){
                        $this->Flash->success(__('Login Successfull.'));
                        $session = $this->getRequest()->getSession();
                        $session->write('email', $t->email);
                        $session->write('name', $t->name);
                        return $this->redirect(['controller'=>'chat','action' => 'index']);
                        $check=1;
                        break;
                    }
                endforeach;
                if($check==0){
                        $this->Flash->success(__('Incorrect email or password.'));
                        return $this->redirect(['action' => 'login']);
                }
            }   
        }
    }
    public function regist()
    {
        $t_user = $this->T_user->newEmptyEntity();
        if ($this->request->is('post')) {
            $t_user = $this->T_user->patchEntity($t_user, $this->request->getData());
            if (!filter_var($t_user->email, FILTER_VALIDATE_EMAIL)){
                $this->Flash->success(__('Invalid email format.'));
                return $this->redirect(['action' => 'regist']);
            }
            else{
                $t_user_2 = $this->T_user->find();
                $check=0;
                foreach ($t_user_2 as $t):
                    if($t->email==$t_user->email){
                        $this->Flash->success(__('Email has been registered before.'));
                        return $this->redirect(['action' => 'regist']);
                        $check=1;
                        break;
                    }
                endforeach;
                if($check==0){
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