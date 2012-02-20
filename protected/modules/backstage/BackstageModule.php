<?php

class BackstageModule extends CWebModule {

	public $models = array();

	/**
	 * @var models that are present in the ./protected/models directory
	 */
	public $modelsPresent = array();

	var $autoloadModels = true;

	public function init() {
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		// import the module-level models and components
		$this->setImport(array(
			'backstage.models.*',
			'backstage.components.*',
		));
		#Init models.
		$this->buildModelsOptions();
		try {

		} catch (BackstageRelationNotFoundException $e) {

		}
		$this->buildModelsColumnsOptions();
		#var_dump($this->models['Article']['create_by']);
		#var_dump(BackstageHelper::getModelBelongsTo(User::model(), 'create_by'));
	}

	public function beforeControllerAction($controller, $action) {
		if (parent::beforeControllerAction($controller, $action)) {
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}


	/**
	 * Finds all the models in the directory and merge them with the ones
	 * found in options.
	 */
	private function buildModelsOptions() {
		if ($this->autoloadModels) {
			$this->modelsPresent = BackstageHelper::getModels();
			$this->models = CMap::mergeArray($this->models, $this->modelsPresent);
			$undefined_models = array_keys(array_diff_key($this->models, $this->modelsPresent));
			if (!empty($undefined_models)) {
				throw new BackstageModelNotFoundException("Model '{$undefined_models[0]}' is not present in ./protected/models but is found in Backstage module's 'models' key. You may need to check your ./protected/config/main.php");
			}

		}
	}

	/**
	 * Find all the columns for the respective models and merge them into options.
	 * Additionally this also assigns default controls if not present.
	 */
	private function buildModelsColumnsOptions() {
		foreach ($this->models as $model_k => &$model_v) {
			if ($model_v !== false) {
				$loaded_columns = $model_k::model()->metaData->columns;
				#Check if the column is not defined.
				$undefined_columns = array_keys(array_diff_key($model_v, $loaded_columns));
				if (!empty($undefined_columns)) {
					throw new BackstageColumnNotFoundException("Column '{$undefined_columns[0]}' is not defined in model {$model_k} but is found in Backstage module's 'models' key. You may need to check your ./protected/config/main.php");
				}
				#Converted to array as it is more consistent with options.
				$model_v = CMap::mergeArray(array_map('get_object_vars', $loaded_columns), $model_v);
				foreach ($model_v as $column_k => &$column_v) {
					$column_v['control'] = $this->assignControl($column_v);
					$column_v['visible'] = $this->assignVisible($column_v);
					$column_v['locked'] = $this->assignLocked($column_v);
				}
			}
		}
	}

	/**
	 * With the column data, discover the most suited HTML control to use.
	 *
	 * @param array $column_data Array converted from any one of metaData->columns
	 * @return string The type of control suitable.
	 */
	private function assignControl($column_data) {
		if (isset($column_data['control'])) {
			if ($column_data['control'] == 'relation') {
				$model_belongs_to = BackstageHelper::findAllModelBelongsTo(User::model(), 'create_by');
				if (empty($model_belongs_to)) {
					throw new BackstageRelationNotFoundException;
				}
			}
			return $column_data['control'];
		}
		if (BackstageHelper::endsWith($column_data['name'], array('_rich'))) {
			return 'richtext';
		}
		if (BackstageHelper::endsWith($column_data['name'], array('_url', '_uri'))) {
			return 'url';
		}
		if (strcasecmp($column_data['name'], 'email') === 0) {
			return 'email';
		}
		if (strcasecmp($column_data['dbType'], 'text') === 0) {
			return 'textarea';
		}
		if (strcasecmp($column_data['dbType'], 'datetime') === 0) {
			return 'datetime';
		}
		if (strcasecmp($column_data['dbType'], 'date') === 0) {
			return 'date';
		}
		return 'textfield';
	}

	/**
	 * With the column data, discover the most suited visibility to use.
	 *
	 * @param array $column_data Array converted from any one of metaData->columns
	 * @return mixed An array of the views where the type of visibility are most
	 * appropriate. A boolean of false if visible is negative for everything.
	 */
	private function assignVisible($column_data) {
		if (isset($column_data['visible'])) {
			if ($column_data['visible'] === false) {
				return false;
			}
			#This means it is an array and it is not an empty one.
			if (is_array($column_data['visible']) && isset($column_data['visible'][0])) {
				return $column_data['visible'];
			}
		} else {
			#What to do when there is no indication. Guess?
			#Since autoincrement, don't show.
			if (isset($column_data['autoIncrement']) && $column_data['autoIncrement'] === true) return false;
		}
		return array('index', 'view', 'search', 'create', 'update');
	}

	/**
	 * With the column data, discover if the item should be locked and be place
	 * in the sidebar.
	 *
	 * @param array $column_data Array converted from any one of metaData->columns
	 * @return mixed An array of the views where the type of visibility are most
	 * appropriate. A boolean of false if visible is negative for everything.
	 */
	private function assignLocked($column_data) {
		if (isset($column_data['locked'])) {
			if ($column_data['locked'] === false) {
				return false;
			}
			#This means it is an array and it is not an empty one.
			if (is_array($column_data['locked']) && isset($column_data['locked'][0])) {
				return $column_data['locked'];
			}
		} else {
		}
		return array();
	}
}

class BackstageRelationNotFoundException extends BackstageException {}
class BackstageColumnNotFoundException extends BackstageException {}
class BackstageModelNotFoundException extends BackstageException {}
class BackstageException extends Exception {}