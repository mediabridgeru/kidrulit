<?php

class ModelBossthemesBossMegamenu extends Model { 
	protected $children = array();
	
	public function getInfo( $id ){
		$sql = ' SELECT m.*, md.title FROM ' . DB_PREFIX . 'megamenu m LEFT JOIN '
							.DB_PREFIX.'megamenu_description md ON m.megamenu_id=md.megamenu_id AND language_id='.(int)$this->config->get('config_language_id') ;
	
		$sql .= ' WHERE m.megamenu_id='.(int)$id;						
	
		$query = $this->db->query( $sql );
		return $query->row;
	}
	
	public function getMenuDescription( $id ){
		$sql = 'SELECT * FROM '.DB_PREFIX."megamenu_description WHERE megamenu_id=".$id;
		$query = $this->db->query( $sql );
		return $query->rows;
	}
	public function getChild( $id=null ){
		$sql = ' SELECT m.*, md.title FROM ' . DB_PREFIX . 'megamenu m LEFT JOIN '
								.DB_PREFIX.'megamenu_description md ON m.megamenu_id=md.megamenu_id AND language_id='.(int)$this->config->get('config_language_id') ;
		if( $id != null ) {						
			$sql .= ' WHERE parent_id='.(int)$id;						
		}
		$sql .= ' ORDER BY `position`  ';
		$query = $this->db->query( $sql );						
		return $query->rows;
	}
	public function hasChild( $id ){
		return isset($this->children[$id]);
	}	
	
	public function getNodes( $id ){
		return $this->children[$id];
	}
	
	public function getTree( $id=null ){
		
		$childs = $this->getChild( $id );
		
		foreach($childs as $child ){
			$this->children[$child['parent_id']][] = $child;	
		}
		$parent = 1 ;
		$output = $this->genTree( $parent, 1 );
		return $output;
	}
	
	public function getDropdown( $id=null, $selected=1 ){
		$this->children = array();
		$childs = $this->getChild( $id );
		foreach($childs as $child ){
			$this->children[$child['parent_id']][] = $child;	
		}
		
		$output = '<select name="megamenu[parent_id]" >';
		$output .='<option value="1">ROOT</option>';	
		$output .= $this->genOption( 1 ,1, $selected );
		$output .= '</select>';
		return $output ;
	}
	
	public function genOption( $parent, $level=0, $selected ){
		$output = '';
		if( $this->hasChild($parent) ){
			$data = $this->getNodes( $parent );
			
			foreach( $data as $menu ){
				$select = $selected == $menu['megamenu_id'] ? 'selected="selected"':"";
				$output .= '<option value="'.$menu['megamenu_id'].'" '.$select.'>'.str_repeat("-",$level) ." ".$menu['title'].' (ID:'.$menu['megamenu_id'].')</option>';
				//$output .= $this->genOption(  $menu['megamenu_id'],$level+1, $selected );
			}				
		}
		
		return $output;
	}
	public function massUpdate( $data, $root ){
		$child = array();
		foreach( $data as $id => $parentId ){
			if( $parentId <=0 ){
				$parentId = $root;
			}
			$child[$parentId][] = $id;
		}
		
		foreach( $child as $parentId => $menus ){
			$i = 1;
			foreach( $menus as $menuId ){
				$sql = " UPDATE  ". DB_PREFIX . "megamenu SET parent_id=".(int)$parentId.', position='.$i.' WHERE megamenu_id='.(int)$menuId;
				$this->db->query( $sql );
				$i++;
			}
		}
 
	}
	public function genTree( $parent, $level ){
		if( $this->hasChild($parent) ){
			$data = $this->getNodes( $parent );
			$t = $level == 1?" sortable":"";
			$output = '<ol class="level'.$level. $t.' ">';
			foreach( $data as $menu ){
				$output .='<li id="list_'.$menu['megamenu_id'].'">
				<div><span class="disclose"><span></span></span>'.($menu['title']?$menu['title']:"").' (ID #'.$menu['megamenu_id'].') <span class="quickdel" rel="id_'.$menu['megamenu_id'].'">D</span><a><span class="quickedit" rel="id_'.$menu['megamenu_id'].'">[Edit]</span></a></div>';
				$output .= $this->genTree( $menu['megamenu_id'], $level+1 );
				$output .= '</li>';
			}	
			
			$output .= '</ol>';
			return $output;
		}
		return ;
	}
	
	public function editData( $data ){
		if( $data["megamenu"] ){
			if(  (int)$data['megamenu']['megamenu_id'] > 0 ){
				$sql = " UPDATE  ". DB_PREFIX . "megamenu SET  ";
				$tmp = array();
				foreach( $data["megamenu"] as $key => $value ){
					if($key=='params'){
						$value = json_encode($value);
					}
					if( $key != "megamenu_id" ){
						$tmp[] = "`".$key."`='".$this->db->escape($value)."'";
					}
				}
				$sql .= implode( " , ", $tmp );
				$sql .= " WHERE megamenu_id=".$data['megamenu']['megamenu_id'];
				
				$this->db->query( $sql );
			} else {
				$sql = "INSERT INTO ".DB_PREFIX . "megamenu ( `";
				$tmp = array();
				$vals = array();
				foreach( $data["megamenu"] as $key => $value ){
					if($key=='params'){
						$value = json_encode($value);
					}
					$tmp[] = $key;
					$vals[]=$this->db->escape($value);
				}				
				
			 	$sql .= implode("` , `",$tmp)."`) VALUES ('".implode("','",$vals)."') ";
				$this->db->query( $sql );
				$data['megamenu']['megamenu_id'] = $this->db->getLastId();
			}
		
		
		}
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
	
		if( isset($data["megamenu_description"]) ){
			$sql = " DELETE FROM ".DB_PREFIX ."megamenu_description WHERE megamenu_id=".(int)$data["megamenu"]['megamenu_id'] ;
			$this->db->query( $sql );
	 
			foreach( $languages as $language ){
				$sql = "INSERT INTO ".DB_PREFIX ."megamenu_description(`language_id`, `megamenu_id`,`title`) 
							VALUES(".$language['language_id'].",'".$data['megamenu']['megamenu_id']."','".$this->db->escape($data["megamenu_description"][$language['language_id']]['title'])."') ";
				$this->db->query( $sql );					
			}
		}
		return $data['megamenu']['megamenu_id'];
	}
	 
	 
	 public function delete( $id ){
		$sql = " DELETE FROM ".DB_PREFIX ."megamenu WHERE megamenu_id=".(int)$id ;
		$this->db->query( $sql );
		$sql = " DELETE FROM ".DB_PREFIX ."megamenu_description WHERE megamenu_id=".(int)$id ;
		$this->db->query( $sql );
	 
	 }
	 
	public function install(){
		$sql = " SHOW TABLES LIKE '".DB_PREFIX."megamenu'";
		$query = $this->db->query( $sql );
		
		if( count($query->rows) <=0 ){ 
			$sql = array();
			$sql[]  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu` (
			  `megamenu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `parent_id` int(11) NOT NULL DEFAULT '0',
			  `width` varchar(255) DEFAULT NULL,
			  `item` varchar(255) DEFAULT NULL,
			  `colums` varchar(255) DEFAULT '1',
			  `type` varchar(255) NOT NULL,
			  `show_title` smallint(6) NOT NULL DEFAULT '1',
			  `status` smallint(6) NOT NULL DEFAULT '1',
			  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0',
			  `position` int(11) unsigned NOT NULL DEFAULT '0',
			  `url` varchar(255) DEFAULT NULL,
			  `menu_class` varchar(25) DEFAULT NULL,
			  `params` text,
			  `content_text` text,
			  PRIMARY KEY (`megamenu_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;";
			$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu_description` (
				`megamenu_id` int(11) NOT NULL, 
				`language_id` int(11) NOT NULL, 
				`title` varchar(255) NOT NULL, 
				PRIMARY KEY (`megamenu_id`,`language_id`), 
				KEY `name` (`title`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
			$sql[] = "INSERT INTO `".DB_PREFIX."megamenu` (`megamenu_id`, `parent_id`, `width`, `item`, `colums`, `type`,`show_title`, `status`, `store_id`, `position`, `url`, `menu_class`, `params`, `content_text`) VALUES (2, 1, 1080, NULL, 1, 'url', 1, 1, 0, 0, '?route=common/home', NULL, NULL, NULL),(1, 0, 1080, NULL, 1, '', 0, 1, 0, 0, '', NULL, NULL, NULL);";

			$sql[] = "INSERT INTO `".DB_PREFIX."megamenu_description` (`megamenu_id`, `language_id`, `title`) VALUES (2, 1, 'Home');";

			foreach( $sql as $q ){
				$query = $this->db->query( $q );
			}
		}	
	}
}

?>