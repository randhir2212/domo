
<div class="row clearfix">
    <div class="col s12 m6 l9">
        <h3 style="margin-top:0px;"><?= __('Females') ?></h3>
    </div>
</div>
<div class="row clearfix">
  <ol class="breadcrumb">
	<li class="active">Females </li>
  </ol>
</div>
<div class="clearfix" >
    <table class="table table-striped">
        <tr>
          <th scope="col">S. No.</th>
		  <th scope="col">Type</th>
		  <th scope="col">View Images</th>
          <!-- <th scope="col" class="actions">< ?= __('Actions') ?></th> -->
        </tr>
        <?php
        if(count($items)>0){
          $i = 1;

          foreach ($items as $item): ?>
          <tr>
              <td><?= $i ?></td>
              <td><?= $item->name ?></td>
			  <td>
				<?= $this->Html->link(__('List'), ['action' => 'imageList',$item->id]) ?>
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
</div>
