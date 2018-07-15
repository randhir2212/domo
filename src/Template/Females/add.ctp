<div class="row clearfix">
    <div class="col s12 m6 l9">
        <h3 style="margin-top:0px;"><?= __('Add Female') ?></h3>
    </div>
</div>
<div class="row clearfix">
  <ol class="breadcrumb">
	<li class=""><a href="<?php echo $this->Url->build(array('action'=>'index')); ?>">Females</a></li>
	<?php if($type){ ?>
		<li class="active"><a href="<?php echo $this->Url->build(array('action'=>'image-list',$type)); ?>"><?= $types->name ?></a></li>
	<?php } ?>
  </ol>
</div>
<div class="row">
    <form class="col s12" method="POST" action="<?php echo $this->Url->build(array('controller'=>'Females','action'=>'add',$type)); ?>"  enctype="multipart/form-data">
		<?php if(!$type){ ?>
			<div class="row">
	        <div class="input-field col s12">
	          <select class="browser-default" id="type_id" name="type_id" required>
	            <option value="">Choose your option</option>
	            <?php foreach($types as $user) {
	              ?>
	              <option value="<?php echo $user['id'];?>"><?php echo $user['name'];?></option>
	            <?php } ?>

	          </select>
	          <label for="heading_id" class="active">Users</label>
	        </div>
	      </div>
	  <?php } ?>
	  	<div class="row">
			<?php if($type!=1){ ?>
				<div class="col-sm-4">
	  			  	Body Type
	  		  	</div>
			<?php } ?>

		  <div class="col-sm-4">
			  Skin Color
		  </div>
		  <div class="col-sm-4">
			  Eye Color
		  </div>
	  	</div>
	  	<div class="row">
			<?php if($type!=1){ ?>
				<div class="col-sm-4">
				  	<input type="checkbox" id="body_type[ap]" checked name="body_type[ap]" value="AP" />
	        		<label for="body_type[ap]">AP</label>
			  	</div>
			<?php } ?>

		  	<div class="col-sm-4">
			  	<input type="checkbox" id="skin_color[dk]" checked name="skin_color[dk]" value="DK" />
        		<label for="skin_color[dk]">DK</label>
		  	</div>
			<div class="col-sm-4">
			  	<input type="checkbox" id="eye_color[bg]" checked name="eye_color[bg]" value="BG" />
        		<label for="eye_color[bg]">BG</label>
		  	</div>
	  	</div>
		<div class="row">
			<?php if($type!=1){ ?>
				<div class="col-sm-4">
				  	<input type="checkbox" id="body_type[dn]" checked name="body_type[dn]" value="DN" />
	        		<label for="body_type[dn]">DN</label>
			  	</div>
			<?php } ?>

		  	<div class="col-sm-4">
			  	<input type="checkbox" id="skin_color[ol]" checked name="skin_color[ol]" value="OL" />
        		<label for="skin_color[ol]">OL</label>
		  	</div>
			<div class="col-sm-4">
			  	<input type="checkbox" id="eye_color[bk]" checked name="eye_color[bk]" value="BK" />
        		<label for="eye_color[bk]">BK</label>
		  	</div>
	  	</div>
		<div class="row">
			<?php if($type!=1){ ?>
				<div class="col-sm-4">
				  	<input type="checkbox" id="body_type[bs]" checked name="body_type[bs]" value="BS" />
	        		<label for="body_type[bs]">BS</label>
			  	</div>
			<?php } ?>

		  	<div class="col-sm-4">
			  	<input type="checkbox" id="skin_color[tn]" checked name="skin_color[tn]" value="TN" />
        		<label for="skin_color[tn]">TN</label>
		  	</div>
			<div class="col-sm-4">
			  	<input type="checkbox" id="eye_color[br]" checked name="eye_color[br]" value="BR" />
        		<label for="eye_color[br]">BR</label>
		  	</div>
	  	</div>
		<div class="row">
			<?php if($type!=1){ ?>
				<div class="col-sm-4">
				  	<input type="checkbox" id="body_type[hg]" checked name="body_type[hg]" value="HG" />
	        		<label for="body_type[hg]">HG</label>
			  	</div>
			<?php } ?>
		  	<div class="col-sm-4">
			  	<input type="checkbox" id="skin_color[wh]" checked name="skin_color[wh]" value="WH" />
        		<label for="skin_color[wh]">WH</label>
		  	</div>
			<div class="col-sm-4">
			  	<input type="checkbox" id="eye_color[gh]" checked name="eye_color[gh]" value="GH" />
        		<label for="eye_color[gh]">GH</label>
		  	</div>
	  	</div>
		<?php if($type!=1){ ?>
			<div class="row">
				<div class="col-sm-4">
				  	<input type="checkbox" id="body_type[pr]" checked name="body_type[pr]" value="PR" />
	        		<label for="body_type[pr]">PR</label>
			  	</div>
		  	</div>
		<?php } ?>


	  <div class="row">
		  <label class="btn btn-default btn-file">
		      Upload Image<input type="file" accept="image/*" style="display: none;" id="icon" name="icon" onchange="PreviewImage('icon');">
		  </label>
		  <img id="Preview_icon" name="icon" src="<?php echo $this->Url->build('/img/item_image/images.png');?>" style="height:80px;width:80px;" />
      </div>
	  <div class="row">
		  <small class="text-danger">Please upload image in format : bodytype - imageNo.  e.g : HG-001.png</small>
      </div>
      <div class="row">
        <div class="input-field col s12 text-center">
            <a href="<?php echo $this->Url->build(array('action'=>'image-list',$type)); ?>"  type="reset" class="btn waves-effect waves-light">Cancel</a>
            <button type="submit"
                class="btn waves-effect waves-light light-blue darken-2">
                Submit
            </button>
        </div>
      </div>
    </form>
  </div>

  <script type="text/javascript">
    function PreviewImage(no) {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById(no).files[0]);
		var fileUpload = $("#"+no)[0];
		var isValid = true;
        //Check whether the file is valid Image.
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
        if (regex.test(fileUpload.value.toLowerCase())) {
            //Check whether HTML5 is supported.
            if (typeof (fileUpload.files) != "undefined") {
                //Initiate the FileReader object.
                var reader = new FileReader();
                //Read the contents of Image File.
                reader.readAsDataURL(fileUpload.files[0]);
                reader.onload = function (e) {
                    //Initiate the JavaScript Image object.
                    var image = new Image();
                    //Set the Base64 string return from FileReader as source.
                    image.src = e.target.result;
                    image.onload = function () {

                    };
                }
            } else {
                alert("This browser does not support HTML5.");
                return false;
            }
        } else {
            alert("Please select a valid Image file.");
            return false;
        }

		oFReader.onload = function (oFREvent) {
			setTimeout(function(){
				if(isValid){
					document.getElementById("Preview_"+no).src = oFREvent.target.result;
				}
			},500);
		};
    }

</script>
