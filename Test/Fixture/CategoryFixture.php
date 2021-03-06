<?php
/**
 * CategoryFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * CategoryFixture
 */
class CategoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID |  |  | '),
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'comment' => 'block id |  ブロックID | blocks.id | '),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'category key | カテゴリーKey |  | ', 'charset' => 'utf8'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6, 'unsigned' => false, 'comment' => 'language id | 言語ID | languages.id | '),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'category name | カテゴリー名 |  | ', 'charset' => 'utf8'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'block_id' => '2',
			'key' => 'category_1',
			'language_id' => '2',
			'name' => 'Category 1',
			'created_user' => '1',
			'created' => '2015-01-28 04:56:56',
			'modified_user' => '1',
			'modified' => '2015-01-28 04:56:56'
		),
		array(
			'id' => '2',
			'block_id' => '2',
			'key' => 'category_2',
			'language_id' => '2',
			'name' => 'Category 2',
			'created_user' => '1',
			'created' => '2015-01-28 04:56:56',
			'modified_user' => '1',
			'modified' => '2015-01-28 04:56:56'
		),
		array(
			'id' => '3',
			'block_id' => '2',
			'key' => 'category_3',
			'language_id' => '2',
			'name' => 'Category 3',
			'created_user' => '1',
			'created' => '2015-01-28 04:56:56',
			'modified_user' => '1',
			'modified' => '2015-01-28 04:56:56'
		),
	);

}
