<?php
/**
 * Category Model
 *
 * @property Block $Block
 * @property Category $Category
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CategoriesAppModel', 'Categories.Model');

/**
 * Category Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Categories\Model
 */
class Category extends CategoriesAppModel {

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
		//'M17n.M17n'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Blocks.Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = array(
			//'id' => array(
			//	'numeric' => array(
			//		'rule' => array('numeric'),
			//		'message' => __d('net_commons', 'Invalid request.'),
			//		'allowEmpty' => true,
			//	),
			//),
			'block_id' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'name' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('categories', 'Category')),
					'allowEmpty' => false,
					'required' => true,
				),
			),
		);

		return parent::beforeValidate($options);
	}

/**
 * Get categories
 *
 * @param int $blockId blocks.id
 * @param int $roomId rooms.id
 * @return array Categories
 */
	public function getCategories($blockId, $roomId) {
		$conditions = array(
			'Block.id' => $blockId,
			'Block.room_id' => $roomId,
		);

		$this->bindModel(array(
			'belongsTo' => array(
				'CategoryOrder' => array(
					'className' => 'Categories.CategoryOrder',
					'foreignKey' => false,
					'conditions' => 'CategoryOrder.category_key=Category.key',
					'fields' => '',
					'order' => array('CategoryOrder.weight' => 'ASC')
				),
			)
		), false);

		$categories = $this->find('all', array(
			'recursive' => 0,
			'fields' => array(
				$this->alias . '.*',
				$this->CategoryOrder->alias . '.*',
			),
			'conditions' => $conditions,
		));

		return $categories;
	}

}
