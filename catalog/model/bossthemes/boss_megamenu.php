<?php
class ModelBossthemesBossMegamenu extends Model {		

	public function getChilds( $id=null ){
		$sql = ' SELECT m.*, md.title FROM ' . DB_PREFIX . 'megamenu m LEFT JOIN '
								.DB_PREFIX.'megamenu_description md ON m.megamenu_id=md.megamenu_id AND language_id='.(int)$this->config->get('config_language_id') ;
		$sql .= ' WHERE m.`status`=1 ';
		if( $id != null ) {						
			$sql .= ' AND parent_id='.(int)$id;						
		}
		$sql .= ' ORDER BY `position`  ';
		$query = $this->db->query( $sql );						
		return $query->rows;
	}
	
}
?>