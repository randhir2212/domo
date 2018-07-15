<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class CategoriesController extends AppController
{

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['']);
    }

	public function index(){

	}

	public function getCategoryList(){
		$error_code = "SUCCESS";
		$error_message = "SUCCESS";
        $result=[];
		$data = $this->Categories->find('all')->toArray();
		$categoryList = $this->buildTree($data, 0);
        $this->set(["error_code"=>$error_code,
                    "error_message"=>$error_message,
                    "results"=>$categoryList,
                    '_serialize' => ['error_code','error_message','results']
                ]);
	}

    public function buildTree($elements, $parentId = 0) {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['category_id'] == $parentId) {
              if($element['category_id'] != $element['id']){
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
                unset($elements[$element['id']]);
              }
            }
        }
        return $branch;
    }

    public function getForProduct(){
      $error_code = "FAIL";
      $error_message = "Fail";
      $result = [];

      $data['id'] = $this->Auth->user('id');
      $Catogory = $this->Categories->getProductCategoryList($data);
      foreach($Catogory as $val){
        if($val['id'] == $val['category_id']){
          $val['children'] = $this->buildTree($Catogory, $val['id']);
          $results[] = $val;
        }
      }
      $error_code = "SUCCESS";
      $error_message = "categories list.";
      $this->set(["error_code"=>$error_code,
                  "error_message"=>$error_message,
                  "results"=>$results,
                  '_serialize' => ['error_code','error_message','results']
              ]);
    }

    public function getForProductForEdit(){
      $error_code = "FAIL";
      $error_message = "Fail";
      $results = [];
      if($this->request->is('POST')){
        $data = $this->request->data;
        $Catogory = $this->Categories->getProductCategoryList('');
        $result = [];
        if(!empty($data['selectedCategory'])){
          foreach($Catogory as $k=>$v){
            foreach ($data['selectedCategory'] as $key => $value) {
              if($value['id'] == $v->id){
                $v['isExpanded']=true;
                $v['isActive']=true;
                $v['selected']=true;
                $result[$k] = $v;
              }else{
                $result[$k] = $v;
              }
            }
          }
        }else{
          $result = $Catogory;
        }
        foreach($result as $val){
          if($val['id'] == $val['category_id']){
            $val['children'] = $this->buildTree($Catogory, $val['id']);
            $results[] = $val;
          }
        }
        $error_code = "SUCCESS";
        $error_message = "categories list.";
      }

      $this->set(["error_code"=>$error_code,
                  "error_message"=>$error_message,
                  "results"=>$results,
                  '_serialize' => ['error_code','error_message','results']
              ]);
    }

    public function getProductCategoryList()
    {
      $error_code = "FAIL";
      $error_message = "Fail";
      $result = [];
        $data['id'] = $this->Auth->user('id');
        $Catogory = $this->Categories->getProductCategoryList($data);
        //$results = $this->buildTree($Catogory, 1);
        foreach($Catogory as $val){
          if($val['id'] == $val['category_id']){
            $val['parent'] = "#";
          }else{
            $val['parent'] = $val['category_id'];
          }
          $val['text'] = $val['name'];
        }
        $error_code = "SUCCESS";
        $error_message = "categories list.";
        $this->set(["error_code"=>$error_code,
                    "error_message"=>$error_message,
                    "results"=>$Catogory,
                    '_serialize' => ['error_code','error_message','results']
                ]);
    }

    public function getCategory(){
      $error_code = "FAIL";
      $error_message = "Fail";
      $result=[];
      if($this->request->is('POST')){
        $data = $this->request->data;
        $result = $this->Categories->get($data['category_id']);
        $error_code = "SUCCESS";
        $error_message = "SUCCESS";
      }
      $this->set(["error_code"=>$error_code,
                  "error_message"=>$error_message,
                  "results"=>$result,
                  '_serialize' => ['error_code','error_message','results']
              ]);
    }

    public function add(){
      $error_code = "FAIL";
      $error_message = "Fail";
      if($this->request->is('POST')){
        $data = $this->request->data;
        $category = $this->Categories->newEntity();
        $category->name = $data['name'];
        $category->description = $data['description'];
        $category->category_id = $data['category_id']['id'];
        if($this->Categories->save($category)){
          $error_code = "SUCCESS";
          $error_message = "Category add successfully.";
        }else{
          $error_message = "problem in category.";
        }
      }
      $this->set(["error_code"=>$error_code,
                  "error_message"=>$error_message,
                  '_serialize' => ['error_code','error_message']
              ]);
    }

    public function edit(){
      $error_code = "FAIL";
      $error_message = "Fail";
      if($this->request->is('POST')){
        $data = $this->request->data;
        $category = $this->Categories->get($data['id']);
        $category->name = $data['name'];
        $category->description = $data['description'];
        $category->category_id = $data['category_id']['id'];
        if($this->Categories->save($category)){
          $error_code = "SUCCESS";
          $error_message = "Category updated successfully.";
        }else{
          $error_message = "problem in category.";
        }
      }
      $this->set(["error_code"=>$error_code,
                  "error_message"=>$error_message,
                  '_serialize' => ['error_code','error_message']
              ]);
    }


    public function getCategoryListForDropdown($category_id)
    {
      $error_code = "FAIL";
      $error_message = "Fail";
      $results = [];
      $results = $this->Categories->getCategoryListForDropdown($category_id);
      //$results[] = $this->buildTree($result, 1);
      //$results[] = $this->buildTree($result, 2);
      $error_code = "SUCCESS";
      $error_message = "categories list.";
      $this->set(["error_code"=>$error_code,
                  "error_message"=>$error_message,
                  "results"=>$results,
                  '_serialize' => ['error_code','error_message','results']
              ]);
    }

    public function getCategoryDetails()
    {
      $error_code = "FAIL";
      $error_message = "Fail";
      $result = [];
      if($this->request->is('POST')){
          $data = $this->request->data;
          $data['id'] = $this->Auth->user('id');
          $result = $this->Categories->getCategoryDetails($data);
          $error_code = "SUCCESS";
          $error_message = "categories list.";
      }
      $this->set(["error_code"=>$error_code,
                  "error_message"=>$error_message,
                  "result"=>$result,
                  '_serialize' => ['error_code','error_message','result']
              ]);
    }


    public function saveCategory()
    {
      $error_code = "FAIL";
      $error_message = "Fail";
      if($this->request->is('POST')){
          $data = $this->request->data;
          if(!empty($data['id'])){
            $category = $this->Categories->updateCategory($data);
            if ($category) {
              $error_code = "SUCCESS";
              $error_message = "Category updated successfully.";
            }
          }else{
            $category = $this->Categories->newEntity();
            $category = $this->Categories->patchEntity($category,$data);
            if ($this->Categories->save($category)) {
              $error_code = "SUCCESS";
              $error_message = "Category added successfully.";
            }
          }
      }
      $this->set(["error_code"=>$error_code,
                  "error_message"=>$error_message,
                  '_serialize' => ['error_code','error_message']
              ]);
    }

    public function deleteCatogory()
    {
        $error_code = "FAIL";
        $error_message = "Fail";
        if($this->request->is('POST')){
            $data = $this->request->data;
            $category = $this->Categories->checkItIsParent($data['category_id']);
            if($category == 0){
              $entity = $this->Categories->get($data['category_id']);
              if($this->Categories->delete($entity)){
                $error_code = 'SUCCESS';
                $error_message = 'Category delete successfully.';
              }else {
                $error_code = 'FAIL';
                $error_message = 'Some Problem.';
              }
            }else{
              $error_code = 'FAIL';
              $error_message = 'This category is parent, please delete children.';
            }
        }
        $this->set(["error_code"=>$error_code,
                    "error_message"=>$error_message,
                    '_serialize' => ['error_code','error_message']
                ]);
    }
}
