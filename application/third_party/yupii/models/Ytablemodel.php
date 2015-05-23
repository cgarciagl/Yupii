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
abstract class YTableModel extends CI_Model {

    var $table_name = '';
    var $id_field = 'id';
    var $canInsert = TRUE;
    var $canUpdate = TRUE;
    var $canDelete = TRUE;

    /**
     * Constructor de la clase
     */
    function __construct() {
        parent:: __construct();
        $this->load->database();
    }

    public function __get($attr) {
        if (isset(get_instance()->$attr)) {
            return get_instance()->$attr;
        } else return NULL;
    }

    /**
     * Devuelve un registro de la tabla a partir de su id
     *
     * @param int $id
     * @return object
     */
    function getById($id) {
        return $this->db->where($this->id_field, $id)
            ->get($this->table_name);
    }

    /**
     * Elimina de la tabla un registro a partir de su id
     *
     * @param int $id
     */
    function delete($id) {
        if ($this->canDelete) {
            $this->db->delete("$this->table_name", array(
                    "$this->id_field" => $id
                )
            );
        }
    }

    /**
     * Actualiza un registro de la tabla a partir de su id
     *
     * @param int $id
     * @param object , array $obj
     */
    function update($id, $obj) {
        if ($this->canUpdate) {
            $this->db->where($this->id_field, $id)
                ->update($this->table_name, $obj);
        }
    }

    /**
     * Inserta un nuevo registro en la tabla
     */
    function insert($obj) {
        if ($this->canInsert) {
            $this->db->insert($this->table_name, $obj);
            return $this->db->insert_id();
        } else return NULL;
    }

    /**
     * Devuelve el número total de registros en la tabla
     *
     * @return int
     */
    function countAll() {
        return $this->db->countAll($this->table_name);
    }

    /**
     * Devuelve el número de registros filtrados para la tabla
     *
     * @return int
     */
    function countAllResults() {
        return $this->db->count_all_results($this->table_name);
    }

    /**
     * Devuelve los registros de la tabla ordenados por un criterio
     *
     * @param string $order_by
     * @return object
     */
    function listAll($order_by = NULL) {
        if ($order_by == NULL) {
            $order_by = $this->id_field;
        }
        return $this->db->order_by($order_by, 'asc')
            ->get($this->table_name);
    }

    /**
     * Inicia el cacheo de instrucciones de sql
     */
    function startCache() {
        $this->db->start_cache();
    }

    /**
     * Termina el cacheo de instrucciones de sql
     */
    function stopCache() {
        $this->db->start_cache();
    }

    /**
     * Asigna una condición al modelo para filtrar los resultados
     *
     * @param string $field al campo a partir del cual se hará el filtro
     * @param string $value el valor que se ha de buscar
     */
    function setWhere() {
        if (func_num_args() == 2) {
            $field = func_get_arg(0);
            $value = func_get_arg(1);
            $this->db->where($field, $value);
        }
        return $this;
    }

    /**
     *  Pega una tabla adicional a la consulta
     *
     * @param $table
     * @param $cond
     * @param string $type
     * @return mixed
     */
    function join($table, $cond, $type = 'INNER') {
        $this->db->join($table, $cond, $type);
        return $this;
    }

    /**
     * Asigna un orden para los resultados a mostrar
     *
     * @param string $orderby critero de ordenamiento
     */
    function setOrderBy($orderby) {
        $this->db->order_by($orderby);
        return $this;
    }

    /**
     * Agrega un campo a la selección
     *
     * @param string $select valor a agregar a la selección
     */
    function select($select = '*') {
        $this->db->select($select);
        return $this;
    }

    /**
     * Determina el número de registros a devolver
     *
     * @param int $value número de registros
     */
    function limit($value) {
        $this->db->limit($value);
        return $this;
    }

    /**
     * Devuelve los registros de la tabla
     *
     * @param string $table tabla a seleccionar
     * @return object
     */
    function get() {
        return $this->db->get($this->table_name);
    }


}
