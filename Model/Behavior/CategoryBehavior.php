<?php
/**
 * Category Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * Category Behavior
 *
 * 該当ブロックのカテゴリーを登録します。
 *
 * #### サンプルコード
 * ```
 * public $actsAs = array(
 * 	'Categories.Category'
 * )
 * ```
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Categories\Model\Behavior
 */
class CategoryBehavior extends ModelBehavior {

/**
 * afterValidate is called just after model data was validated, you can use this callback
 * to perform any data cleanup or preparation if needed
 *
 * @param Model $model Model using this behavior
 * @return mixed False will stop this event from being passed to other behaviors
 */
	public function afterValidate(Model $model) {
		if (! isset($model->data['Categories'])) {
			return true;
		}
		$model->loadModels(array(
			'Category' => 'Categories.Category',
			'CategoryOrder' => 'Categories.CategoryOrder',
		));

		foreach ($model->data['Categories'] as $category) {
			$model->Category->set($category['Category']);
			if (! $model->Category->validates()) {
				$model->validationErrors['category_name'] = $model->Category->validationErrors['name'];
				return false;
			}

			$model->CategoryOrder->set($category['CategoryOrder']);
			if (! $model->CategoryOrder->validates()) {
				$model->validationErrors = Hash::merge(
					$model->validationErrors, $model->CategoryOrder->validationErrors
				);
				return false;
			}
		}

		return true;
	}

/**
 * beforeSave is called before a model is saved. Returning false from a beforeSave callback
 * will abort the save operation.
 *
 * @param Model $model Model using this behavior
 * @param array $options Options passed from Model::save().
 * @return mixed False if the operation should abort. Any other result will continue.
 * @throws InternalErrorException
 * @see Model::save()
 */
	public function beforeSave(Model $model, $options = array()) {
		parent::beforeSave($model, $options);

		if (! isset($model->data['Categories'])) {
			return true;
		}
		$model->loadModels(array(
			'Category' => 'Categories.Category',
			'CategoryOrder' => 'Categories.CategoryOrder',
		));

		$categoryKeys = Hash::combine($model->data['Categories'], '{n}.Category.key', '{n}.Category.key');

		//削除処理
		$conditions = array(
			'block_id' => $model->data['Block']['id']
		);
		if ($categoryKeys) {
			$conditions[$model->Category->alias . '.key NOT'] = $categoryKeys;
		}
		if (! $model->Category->deleteAll($conditions, false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		$conditions = array(
			'block_key' => $model->data['Block']['key']
		);
		if ($categoryKeys) {
			$conditions[$model->CategoryOrder->alias . '.category_key NOT'] = $categoryKeys;
		}
		if (! $model->CategoryOrder->deleteAll($conditions, false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		//登録処理
		foreach ($model->data['Categories'] as $category) {
			if (! $result = $model->Category->save($category['Category'], false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$category['CategoryOrder']['category_key'] = $result['Category']['key'];
			if (! $model->CategoryOrder->save($category['CategoryOrder'], false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}
		return true;
	}
}
