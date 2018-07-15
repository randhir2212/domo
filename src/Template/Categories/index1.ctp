
<div class="row clearfix">
    <div class="col s12 m6 l9">
        <h3 style="margin-top:0px;"><?= __('Categories Listing') ?></h3>
    </div>
    <div class="fixed-action-btn horizontal">
    <!-- <a href="< ?php echo $this->Url->build(array('controller'=>'Headings','action'=>'add')); ?>" class="btn-floating btn-large red">
      <i class="large material-icons">add</i>
    </a> -->
  </div>
</div>
<div class="row clearfix">
  <ol class="breadcrumb">
    <li class="active">Categories</li>
  </ol>
</div>
<div class="clearfix" >
	<?php
		if(count($categoryList)>0){
			foreach ($categoryList as $key1 => $value1) {?>

				<div class="row">
					<div class="">
						<?php echo $value1->name; ?>
					</div>
				</div>
				<?php if(count($value1['children'])>0){
					foreach ($value1['children'] as $key2 => $value2) {?>
						<div class="row">
							<div class="col-md-offset-1">
								<?php echo $value2->name; ?>
							</div>
						</div>
						<?php //echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; # ".$value2->name.'</br>';
						if(count($value2['children'])>0){
							foreach ($value2['children'] as $key3 => $value3) { ?>
								<div class="row">
									<div class="col-md-offset-2">
										<?php echo $value3->name; ?>
									</div>
								</div>
								<?php //echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @ ".$value3->name.'</br>';
								if(count($value3['children'])>0){
									foreach ($value3['children'] as $key4 => $value4) {?>
										<div class="col-md-offset-3">
											<?php echo $value4->name; ?>
										</div>
									<?php
										if(count($value4['children'])>0){
											foreach ($value4['children'] as $key4 => $value5) {?>
												<div class="col-md-offset-4">
													<?php echo $value5->name; ?>
												</div>
												<?php
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}else{

		}
	 ?>
	<?php //pr($categoryList); ?>

</div>
