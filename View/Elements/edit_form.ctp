<?php
/**
 * Element of Categories edit form
 *   - $categories:
 *       The results data of Category->getCategories(), and The formatter is camelized data.
 *   - $cancelUrl: Cancel url.
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->script('/categories/js/categories.js');

if (! isset($this->request->data['Categories'])) {
	$this->request->data['Categories'] = array();
}
if (! isset($this->request->data['CategoryMap'])) {
	$this->request->data['CategoryMap'] = array();
}
?>

<?php
	foreach ($this->request->data['CategoryMap'] as $category) {
		echo $this->NetCommonsForm->hidden('CategoryMap.' . $category['Category']['id'] . '.Category.id');
		echo $this->NetCommonsForm->hidden('CategoryMap.' . $category['Category']['id'] . '.Category.key');
		echo $this->NetCommonsForm->hidden('CategoryMap.' . $category['Category']['id'] . '.Category.language_id');
		echo $this->NetCommonsForm->hidden('CategoryMap.' . $category['Category']['id'] . '.CategoryOrder.id');
		echo $this->NetCommonsForm->hidden('CategoryMap.' . $category['Category']['id'] . '.CategoryOrder.key');
		echo $this->NetCommonsForm->hidden('CategoryMap.' . $category['Category']['id'] . '.CategoryOrder.category_key');
	}
	$categories = NetCommonsAppController::camelizeKeyRecursive($this->data['Categories']);
?>

<?php $this->NetCommonsForm->unlockField('Categories'); ?>

<div class="panel panel-default" ng-controller="Categories" ng-init="initialize(<?php echo h(json_encode(['categories' => $categories])); ?>)">
	<div class="panel-heading">
		<?php echo __d('categories', 'Category'); ?>
	</div>

	<div class="panel-body">
		<div class="form-group clearfix">
			<div class="pull-left">
				<?php echo $this->NetCommonsForm->error('category_name'); ?>
			</div>

			<div class="pull-right">
				<button type="button" class="btn btn-success btn-sm" ng-click="add()">
					<span class="glyphicon glyphicon-plus"> </span>
				</button>
			</div>
		</div>

		<div ng-hide="categories.length">
			<p><?php echo __d('categories', 'No category.'); ?></p>
		</div>

		<div class="pre-scrollable" ng-show="categories.length">
			<article class="form-group" ng-repeat="c in categories track by $index">
				<div class="input-group input-group-sm">
					<div class="input-group-btn">
						<button type="button" class="btn btn-default"
								ng-click="move('up', $index)" ng-disabled="$first">
							<span class="glyphicon glyphicon-arrow-up"></span>
						</button>

						<button type="button" class="btn btn-default"
								ng-click="move('down', $index)" ng-disabled="$last">
							<span class="glyphicon glyphicon-arrow-down"></span>
						</button>
					</div>

					<input type="hidden" name="data[Categories][{{$index}}][Category][id]" ng-value="c.category.id">
					<input type="hidden" name="data[Categories][{{$index}}][CategoryOrder][weight]" ng-value="{{$index + 1}}">
					<input type="text" name="data[Categories][{{$index}}][Category][name]" ng-model="c.category.name" class="form-control" required autofocus>

					<div class="input-group-btn">
						<button type="button" class="btn btn-default" tooltip="<?php echo __d('net_commons', 'Delete'); ?>"
								ng-click="delete($index)">
							<span class="glyphicon glyphicon-remove"> </span>
						</button>
					</div>
				</div>
			</article>
		</div>
	</div>
</div>

