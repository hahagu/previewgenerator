<?php
declare(strict_types=1);
/**
 * @copyright Copyleft (c) 2019, Ignacio Nunez <nacho@ownyourbits.com>
 *
 * @author Ignacio Nunez <nacho@ownyourbits.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\PreviewGenerator\Migration;

use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;
use OCP\DB\Types;

class Version030200Date20210303111111 extends SimpleMigrationStep {

	/**
	 * @param IOutput $output
	 * @param \Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 * @return null|ISchemaWrapper
	 */
	public function changeSchema(IOutput $output, \Closure $schemaClosure, array $options) {
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();

		if (!$schema->hasTable('preview_generation')) {
			$table = $schema->createTable('preview_generation');
			$table->addColumn('id', 'integer', [
				'autoincrement' => true,
				'notnull' => true,
				'length' => 4,
			]);
			$table->addColumn('uid', 'string', [
				'notnull' => true,
				'length' => 256,
			]);
			$table->addColumn('file_id', 'integer', [
				'notnull' => true,
				'length' => 4,
			]);
			$table->addColumn('locked', Types::BOOLEAN, [
				'notnull' => true,
				'default' => 0,
			]);
			$table->setPrimaryKey(['id']);
		} else {
			$table = $schema->getTable('preview_generation');
			if (!$table->hasColumn('locked')) {
				$table->addColumn('locked', Types::BOOLEAN, [
					'notnull' => true,
					'default' => 0,
				]);
			}
		}
		return $schema;
	}
}