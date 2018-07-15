<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\I18n\Time;

class FemalesController extends AppController
{
    public $paginate = [
        'limit' => 20,
        'order' => [
            'Females.id' => 'desc'
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
		$items = $typesTable->find('all')->where(['dress_type'=>1])->toArray();
        //$items = $this->paginate($types);
		$this->set(compact('items'));
        $this->set('_serialize', ['items']);
    }

	public function add($type = 0)
    {
        $items = $this->Females->newEntity();
		if($type){
			$typesTable = TableRegistry::get('Types');
			$types = $typesTable->find('all')->where(['dress_type'=>1,'id'=>$type])->first();
			if(!$types){
				return $this->redirect(['action' => 'image_list',$type]);
			}
		}else{
			// $typesTable = TableRegistry::get('Types');
			// $types = $typesTable->find('all')->where(['dress_type'=>1])->toArray();
			return $this->redirect(['action' => 'image_list',$type]);
		}
        if ($this->request->is('post')) {
            $data = $this->request->data;
			if(isset($data['skin_color']) && isset($data['eye_color'])){
				if(isset($data['icon'])){
					if($data['icon']['name']){
						if($type){
							$typeId = $type;
						}else{
							$typeId = $data['type_id'];
						}
						$nowDate = Time::now();
						if($typeId == 1){
							$data1 = explode('-',$data['icon']['name']);
							if($data1>1){
								$data1 = $data1[0];
								if(strlen($data1) == 2){
									$iconImage = $this->__upload_file($data['icon'],'item_image');
									foreach ($data['skin_color'] as $key1 => $value1) {
										foreach ($data['eye_color'] as $key2 => $value2) {
											$data2= [];
											$data2['skin_color'] = $value1;
											$data2['eye_color'] = $value2;
											$data2['body_type'] = $data1[0].$data1[1];
											$data2['type_id'] = $typeId;
											$data2['icon'] = $iconImage;
											$data2['created'] = $nowDate;
											$data2['modified'] = $nowDate;
											$items = $this->Females->newEntity();
											$items = $this->Females->patchEntity($items,$data2);
											if ($this->Females->save($items)) {
												//$this->Flash->success(__($data['icon']['name'].' image has been saved.'));
											} else {
												//$this->Flash->error(__($data['icon']['name'].'The image could not be saved. Please, try again.'));
											}
										}
									}
									$this->Flash->success(__($data['icon']['name'].' image has been saved.'));
								}else{
									$this->Flash->error(__('Problem in '.$data['icon']['name'].' image name.'));
								}
							}else{
								$this->Flash->error(__('Problem in '.$data['icon']['name'].' image name.'));
							}
						}else{
							if(isset($data['body_type'])){
								$iconImage = $this->__upload_file($data['icon'],'item_image');
								$countUpload = 0;
								$countError = 0;
								foreach ($data['body_type'] as $key => $value) {
									foreach ($data['skin_color'] as $key1 => $value1) {
										foreach ($data['eye_color'] as $key2 => $value2) {
											$data2= [];
											$data2['skin_color'] = $value1;
											$data2['eye_color'] = $value2;
											$data2['body_type'] = $value;
											$data2['type_id'] = $typeId;
											$data2['icon'] = $iconImage;
											$data2['created'] = $nowDate;
											$data2['modified'] = $nowDate;
											$items = $this->Females->newEntity();
											$items = $this->Females->patchEntity($items,$data2);
											if ($this->Females->save($items)) {
												$countUpload++;
											} else {
												$countError++;
											}
										}
									}
								}
								$this->Flash->success(__($data['icon']['name'].' image has been saved.'));
								//$this->Flash->error(__($data['icon']['name'].' count = '.$countError));
							}else{
								$this->Flash->error(__('Please select atleast one body type.'));
							}
						}
					}else{
						$this->Flash->error(__('Problem in '.$value['name'].' image name.'));
					}
					return $this->redirect(['action' => 'add',$type]);
				}else{
					$this->Flash->error(__('Please upload file.'));
				}
			}else{
				$this->Flash->error(__('Please select atleast one skin color and eye color.'));
			}
        }
		$this->set(compact('types'));
		$this->set(compact('type'));
        $this->set('_serialize', ['types','type']);
    }

    public function delete($id = null,$type =null)
    {
		if($id){
			$url = WWW_ROOT."img".DS."item_image".DS.$id;
            if (file_exists($url)) {
                unlink($url);
            }
			if ($this->Females->deleteAll(['Females.icon ' => $id])) {
	            $this->Flash->success(__('The item has been deleted.'));
	        } else {
	            $this->Flash->error(__('The item could not be deleted. Please, try again'));
	        }
		}else{
			$this->Flash->error(__('The item could not be deleted. Please, try again'));
		}

        return $this->redirect(['action' => 'image_list',$type]);
    }

	public function imageList($typeId=0){
		if($typeId){
			$typesTable = TableRegistry::get('Types');
			$types = $typesTable->find('all')->where(['id'=>$typeId])->first();
			if(!$types){
				return $this->redirect(['action' => 'index']);
			}
			$query = $this->Females->find('all')->where(['type_id'=>$typeId])->group('icon');
	        $items = $this->paginate($query);
			$this->set(compact('items','types'));
	        $this->set('_serialize', ['items','types']);
		}else{
			return $this->redirect(['action' => 'index']);
		}
	}

	public function viewImages($typeId=null ,$id = null){
		if($typeId && $id){
			$items = [];
			$typesTable = TableRegistry::get('Types');
			$types = $typesTable->find('all')->where(['id'=>$typeId])->first();
			$items = $this->Females->find('all')->where(['id'=>$id])->first();
			$tempItems = $this->Females->find('all')->where(['icon'=>$items->icon])->toArray();

			$result = (object) array('body_type' => [],'skin_color'=>[],'eye_color'=>[]);
			foreach ($tempItems as $key => $value) {
				if($value->body_type){
					$result->body_type[strtolower($value->body_type)] = true;
				}
				if($value->skin_color){
					$result->skin_color[strtolower($value->skin_color)] = true;
				}

				if($value->eye_color){
					$result->eye_color[strtolower($value->eye_color)] = true;
				}
			}
			$type = $types->id;

			$this->set(compact('types','result','type','items'));
	        $this->set('_serialize', ['types','result','type','items']);
		}else{
			return $this->redirect(['action' => 'imageList',$typeId]);
		}
	}

	public function edit ($typeId=null,$tempId=null){
		if ($this->request->is('post')) {
            $data = $this->request->data;
			if($typeId == 1){
				if(isset($data['skin_color']) && isset($data['eye_color'])){
					$items = $this->Females->find('all')->where(['id'=>$tempId])->first();
					if($items){
						if($this->Females->deleteAll(['Females.icon ' => $items->icon])){
							foreach ($data['skin_color'] as $key1 => $value1) {
								foreach ($data['eye_color'] as $key2 => $value2) {
									$data2= [];
									$data2['skin_color'] = $value1;
									$data2['eye_color'] = $value2;
									$data2['body_type'] = $items->body_type;
									$data2['type_id'] = $typeId;
									$data2['icon'] = $items->icon;
									$data2['created'] = $items->created;
									$data2['modified'] = $items->modified;
									$items = $this->Females->newEntity();
									$items = $this->Females->patchEntity($items,$data2);
									$saveData = $this->Females->save($items);
									$tempId = $saveData->id;
								}
							}
							$this->Flash->success(__('Updated Successfully.'));
						}else{
							$this->Flash->error(__('Problem in delete.'));
						}
					}else{
						$this->Flash->error(__('Problem in update, please try again later.'));
					}
				}else{
					$this->Flash->error(__('Please select atleast one skin color and eye color.'));
				}
			}else{
				if(isset($data['body_type']) && isset($data['skin_color']) && isset($data['eye_color'])){
					$countUpload = 0;
					$countError = 0;
					$items = $this->Females->find('all')->where(['id'=>$tempId])->first();
					if($items){
						if($this->Females->deleteAll(['Females.icon ' =>$items->icon])){
							foreach ($data['body_type'] as $key => $value) {
								foreach ($data['skin_color'] as $key1 => $value1) {
									foreach ($data['eye_color'] as $key2 => $value2) {
										$data2= [];
										$data2['skin_color'] = $value1;
										$data2['eye_color'] = $value2;
										$data2['body_type'] = $value;
										$data2['type_id'] = $typeId;
										$data2['icon'] = $items->icon;
										$data2['created'] = $items->created;
										$data2['modified'] = $items->modified;
										$items = $this->Females->newEntity();
										$items = $this->Females->patchEntity($items,$data2);
										$saveData = $this->Females->save($items);
										$tempId = $saveData->id;
									}
								}
							}
							$this->Flash->success(__('Updated Successfully.'));
							//$this->Flash->error(__($data['icon']['name'].' count = '.$countError));
						}else{
							$this->Flash->error(__('Problem in delete.'));
						}
					}else{
						$this->Flash->error(__('Problem in update, please try again later.'));
					}
				}else{
					$this->Flash->error(__('Please select atleast one body type , skin color and eye color .'));
				}
			}
        }
		return $this->redirect(['action' => 'viewImages',$typeId,$tempId]);
	}
}
