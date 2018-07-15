<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

class JobsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('');
    }
    public function index()
    {
        $users = $this->paginate($this->Jobs);
		$menu = ["menu"=>"cancelled_jobs","menu_type"=>"job"];
        $this->set(compact('users','menu'));
        $this->set('_serialize', ['users','menu']);
    }

    public function newPosts($id = null)
    {
        $newJobs = $this->Jobs->find('all')->toArray();
		$menu = ["menu"=>"newposted_jobs","menu_type"=>"job"];
		$this->set(compact('newJobs','menu'));
        $this->set('_serialize', ['newJobs','menu']);
    }

	public function jobYet($id = null)
    {
        $newJobs = $this->Jobs->find('all')->toArray();
		$menu = ["menu"=>"jobyet_jobs","menu_type"=>"job"];
		$this->set(compact('newJobs','menu'));
        $this->set('_serialize', ['newJobs','menu']);
    }

	public function pending($id = null)
    {
        $newJobs = $this->Jobs->find('all')->toArray();
		$menu = ["menu"=>"pending_jobs","menu_type"=>"job"];
		$this->set(compact('newJobs','menu'));
        $this->set('_serialize', ['newJobs','menu']);
    }

	public function compaleted($id = null)
    {
        $newJobs = $this->Jobs->find('all')->toArray();
		$menu = ["menu"=>"compaleted_jobs","menu_type"=>"job"];
		$this->set(compact('newJobs','menu'));
        $this->set('_serialize', ['newJobs','menu']);
    }

	public function cancelled($id = null)
    {
        $newJobs = $this->Jobs->find('all')->toArray();
		$menu = ["menu"=>"cancelled_jobs","menu_type"=>"job"];
		$this->set(compact('newJobs','menu'));
        $this->set('_serialize', ['newJobs','menu']);
    }
}
