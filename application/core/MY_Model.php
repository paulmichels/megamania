<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class MY_Model extends CI_Model {
  
    /**
    * ACL for a logged in user
    * @var mixed
    */
    public $acl = NULL;

    protected $table = '';
    protected $entity = '';

    /**
    * Class constructor
    */
    public function __construct()
    {
        parent::__construct();
    }

    public function getTable() {
        return $this->table;
    }

    public function setTable( $TableName ) {
        $this->table = $TableName;
    }

    public function getEntity(){
        return $this->entity;
    }

    public function setEntity($EntityClassName){
        $this->entity = $EntityClassName;
    }

    /**
    * Créer
    *
    * @param $this->$entity $obj
    * @return bool
    */

    public function create($values) {
        if ($this->db->set($values->get_object_vars())->insert($this->getTable())) 
            return $this->db->insert_id();
        else {
             return false;
        }
    }

    /**
    * Remplacer
    *
    * @param $this->$entity $obj
    * @return bool
    */

    public function replace($values, $where=array()){
      $this->db->where($where);
      return $this->db->replace($this->getTable(), $values->get_object_vars());
    }
   

    /**
    * Lire
    *
    * @param array $where
    * @return $this->$entity
    */

    public function read($where = array()) {
        $req = $this->db->get_where($this->getTable(), $where);
        return $req->custom_result_object($this->entity);
    }


    /**
    * Modifier
    *
    * @param array $where, $this->$entity $obj
    * @return bool
    */

    public function update($where, $obj) {
        return $this->db->where($where)->update($this->getTable(), $obj->get_object_vars());
    }


    /**
    * Supprimer
    *
    * @param array $where
    * @return bool
    */

    public function delete($where = array()) {
      return $this->db->where($where)->delete($this->getTable());
    }


    /**
    * Compter
    *
    * @param array $where
    * @return int
    */

    public function countItems($where = null) {
        if ( $where == null )
            return $this->db->count_all_results($this->getTable());
        else
            return $this->db->where($where)->count_all_results($this->getTable());
    }

    /**
    * Get all of the ACL records for a specific user
    */
    public function acl_query( $user_id, $called_during_auth = FALSE ){
        // ACL table query
        $query = $this->db->select('b.action_id, b.action_code, c.category_code')
               ->from( config_item('acl_table') . ' a' )
               ->join( config_item('acl_actions_table') . ' b', 'a.action_id = b.action_id' )
               ->join( config_item('acl_categories_table') . ' c', 'b.category_id = c.category_id' )
               ->where( 'a.user_id', $user_id )
               ->get();

        /**
        * ACL becomes an array, even if there were no results.
        * It is this change that indicates that the query was 
        * actually performed.
        */
        $acl = [];

        if( $query->num_rows() > 0 ){
            // Add each permission to the ACL array
            foreach( $query->result() as $row ){
                // Permission identified by category + "." + action code
                $acl[$row->action_id] = $row->category_code . '.' . $row->action_code;
            }
        }
        if( $called_during_auth OR $user_id == config_item('auth_user_id') ){
            $this->acl = $acl;
        }
        return $acl;
    }


    /**
    * Check if ACL permits user to take action.
    *
    * @param  string  the concatenation of ACL category 
    *                 and action codes, joined by a period.
    * @return bool
    */

    public function acl_permits( $str ){
           list( $category_code, $action_code ) = explode( '.', $str );

           // We must have a legit category and action to proceed
           if( strlen( $category_code ) < 1 OR strlen( $action_code ) < 1 )
                   return FALSE;

           // Get ACL for this user if not already available
           if( is_null( $this->acl ) )
           {
                   if( $this->acl = $this->acl_query( config_item('auth_user_id') ) )
                   {
                           $this->load->vars( ['acl' => $this->acl] );
                           $this->config->set_item( 'acl', $this->acl );
                   }
           }

           if( 
                   // If ACL gives permission for entire category
                   in_array( $category_code . '.*', $this->acl ) OR  
                   in_array( $category_code . '.all', $this->acl ) OR 

                   // If ACL gives permission for specific action
                   in_array( $category_code . '.' . $action_code, $this->acl )
           )
           {
                   return TRUE;
           }

           return FALSE;
    }


    /**
    * Check if the logged in user is a certain role or 
    * in a comma delimited string of roles.
    *
    * @param  string  the role to check, or a comma delimited
    *                 string of roles to check.
    * @return bool
    */

    public function is_role( $role = '' )
    {
           $auth_role = config_item('auth_role');

           if( $role != '' && ! empty( $auth_role ) )
           {
                   $role_array = explode( ',', $role );

                   if( in_array( $auth_role, $role_array ) )
                   {
                           return TRUE;
                   }
           }

           return FALSE;
    }

      /**
     * Retrieve the true name of a database table.
     *
     * @param  string  the alias (common name) of the table
     *
     * @return  string  the true name (with CI prefix) of the table
     */
    public function db_table( $name )
    {
      $name = config_item( $name );

      return $this->db->dbprefix( $name );
    }
}

