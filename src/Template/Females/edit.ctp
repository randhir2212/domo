<div class="row clearfix">
    <div class="col s12 m6 l9">
        <h3 style="margin-top:0px;"><?= __('Edit Item') ?></h3>
    </div>
</div>
<div class="row">
    <form class="col s12" method="POST" action="<?php echo $this->Url->build(array('controller'=>'Items','action'=>'edit',$type,$category->id)); ?>"  enctype="multipart/form-data">
      <input type="hidden" name="heading_id" id="heading_id" value="<?php echo $category->heading_id;?>" />
      <input type="hidden" name="subheading_id" id="subheading_id" value="<?php echo $category->subheading_id;?>" />
	  <div class="row">
        <div class="input-field col s12">
          <input id="locked" name="locked" type="text" class="validate" value="<?php echo $category->locked;?>" required>
          <label for="locked">Locked</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="name" name="name" type="text" class="validate" value="<?php echo $category->name;?>" required>
          <label for="name">Name</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12 text-center">
            <button onClick="window.history.back();" type="reset" class="btn waves-effect waves-light">Cancel</button>
            <button type="submit"
                class="btn waves-effect waves-light light-blue darken-2">
                Update
            </button>
        </div>
      </div>
    </form>
  </div>
