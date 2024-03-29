<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Yupii
 *
 * a thirdparty asset that transforms CodeIgniter into a Business Framework !!
 *
 * @package        Yupii
 * @author        Carlos García Trujillo
 * @link        https://github.com/cgarciagl/Yupii
 * @since        Version 1.0
 */

/**
 * Clase Base para los datasets de Yupii
 */
abstract class YDataset extends YController
{

    protected $title = '';

    /**
     * @var YDatasetModel
     */

    public $modelo = NULL;

    /**
     * Constructor de la clase
     */
    function __construct()
    {
        parent::__construct();
        $this->setModel($this->_getOrConstructModel());
    }

    public function __call($method, $args)
    {
        if (isset($this->$method)) {
            $func = $this->$method;
            return call_user_func_array($func, $args);
        } else {
            return NULL;
        }
    }

    public function getModel()
    {
        return $this->modelo;
    }

    public function setModel($model)
    {
        $this->modelo             = $model;
        $this->modelo->controller = $this;
    }

    /**
     * Retorna un objeto de la clase YDatasetModel y lo asigna a la propiedad "modelo"
     *
     * @return YConcreteDatasetModel
     */
    private function _getOrConstructModel()
    {
        if (is_file(APPPATH . 'models/' . $this->getClassName() . '.php')) {
            Yupii::get_CI()->load->model($this->getClassName(), 'modelo');
        } else {
            //this is weird and ugly but is the only way to make it work on CI3...
            Yupii::get_CI()->load->model('YConcreteDatasetModel', 'modelo');
            if (ifSet($this->modelo) == NULL) {
                $this->modelo = new YConcreteDatasetModel();
            }
        }
        return ifSet($this->modelo, NULL);
    }

    /**
     * Asigna el título de la relación
     *
     * @param string $title
     */
    function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Retorna el título de la relación
     *
     * @return string
     */
    function getTitle()
    {
        return $this->title;
    }

    /**
     * Determina el nombre de la tabla a utilizar como base
     *
     * @param string $t Nombre de la tabla
     */
    function setTableName($t)
    {
        $this->modelo->table_name = $t;
    }

    /**
     * Determina que campo ha de usarse como llave primaria para la relación
     *
     * @param string $fieldName
     */
    function setIdField($fieldName)
    {
        $this->modelo->id_field = $fieldName;
    }

    /**
     * Determina que campos se usaran para mostrar en la vista de tabla
     *
     * @param array $fieldNames Arreglo con los nombres de campos
     */
    function setTableFields($fieldNames = array())
    {
        $this->modelo->tablefields = $fieldNames;
    }

    /**
     * Agrega un campo a la lista de campos de la definición del modelo
     *
     * @param string $fieldName Nombre del campo a agregar
     * @param array $a Arreglo con las definiciones del campo "label" , "rules", "value"
     */
    function addField($fieldName, $a = array())
    {
        return $this->modelo->addFieldFromArray($fieldName, $a);
    }

    /**
     * Asocia una búsqueda con un campo específico
     *
     * @param string $fieldName
     * @param string $controllerclassname
     * @param string $filter
     */
    function addSearch($fieldName, $controllerclassname, $filter = '')
    {
        if (!array_key_exists($fieldName, $this->modelo->ofieldlist)) {
            $this->modelo->ofieldlist[$fieldName] = new YSimpleTextField($fieldName);
        }
        $field                                  = $this->modelo->ofieldlist[$fieldName];
        $this->modelo->ofieldlist[$fieldName] = new YSearchField($field);
        $this->modelo->ofieldlist[$fieldName]->setController($controllerclassname);
        $this->modelo->ofieldlist[$fieldName]->setFilter($filter);
        return $this->modelo->ofieldlist[$fieldName];
    }

    function removeField($fieldName)
    {
        if (array_key_exists($fieldName, $this->modelo->ofieldlist)) {
            unset($this->modelo->ofieldlist[$fieldName]);
        }
    }

    /**
     * Determina la etiqueta que ha de tener un campo los formularios y tablas
     *
     * @param string $fieldName Campo a actualizar
     * @param string $label Etiqueta que mostrar
     */
    function addLabel($fieldName, $label)
    {
        $this->modelo->ofieldlist[$fieldName]->setLabel($label);
    }

    /**
     * Asigna las reglas de validación para el campo especificado
     *
     * @param string $fieldName Campo a actualizar
     * @param string $rules Reglas a aplicar
     */
    function addRules($fieldName, $rules)
    {
        $this->modelo->ofieldlist[$fieldName]->setRules($rules);
    }

    function addDefault($fieldName, $default)
    {
        $this->modelo->ofieldlist[$fieldName]->setDefault($default);
    }

    /**
     * Setter para la propiedad canInsert del modelo
     *
     * @param bool $value
     */
    function setCanInsert($value)
    {
        $this->modelo->canInsert = (bool)$value;
    }

    /**
     * Setter para la propiedad canUpdate del modelo
     *
     * @param bool $value
     */
    function setCanUpdate($value)
    {
        $this->modelo->canUpdate = (bool)$value;
    }

    /**
     * Setter para la propiedad canDelete del modelo
     *
     * @param bool $value
     */
    function setCanDelete($value)
    {
        $this->modelo->canDelete = (bool)$value;
    }

    /**
     * Getter para la propiedad canInsert del modelo
     *
     */
    function canInsert()
    {
        return (bool)$this->modelo->canInsert;
    }

    /**
     * Getter para la propiedad canUpdate del modelo
     *
     */
    function canUpdate()
    {
        return (bool)$this->modelo->canUpdate;
    }

    /**
     * Getter para la propiedad canDelete del modelo
     *
     */
    function canDelete()
    {
        return (bool)$this->modelo->canDelete;
    }

    /**
     * Función "abstracta" para aplicar filtros al catálogo
     */
    public function _filters()
    {
    }

    /**
     * Función que aplica los filtros usando la cache de querys de Codeigniter
     */
    protected function applyFilters()
    {
        $this->modelo->startCache();
        $this->_filters();
        $this->modelo->stopCache();
    }

    /**
     * Disparador Callback (Trigger) para Antes de Insertar
     */
    function _beforeInsert(&$a)
    {
    }

    /**
     * Disparador Callback (Trigger) para Después de Insertar
     */
    function _afterInsert()
    {
    }

    /**
     * Disparador Callback (Trigger) para Antes de Actualizar
     */
    function _beforeUpdate(&$a)
    {
    }

    /**
     * Disparador Callback (Trigger) para Después de Actualizar
     */
    function _afterUpdate()
    {
    }

    /**
     * Disparador Callback (Trigger) para Antes de Borrar
     */
    function _beforeDelete()
    {
    }

    /**
     * Disparador Callback (Trigger) para Después de Borrar
     */
    function _afterDelete()
    {
    }
}
