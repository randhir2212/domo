<script src="<?= $this->Url->build('/',TRUE); ?>bower_components/angular/angular.min.js" type="text/javascript"></script>
<div class="row clearfix">
    <div class="col s12 m6 l9">
        <h3 style="margin-top:0px;"><?= __('Categories') ?></h3>
    </div>
    <div class="fixed-action-btn horizontal">
    <!-- <a href="< ?php echo $this->Url->build(array('controller'=>'Headings','action'=>'add')); ?>" class="btn-floating btn-large red">
      <i class="large material-icons">add</i>
    </a> -->
  </div>
</div>
<div class="row clearfix">
  <ol class="breadcrumb">
    <li class="active">Categories Listing</li>
  </ol>
</div>
<div class="clearfix" ng-app="categoryApp" ng-controller="categoryCtrl">
	<div ng-if="pages.addPage">
		add
	</div>
	<div ng-if="pages.indexPage">
		index
	</div>
	<div ng-if="pages.editPage">
		edit
	</div>
	<div class="fixed-action-btn horizontal" ng-if="pages.indexPage">
		<a href="javascript:void(0);" ng-click="openAddPage();" class="btn-floating btn-large red">
	      <i class="large material-icons">add</i>
	    </a>
	</div>
</div>

<script>
	var categoryApp = angular.module('categoryApp', []);
	categoryApp.controller('categoryCtrl', function($scope,categoryService) {
		console.log('ok');
	    $scope.pages={
			addPage:false,
			indexPage:true,
			editPage:false
		};
		$scope.categoryList = categoryService.getCategoryList();

		$scope.openAddPage = function(){
			$scope.pages={
				addPage:true,
				indexPage:false,
				editPage:false
			};
		};
	});
	categoryApp.service('categoryService', function($http) {
		var url = "http://localhost/DressUp/categories";
	    this.getCategoryList = function () {
	        //return x.toString(16);
			$http.get(url+'/getCategoryList.json').then(function(res){
				console.log(res);
			}).catch(function(err){
				console.log(err);
			});
	    }
	});
</script>
