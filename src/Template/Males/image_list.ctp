
<div class="row clearfix">
    <div class="col s12 m6 l9">
        <h3 style="margin-top:0px;"><?= __('Males') ?></h3>
    </div>
    <div class="fixed-action-btn horizontal">
    <a href="<?php echo $this->Url->build(array('action'=>'add',$types->id)); ?>" class="btn-floating btn-large red">
      <i class="large material-icons">add</i>Add
    </a>
  </div>
</div>
<div class="row clearfix">
  <ol class="breadcrumb">
	<li class=""><a href="<?php echo $this->Url->build(array('action'=>'index')); ?>">Males</a></li>
	<li class="active"><?= $types->name ?></li>
  </ol>
</div>
<div class="clearfix" >
    <table class="table table-striped">
        <tr>
          <th scope="col">S. No.</th>
          <th scope="col">Body Type</th>
          <th scope="col">Image Name</th>
          <th scope="col">Icon</th>
          <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php
        if(count($items)>0){
          $i = 1;
          foreach ($items as $item): ?>
          <tr>
              <td><?= $i ?></td>
              <td><?= $item->body_type ?></td>
              <td><?php
			  		echo explode('_',$item->icon)[0];
			  ?></td>
              <td><img src="<?php echo $this->Url->build('/img/item_image/');?><?= h($item->icon) ?>" style="width:150px;height:150px;"></td>
              <td class="actions">
                  <?= $this->Form->postLink(__('Delete'), ['action' => 'delete',$item->id,$types->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id)]) ?>
              </td>
          </tr>
          <?php $i++; ?>
          <?php endforeach;
        }else{ ?>
          <td colspan="4" class="text-center"><span class="text-danger">No record found</span></td>

        <?php
        }
        ?>
    </table>
	<div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
