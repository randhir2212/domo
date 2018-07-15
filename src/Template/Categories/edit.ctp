<div class="row clearfix">
    <div class="col s12 m6 l9">
        <h3 style="margin-top:0px;"><?= __('Edit Heading') ?></h3>
    </div>
</div>
<div class="row">
    <form class="col s12" method="POST" action="<?php echo $this->Url->build(array('controller'=>'Headings','action'=>'edit',$category->id)); ?>"  enctype="multipart/form-data">


      <div class="row">
        <div class="input-field col s12">
          <input id="heading" name="heading" type="text" class="validate" value="<?php echo $category->heading;?>" required>
          <label for="heading">Heading</label>
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
