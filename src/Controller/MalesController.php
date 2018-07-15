<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class MalesController extends AppController
{
    public $paginate = [
        'limit' => 20,
        'order' => [
            'Males.id' => 'asc'
        ]
    ];
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('');
        $this->loadComponent('Paginator');
    }

	public function index()
    {

		$typesTable = TableRegistry::get('Types');
		$items = $typesTable->find('all')->where(['dress_type'=>2])->toArray();
        //$items = $this->paginate($types);
		$this->set(compact('items'));
        $this->set('_serialize', ['items']);
    }

    public function add($typeId = null)
    {
        $items = $this->Males->newEntity();
		$typesTable = TableRegistry::get('Types');
		$types = $typesTable->find('all')->where(['dress_type'=>2,'id'=>$typeId])->first();
		if(!$types){
			return $this->redirect(['action' => 'image_list',$typeId]);
		}
        if ($this->request->is('post')) {
            $data = $this->request->data;
			if(isset($data['icon'])){
				if(count($data['icon'])>0){
					foreach ($data['icon'] as $key => $value) {
						if($value['name']){
							$data2= [];
							$data1 = explode('-',$value['name']);
							if($data1>1){
								$data1 = $data1[0];
								$data2['body_type'] = $data1;
								$data2['type_id'] = $types->id;
								$data2['icon'] = $this->__upload_file($value,'item_image');
								$items = $this->Males->newEntity();
								$items = $this->Males->patchEntity($items,$data2);
								if ($this->Males->save($items)) {
									$this->Flash->success(__($value['name'].' image has been saved.'));
									//return $this->redirect(['action' => 'index']);
								} else {
									$this->Flash->error(__($value['name'].'The image could not be saved. Please, try again.'));
								}
							}else{
								$this->Flash->error(__('Problem in '.$value['name'].' image name.'));
							}
						}else{
							$this->Flash->error(__('Problem in '.$value['name'].' image name.'));
						}
					}
				}else{
					$this->Flash->error(__('Please upload file.'));
				}
			}else{
				$this->Flash->error(__('Please upload file.'));
			}
        }
		$this->set(compact('types'));
        $this->set('_serialize', ['types']);
    }

    public function delete($id = null,$typeId = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Males->get($id);
		if(!empty($category->icon)){
            $url = WWW_ROOT."img".DS."item_image".DS.$category->icon;
            if (file_exists($url)) {
                unlink($url);
            }
        }
        if ($this->Males->delete($category)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.3'));
        }
        return $this->redirect(['action' => 'image_list',$typeId]);
    }

	public function imageList($typeId=0){
		if($typeId){
			$typesTable = TableRegistry::get('Types');
			$types = $typesTable->find('all')->where(['id'=>$typeId])->first();
			if(!$types){
				return $this->redirect(['action' => 'index']);
			}
			$query = $this->Males->find('all')->where(['type_id'=>$typeId]);
	        $items = $this->paginate($query);
			$this->set(compact('items','types'));
	        $this->set('_serialize', ['items','types']);
		}else{
			return $this->redirect(['action' => 'index']);
		}
	}
}
