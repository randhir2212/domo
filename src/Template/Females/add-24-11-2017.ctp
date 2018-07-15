<div class="row clearfix">
    <div class="col s12 m6 l9">
        <h3 style="margin-top:0px;"><?= __('Add Female') ?></h3>
    </div>
</div>
<div class="row">
    <form class="col s12" method="POST" action="<?php echo $this->Url->build(array('controller'=>'Females','action'=>'add')); ?>"  enctype="multipart/form-data">
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
	  <div class="row">
		  <label class="btn btn-default btn-file">
		      Upload Image<input type="file" multiple=true style="display: none;" id="icon" name="icon[]" onchange="PreviewImage('icon');">
		  </label>
		  <img id="Preview_icon" name="icon" src="<?php echo $this->Url->build('/img/item_image/images.png');?>" style="height:80px;width:80px;" />
      </div>
	  <div class="row">
		  <small class="text-danger">Please upload image in format : bodytype skincolor eyecolor - imageNo.  e.g : HGDKGH-001.jpg</small>
      </div>
      <div class="row">
        <div class="input-field col s12 text-center">
            <button onClick="window.history.back();" type="reset" class="btn waves-effect waves-light">Cancel</button>
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
